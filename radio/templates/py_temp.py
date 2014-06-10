from string import *
import sys
import MySQLdb
# This is just a skeleton, something for you to start with.

songnumber = -1

curr_song_name = ''
curr_song_artist = ''
curr_song_id = ''
db = None
# Function called to initialize your python environment.
# Should return 1 if ok, and 0 if something went wrong.
def ices_init ():
        print 'Executing initialize() function..'
        return 1

# Function called to shutdown your python enviroment.
# Return 1 if ok, 0 if something went wrong.
def ices_shutdown ():
        print 'Executing shutdown() function...'
        return 1

# Function called to get the next filename to stream.
# Should return a string.
def ices_get_next ():
        _db = get_db_connection();
        cur = db.cursor()
        cur.execute("select id,isrc,file from (SELECT program_id FROM saregama_db.channel_programs  chn_prg \
                        inner join saregama_db.radio_stations chn on chn_prg.channel_id=chn.station_id \
                        where \
                        chn.station_id=42 and \
                        chn.status=1 and chn_prg.status=1 and ( \
                        now() between chn_prg.start_date and chn_prg.end_date) \
                        and \
                        (CURTIME() BETWEEN chn_prg.start_time AND chn_prg.end_time) \
                        limit 1) as ProgramId inner join program_song as PS where \
                        PS.status =0 \
                        order by flag asc,rank asc \
                        limit 1 \
                        ")
        for row in cur.fetchall() :
                print row[0]
        #return 'Very nice song.mp3'
        return "/home/ec2-user/media/audio/song.mp3";


# This function, if defined, returns the string you'd like used
# as metadata (ie for title streaming) for the current song. You may
# return null to indicate that the file comment should be used.
def ices_get_metadata ():
        return curr_song_name+' -- '+curr_song_artist

# Function used to put the current line number of
# the playlist in the cue file. If you don't care about this number
# don't use it.
def ices_get_lineno ():
        global songnumber
        print 'Executing get_lineno() function...'
        songnumber = songnumber + 1
        return songnumber

def get_db_connection ():
        global db
        db = MySQLdb.connect(host="localhost",user="root",passwd="root",db="saregama_db")
        return db;
