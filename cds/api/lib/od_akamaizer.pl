#!/usr/bin/perl -w
##
##  COPYRIGHT  (c) 2000 Akamai Technologies Inc.,
##      All Rights Reserved.
##
## PROPRIETARY - AKAMAI AND AUTHORIZED CLIENTS ONLY.
##
## This document contains proprietary information that shall
## be distributed or routed only within Akamai Technologies
## Inc. (Akamai), and its authorized clients, except
## with written permission of Akamai.
##
##################################################################
## The following documentation is used for pod, the `plain old
## documentation' feature built into perl.  This text should be
## reasonably readable even without using pod, but you can obtain
## nicely formatted versions using commands like `pod2man' on this
## source file.
##################################################################

=head1 NAME

 od_akamaizer.pl - Convert Uniform Resource Locators (URLs) 
 into Akamai Resource Locators (ARLs) for On-Demand Streaming.

=head1 VERSION

 version 3.1
 $Id: //akamai/akamaizer/streaming/perl/od_akamaizer.pl#3 $

=head1 DESCRIPTION

 The Akamai od_akamaizer script acts to convert Uniform Resource 
 Locators (URLs) into Akamai Resource Locators (ARLs), for use 
 with the Akamai Freeflow Streaming (tm) System.

 The od_akamaizer is most commonly used to modify whole directory 
 heirarchies of metafiles, converting appropriate URLs into ARLs 
 (a process called "akamaizing").

 The od_akamaizer can also be used to convert URLs directly from 
 the command line, or to convert a single file.  

 The od_akamaizer takes the following options. 


 --cpcode <cpcode>       Required field. The CP Code is your Akamai 
                         assigned code that identifies your content 
                         on the Akamai network. If a CP Code has not
                         been assigned to you, check with your
                         Account Manager. Valid range is 1-99999

 --find <dir>            This option causes od_akamaizer to recursively
                         descend into the named subdirectory, (much
                         like the 'find' program) searching for files
                         that end in common metafile extensions such
                         as '.asx' or '.ram'. These original files
                         are backed up to a .bak extension.

                         NOTE: this option may be specified multiple
                         times, causing od_akamaizer to perform the find
                         operation in each named directory.  You are
                         cautioned to avoid specifying overlapping
                         directory sets.

 --url <url>             This option specifies a URL to transform.

                         When called in this manner, od_akamaizer ignores
                         the '-in' option.
                         The URL is translated to an ARL and printed
                         to the specified output.

                         NOTE: This option may be specified multiple
                         times.  The translated URLs will be written
                         to the specified output in the order found on
                         the command line.

 --in <filename>         The name of a file to use as input.  If no
                         filename is specified, the standard input is
                         used.  The file is treated as a metafile and
                         parsed accordingly

 --out <filename>        The name of a file to use for output.  If
                         the named file exists, it will be
                         overwritten.  If no filename is specified,
                         the standard output is used.

 --munge                 Encode original URL. Obscures the original URL,
                         but is not cryptographically secure.

 --ad                    Invokes Real Ad Plug-in on Real Server. This
                         should only be used on Real SMIL files that are
                         invoking an ad server.

 --objver <identifier>	 Specifies a manual object version identifier (no
                         spaces) to be used intead the default hexadecimal 
			 representation of the time of Akamaization as the 
			 object data in the ARL.

 --verbose               This option causes od_akamaizer to be more
                         verbose while running. 

 --help                  Usage information.

=head1 AKAMAI RESOURCE LOCATOR (ARL)

 An akamaized reference takes one of the following forms,
 depending on streaming media format:

 WMT on-demand, QT on-demand:

  http://aSERIAL.DOMAIN/TYPECODE/SERIAL/CPCODE/OBJDATA/CPHOST/CPPATH

 Real on-demand:

  http://aSERIAL.DOMAIN/ondemand/TYPECODE/SERIAL/CPCODE/OBJDATA/CPHOST/CPPATH

 SERIAL  - is the serial number used by the Freeflow flow controller.
           The serial number appears in the both the host and path
           portions of the url, in order to facilitate reporting.

 DOMAIN  - is the network domain used to retrieve the resource from
           the Freeflow Streaming (tm) global hosting system. This 
           will be 'm.akastream.net' for Windows Media, 'r.akareal.net'
           for Real, and 'q.kamai.net' for QuickTime.

 TYPECODE - is a single digit code that can be used to signal certain
           types of operations to the Freeflow Streaming (tm) server.
           This will almost always be '7' for on-demand.

 CPCODE -  is a numeric indication of the content provider that is
           associated with this request.  Requests of the Freeflow
           system will only be honored if they access a registered
           web server hostname!  Any new server hostnames MUST be
           registered with Akamai before requests will be honored.

 OBJDATA - is information that, when changed, signals the Akamai 
           edge servers to refresh any data cached for that particular
           object. You *MUST* regenerate this object data each time 
           the file contents are changed; otherwise, there is a strong 
           risk of serving stale data!

 CPHOST  - is the web server hostname of the content provider.
           This name MUST be registered with Akamai in order for
           Freeflow requests to be honored!  

 CPPATH  - is the path component of the content provider URL.  The
           Freeflow system attempts to retrieve the resource from
           http://CPHOST/CPPATH in order to seed the Freeflow Streaming
           system.

=head1 EXAMPLES

=over 4

=item od_akamaizer.pl -help

 This will print a usage message.

=item od_akamaizer.pl --cpcode <CPCODE> --find /www/media

 This invocation will cause od_akamaizer to recursively scan through the
 directory '/www/media', searching for metafiles to process.  Each
 found file is copied to 'filename.bak' before processing.  The
 post-processed file is writen to a new file with the same name as the
 original.

=item od_akamaizer --cpcode <CPCODE> --url http://www.content.com/media/movie.asf

 This invocation will cause od_akamaizer to write a matching ARL to the
 standard output.  If specified multiple times, multiple ARLs will be
 output in the same order.

=item od_akamaizer --cpcode <CPCODE> --in input.ram -out output.ram 

 This invocation will cause od_akamaizer to process the file named
 'input.ram', and write the processed data to 'output.ram'.  The
 original file, 'input.ram', should not be modified by this process.

=item od_akamaizer --cpcode <CPCODE> --in input.asx

 This invocation will cause od_akamaizer to copy the file named 'input.asx'
 to the new name 'input.asx.bak'.  It wil then process the file named
 'input.asx', and write the processed data to 'input.asx',
 overwriting the original file.

=item od_akamaizer --cpcode <CPCODE> --in movie.refmov

 This invocation will cause od_akamaizer to read the file named 'movie.refmov'
 and use the input to generate a QuickTime reference movie. The input file
 should be in text format with one bitrate (divided by 10) and one HTTP
 URL to a QuickTime movie (in order to be streamed, the QuickTime movie should
 be encoded "hinted" with the hints "optimized for server".
 
 Valid data rates are:
	1400 (14k modem)
	2800 (28k modem)
	5600 (56k modem)
	11200 (ISDN)
	150000 (T1)
	INF (Infinite)
	
 A sample input file might look like:
	1400 http://www.foo.com/movies/movie14k.mov
	2800 http://www.foo.com/movies/movie28k.mov
	5600 http://www.foo.com/movies/movie56k.mov

 The output in this example would be a QuickTime reference movie with the 
 name movie.mov. The original text input movie.refmov would remain unchanged.

=back

=head1 REQUIREMENTS

 The od_akamaizer currently requires the perl in order to run correctly.  

 Perl can be obtained at the Compehensive Perl Archive Network (CPAN):

        http://www.perl.com/CPAN/ 

 Precompiled modules for WIN32 area available from:

	http://www.ActiveState.com/packages/

=over 4

=item * Perl 5.004 or greater.

=back

=head1 FEEDBACK

 If you have any questions, problems, suggestions, or comments to
 offer regarding the od_akamaizer, please feel free to contact us at
 <launcher@akamai.com>.

=head1 COPYRIGHT

 COPYRIGHT  (c) 2000-5 Akamai Technologies Inc.,
      All Rights Reserved.

=cut

##################################################################
## end pod documentation section
##################################################################

use strict;
use File::Find;
use FileHandle;
use Getopt::Long;
use File::Copy;
use Digest::Perl::MD5 qw(md5 md5_hex md5_base64);
use Cwd;

my $config_directory = cwd();

## ArlRewrite rule
#   Whenever an ARL is made, all occurrences of the string $rewrite_input
#   are replaced with $rewrite_output. No rewriting is done if
#   rewrite_input is undef or empty
my $rewrite_input = "";
my $rewrite_output = ".net";


## extensions of files that we should akamaize
my @good_wmt_files 	 = qw(asx wax);
my @good_real_files 	 = qw(ram rpm);
my @good_qt_files 	 = qw(mov);
my @good_batch_mov_input = qw(batmov);	# indicates batch movie special processing
my @good_ref_mov_input 	 = qw(refmov);	# indicates ref movie special processing
my @good_smil_files 	 = qw(smi sml smil);
my @good_real_smil_files = qw(smi smil); # special case, requires Real ARL

# @good_files is a superset of all good file types:
my @good_files = ();
push(@good_files, @good_wmt_files, @good_real_files, @good_qt_files, 
     @good_batch_mov_input, @good_ref_mov_input, @good_smil_files);

## files that should not be akamaized
my @bad_files = qw(DELETED);

## extensions of the media files to akamaize
my @wmt_media_types = qw(asf wma wmv);
my @real_media_types = qw(rm ra rt rp swf);
my @qt_media_types = qw(mov sdp mp4 3gp 3g2);
#@freeflow_media_types = qw(jpg gif avi mov wav mp3);

## media objects that should not be akamaized
my @bad_media = qw(mfile.akamai.com ads.oxygen.com bfast.com ad.doubleclick.net adforce.net imgis.com \/1pixel.gif);

my $output               = new FileHandle(">&STDOUT") or die "Can't open stdout";
my $error                = new FileHandle(">&STDERR") or die "Can't open stderr";

my $debug             = 0;
my $verbose           = 0;
#$input             = \*STDIN;
my $tmp_file          = "$config_directory/.tmp_akamaizer_file.$$";

$: = " \n\r"; # \r to support macs (abartov@akamai.com)

##################################################################
## Code starts here
##################################################################

# first, parse arguments

my $in_filename;
my $out_filename;
my $helpflag;
my $cpcode;
my $mungeEnabled;
my $realAdPlugin;
my $noReAkamaize;
my $objver;
my $reakamaize        = 1;
my @transurls = ();
my @finddirs  = ();
my $AdultEnabled;
my $DomesticEnabled;
my $FastEnabled;
my $EuropeEnabled;
my $MIN_CPCODE = 1;
my $MAX_CPCODE = 999999;


my $getOptions = &GetOptions(
			     "in=s", \$in_filename,
			     "out=s", \$out_filename,
			     "url=s@", \@transurls,
			     "help", \$helpflag,
			     "cpcode=s", \$cpcode,
                             "verbose", \$verbose,
			     "munge", \$mungeEnabled,
			     "ad", \$realAdPlugin,
			     "noreakamaize", \$noReAkamaize,
			     "find=s@", \@finddirs,
			     "adult", \$AdultEnabled,
			     "usa", \$DomesticEnabled,
			     "1m", \$FastEnabled,
                             "europe", \$EuropeEnabled,
			     "objver=s", \$objver
			     );

if ( $noReAkamaize ) {
    $reakamaize = 0;
}

my $bad_media = join("|",@bad_media);

my $good_file_regexp = join("|",@good_files);
my $good_wmt_file_regexp = join("|",@good_wmt_files);
my $good_real_file_regexp = join("|",@good_real_files);
my $good_smil_file_regexp = join("|",@good_smil_files);
my $good_real_smil_file_regexp = join("|",@good_real_smil_files);
my $good_qt_file_regexp = join("|",@good_qt_files);
my $good_ref_mov_input_regexp = join("|",@good_ref_mov_input);
my $good_batch_mov_input_regexp = join("|",@good_batch_mov_input);
my $bad_file_regexp = join("|",@bad_files);


# This is the section for the new blocking arl format
my ($stream_type) = 'v'; # v for vod content
my ($stream_prop) = 'g'; # default is g for general
if ($AdultEnabled || $DomesticEnabled || $FastEnabled || $EuropeEnabled) {
  $stream_prop = '';
  if ($DomesticEnabled) {
     $stream_prop = 'd';   # d for domestic
  }
  if ($AdultEnabled) {
     $stream_prop .= 'p';  # p for adult content	
  }
  if ( $FastEnabled) {
     $stream_prop .= 't';  # t for > 1 Mbps content	
  }
  if ( $EuropeEnabled) {
     $stream_prop .= 'e';  # e for european content	
  }
}


#$media_type_regexp = join("|",@qt_media_types,@wmt_media_types,@real_media_types,@freeflow_media_types);
my $qt_type_regexp = join("|",@qt_media_types);
my $wmt_type_regexp = join("|",@wmt_media_types);
my $real_type_regexp = join("|",@real_media_types);
#$freeflow_media_regexp = join("|",@freeflow_media_types);

# info about verison
my $version = "od_akamaizer 3.1"; # abartov
print "$version\n" if $verbose;

# usage message and clean exit
if ($helpflag) {
   usage(\*STDOUT);
   exit(0);
}

if (!$getOptions) {
    usage(\*STDERR);
    die "Error Parsing arguments.\n";
}

if (!defined($cpcode)) {
    usage(\*STDERR);
    die "\n--cpcode is a required argument.\nCheck with your Account Manager to get your CP Code.\n\n";
}

# usage message and exit
if (($cpcode < $MIN_CPCODE) || ($cpcode > $MAX_CPCODE)) {
    usage(\*STDERR);
    die "\nCP Code is invalid.\nCheck with your Account Manager to get your CP Code.\n\n";
}

# David look here:
if ((defined($in_filename) || defined($out_filename)) && @finddirs) {
   print "Option --find is incompatible with --in and --out options.\n\n";
   # incompatible options
   usage(\*STDOUT);
   exit (0);
}

# usage message and clean exit
if ($helpflag) {
    usage(\*STDOUT);
    exit (0);
}

# url-only mode, avoids file manipulation
if (@transurls) {
   for (@transurls) {
      print $error "Akamaizing '$_'.\n" if $verbose;
      print $output "" . akamaize_url($_) . "\n";
   }
   exit(0);
}

# input files
if (defined($in_filename)) {
   find(\&od_akamaizer_find, $in_filename);  
}

# find mode
if (@finddirs) {

    # the foreach implementation is not necessarily the most efficient
    # in case of multiple -find options, but running this way is a bit
    # more intuitive, so we stick with it for now.

    foreach (@finddirs) {
	print $error "Akamaizing VOD media files starting in $_\n" if $verbose;

	find(\&od_akamaizer_find, $_);  
    }

    #cleanup();
    exit(0);
}

sub od_akamaizer_find {
    #
    # $_                - current file (no path)
    # $File::Find::dir  - current dir
    # $File::Find::name - $File::Find::dir/$_

    print $error "\n\n\nEntering od_akamaizer_find(): `$_'.\n\n" if $debug;

    # may want to expand this:

    if (/\.($good_file_regexp)$/ && (!(/$bad_file_regexp/))) {  
        my($verbose)=1;
    
        print $error "Akamaizing file: $File::Find::name\n" if $verbose;
  	
        if ($File::Find::name =~ /\.($good_wmt_file_regexp)$/i) {
           &asx_parser($_);
        } elsif ($File::Find::name =~ /\.($good_real_file_regexp)$/i) {
           &ram_parser($_);
        } elsif ($File::Find::name =~ /\.($good_qt_file_regexp)$/i) {
           &mov_parser($_);
        } elsif ($File::Find::name =~ /\.($good_batch_mov_input_regexp)$/i) {
           &process_qt_batch($_);
        } elsif ($File::Find::name =~ /\.($good_ref_mov_input_regexp)$/i) {
           &make_ref_movie($_);
        } elsif ($File::Find::name =~ /\.($good_smil_file_regexp)$/i) {
           &smil_parser($_);
        } else {
          print $error "No parser available for $File::Find::name\n" 
        }
    }
}

##################################################################################
# Cross Format Code
##################################################################################

sub akamaize_url {
  my($url) = shift;
  
  print $error "akamaize_url called for '$url'\n" if $debug;

  my $arl;
  if ($url =~ /\.($wmt_type_regexp)$/i) {
      $arl = &wmt_akamaize($url);
  }
  elsif ($url =~ /\.($real_type_regexp)$/i) {
      $arl = &real_akamaize($url);
  }
  elsif ($url =~ /\.($qt_type_regexp)$/i) {
      $arl = &qt_akamaize($url);
  }
  elsif ($url =~ /\.($good_real_smil_file_regexp)$/i) {
      $arl = &real_akamaize($url);
  }
  else {
      print $error "Unrecognized media type ($url)\n";
      $arl = $url;
  }

  return($arl);
}

sub compute_serial {

  my($url) = shift;

  my ($charcode, $seed);
  foreach $charcode (unpack('C*', $url))
  {
    $seed += $charcode;
  }        
  srand($seed);

  return(int(rand(1999)) + 1);
}

sub get_time {
	return ($objver ? $objver : sprintf("%x", time));
}

##################################################################################
# Windows Media Specific Code
##################################################################################

sub asx_parser {

  print $error "\n\n\nEntering asx_parser(): `$_'.\n\n" if $debug;

  my($infile) = @_;


  my($asxflag)=0;

  my @lines = &slurp_file($infile);
  my $line;
  foreach $line (@lines) {
      if ($line =~ /\<asx/i) {
          $asxflag = 1;
      }
  }
  
  my $outputFH = new FileHandle(">$tmp_file") 
      or die "Failed to open temporary output file ($!).";
  
  print $error "asxflag is $asxflag\n" if $debug;
  
  if (! $asxflag) { # input is batch file or asx v1 or v2
      foreach $line (@lines) {
          my $outline = $line;
          if (&valid_wmt_url($line)) {
              if (($line =~ m|http://|i) || ($line =~ m|mms://|i)) {
                  my $preurl   = $`;
                  my $protocol = $&;
                  my $url      = $';
                  $outline = $preurl . &wmt_akamaize($protocol.$url);
              } 
          }
          $outputFH->print($outline);
      }
    } else { # input is an asx v3
        foreach $line (@lines) {
            my $outline = $line;  # by default assume we output the line unchanged
            if ( &valid_wmt_url($line) ) {
                if ($line =~ /\<(ref|entry)\s+href/i) {
                    my $pre_tag  = $`;
                    my $tag      = $&;
                    my $post_tag = $';
                    if (($post_tag =~ m|http://[^\"]+|i) ||
                        ($post_tag =~ m|mms://[^\"]+|i)) {
                        my $equal    = $`;
                        my $url = $&;
                        my $rest      = $';
                        $outline = $pre_tag . $tag . $equal;
                        $outline .= &wmt_akamaize($url ) . $rest;
                    }
                }
            }
            $outputFH->print($outline);
        }
    }
  
  $outputFH->close();

  if (defined($out_filename)) {
     copy($tmp_file, $out_filename);
  } else {
      # make a backup:
      copy($infile,   $infile . ".bak");
      copy($tmp_file, $infile);
  }
  unlink($tmp_file);
}

sub valid_wmt_url {

  print $error "\n\n\nEntering valid_wmt_url(): `$_'.\n\n" if $debug;

  my($url) = @_;

  if ($url =~ /\.($wmt_type_regexp)/i) {
     return 1;
  } else {
     return 0;
  }
}

sub wmt_akamaize {

  print $error "\n\n\nEntering wmt_akamaize(): `$_'.\n\n" if $debug;

  my ($url) = shift;

  my ($typeCode) = "7";

  # check if already Akamaized:
  if( ($url =~ "akamaistream\.net") || ($url =~"akastream\.net")) {
     if ($reakamaize) {
       $url = &getOriginalUrlWMT($url);
       if (($url =~ "akamaistream\.net")||($url=~ "akastream\.net")) {
          # Couldn't retrieve original URL, throw it back
          return($url);
       }
     } else {
       return($url);
     }
  }

  my ($path, $file);
  ($path, $file) = getUriSegments($url);

  my $serial = &compute_serial($url);
  my $time = get_time(); 

  if ( $mungeEnabled ) {
      ($path) = munge($cpcode, $path);
      $typeCode = "5";
  }

  # This is the code for the new blocking arl format.
  my ($stream_id) = compute_streamid ($path . $file,$cpcode,'');
	my ($aka_mms) = "mms://a$serial.$stream_type$stream_id.c$cpcode.$stream_prop.$stream_type" . "m.akamaistream.net/$typeCode/$serial/$cpcode/$time/$path/$file";

  my ($arl) = &rewrite_arl($aka_mms);
  return $arl;

#    This is the old version of the arl being returned.
#    my $arl = "mms://a$serial.m.akastream.net/$typeCode/$serial/$cpcode/$time/$path/$file";
}

sub getOriginalUrlWMT {

  print $error "\n\n\nEntering getOriginalUrlWMT(): `$_'.\n\n" if $debug;

  my($url) = @_;

  my ($protocol, $blank, $domain, $typecode, $serialno,
      $cpcode, $objectdata, $originalurl) = split ("\/", $url, 8); 

#  print "typecode = " . $typecode . "\n";
  if ($typecode eq "D") {
     # uhoh, this is a live URL. Throw it back.
     return($url);
  }
  
  $originalurl = "http://" . $originalurl;
#  print "originalurl = " . $originalurl . "\n";
  return($originalurl);
}

##################################################################################
# Real Specific Code
##################################################################################

sub ram_parser {

  print $error "\n\n\nEntering ram_parser(): `$_'.\n\n" if $debug;

  my($infile) = @_;

  my @lines = slurp_file($infile);

  my $outputFH = new FileHandle("> $tmp_file") 
      or die ("Failed to open temporary output file ($!).");

  my $line;
  foreach $line (@lines) {
      my $outline = $line;      # assume output line is same as input
      if (&valid_real_url($line)) {
          if ($line =~ m,(http|rtsp|pnm)://,i) {
              my $preurl   = $`;
              my $protocol = $&;
              my $url      = $';
              my $real_arl = &real_akamaize($protocol . $url);
              $outline     = $preurl . $real_arl;
          } 
      }
      $outputFH->print($outline);
  }
  $outputFH->close();

  if (defined($out_filename)) {
      copy($tmp_file, $out_filename);
  } else {
      # make a backup:
      copy($infile,   $infile . ".bak");
      copy($tmp_file, $infile);
  }
  unlink($tmp_file);
}

sub valid_real_url {

  print $error "\n\n\nEntering valid_real_url(): `$_'.\n\n" if $debug;

  my($url) = @_;

  if ($url =~ /\.($real_type_regexp)/i) {
     return 1;
  } else {
     return 0;
  }
} 

sub real_akamaize {

  print $error "\n\n\nEntering real_akamaize(): `$_'.\n\n" if $debug;

  my ($url) = shift;

  my ($typeCode) = "7";

  # check if already Akamaized:
  if (($url =~ "akamaistream\.net") || ($url =~"akareal\.net")) {
     if ($reakamaize) {
       $url = &getOriginalUrlReal($url);
       if (($url =~ "akamaistream\.net") || ($url =~"akareal\.net")) {
          # Couldn't retrieve original URL, throw it back
          return($url);
       }
     } else {
       return($url);
     }
  }

  my ($path, $file, $protocol);
  ($path, $file, $protocol) = getUriSegments($url);

  my $serial = &compute_serial($url);
  my $time = get_time();

  if ($protocol =~ /pnm/i) {
      # force protocol to be just pnm
      $protocol = "pnm";
  } else {
      # otherwise, we'll assume it's rtsp
      $protocol = "rtsp";
  }

  if ( $mungeEnabled ) {
      ( $path ) = munge($cpcode, $path);
      $typeCode = "5";
  }

#  my ($arl);
#  if (($realAdPlugin) && ($file =~ /smi/i)) {
#     $arl = "$protocol://a$serial.r.akareal.net/adtag/general/ondemand/$typeCode/$serial/$cpcode/$time/$path/$file";
#  } else {
#     $arl = "$protocol://a$serial.r.akareal.net/ondemand/$typeCode/$serial/$cpcode/$time/$path/$file";
#  }


  # This is the code for the new block format arl's
  my ($ondemand) = "ondemand/";
  my ($aka_adtag);

  if (($realAdPlugin) && ($file =~ /smi/i)) {
     $aka_adtag = 'adtag/general/'
  } else {
     $aka_adtag = "";
  }


  my ($stream_id) = compute_streamid ($path . $file,$cpcode,'');
	my ($aka_arl) = "$protocol://a$serial.$stream_type$stream_id.c$cpcode.$stream_prop.$stream_type" . "r.akamaistream.net/" . $aka_adtag . $ondemand .  "$typeCode/$serial/$cpcode/$time/$path/$file";


  my ($arl) = &rewrite_arl($aka_arl);

  return $arl;
}

sub getOriginalUrlReal {

  print $error "\n\n\nEntering getOriginalUrlReal(): `$_'.\n\n" if $debug;

  my($url) = @_;

  my ($protocol, $blank, $domain, $adtag, $general, $constant, $typecode,
      $serialno, $cpcode, $objectdata, $originalurl);

  if ($url =~  /adtag\/general/i) {
    ($protocol, $blank, $domain, $adtag, $general, $constant, $typecode,
        $serialno, $cpcode, $objectdata, $originalurl) = split ("\/", $url, 11);
  } else {
    ($protocol, $blank, $domain, $constant, $typecode,
        $serialno, $cpcode, $objectdata, $originalurl) = split ("\/", $url, 9);
  }

  # print "typecode = " . $typecode . "\n";
  if ($typecode eq "D") {
     # uhoh, this is a live URL. Throw it back.
     return($url);
  }
  
  $originalurl = "http://" . $originalurl;
#  print "originalurl = " . $originalurl . "\n";
  return($originalurl);
}

##################################################################################
# QT Specific Code
##################################################################################

sub mov_parser {

  print $error "\n\n\nEntering mov_parser(): `$_'.\n\n" if $debug;

  print "QT Movie parser not implemented yet. Skipping.\n" if $debug;
}

sub valid_qt_url {

  print $error "\n\n\nEntering valid_qt_url(): `$_'.\n\n" if $debug;

  my($url) = @_;

  if ($url =~ /\.($qt_type_regexp)/i) {
     return 1;
  } else {
     return 0;
  }
} 

sub process_qt_batch {

  print $error "\n\n\nEntering process_qt_batch(): `$_'.\n\n" if $debug;

  my($infile) = @_;

  my @lines = &slurp_file($infile);

  my $outputFH = new FileHandle("> $tmp_file") 
      or die ("Failed to open temporary output file ($!).");
  
  my $line;
  foreach $line (@lines) {
      chomp($line);
      if ($line eq '') {
         # blank line
         $outputFH->print("$line\n");
      } else {
         my $arl = &qt_akamaize($line);
         $outputFH->print("$arl\n");
      }
  }
  $outputFH->close();

  if (defined($out_filename)) {
     copy($tmp_file, $out_filename);
  } else {
      # make a backup:
      copy($infile, "$infile.bak");
      copy($tmp_file, $infile);
  }
  unlink($tmp_file);
}

sub make_ref_movie {

  print $error "\n\n\nEntering make_ref_movie(): `$_'.\n\n" if $debug;

  my($infile) = @_;

  my @lines = &slurp_file($infile);
  if (@lines == 0) {
      print $error "Empty input file $infile when making ref movie\n";
      return;
  }

  my $rmda = '';

  my $line;
  foreach $line (@lines)
  {
      chomp($line);

      print("\t".$line."\n") if $debug;

      my ($rate,$url)=split(' ',$line);

      my $arl = &qt_akamaize($url, $rate);

      print $error "Warning: $rate is not an Apple standard data rate. Should be 1400/2800/5600/11200/150000/INF\n"
	if($rate ne "1400" && $rate ne "2800" &&
	   $rate ne "5600" && $rate ne "11200" &&
	   $rate ne "150000" && $rate ne "INF");

      $rate=0x7FFFFFFF if($rate eq "INF");
      
      print $error "\n  Building the data reference atom for\n    $arl\n" if $verbose;
      
      my $len=length($arl)+1;
      my $rdrf=pack("Na4Na$len",0,"url ",$len,$arl);
      $len=length($rdrf)+8;
      $rdrf=pack("Na4",$len,"rdrf").$rdrf;
      
      print $error "  Building the data rate atom for $rate\n" if $verbose;
      
      my $rmdr=pack("NN",0,$rate);
      $len=length($rmdr)+8;
      $rmdr=pack("Na4",$len,"rmdr").$rmdr;
      
      print $error "  Building the Reference Movie Descriptor atom\n" if $verbose;
      $len=length($rmdr)+length($rdrf)+8;
      $rmda .= pack("Na4",$len,"rmda") . $rmdr . $rdrf;
  }
  
  print $error "\n  Building the Reference Movie atom\n" if $verbose;

  my $len2=length($rmda)+8;
  my $rmra=pack("Na4",$len2,"rmra") . $rmda;

  print $error "  Building the Movie atom\n" if $verbose;

  my $len=length($rmra)+8;
  my $moov=pack("Na4",$len,"moov").$rmra;

  # output filename is same as input but with .mov extension:

  my $pos = rindex $infile, "\."; 
  my $outfile = substr($infile, 0, $pos) . ".mov";

  open(OUTPUT,"> $outfile") || die ("Couldn't create $outfile.\n");

  # binmode is required on Windows or the ref movie will be invalid:
  binmode(OUTPUT);

  print OUTPUT $moov;
  close(OUTPUT);

  print $error "  Ref Movie $outfile Created.\n\n" if $verbose;
}

sub qt_akamaize {

  print $error "\n\n\nEntering qt_akamaize(): `$_'.\n\n" if $debug;

  my ($url) = shift;
  my ($rate) = shift;

  my ($typeCode) = "7";
  my %qtMap = (
	       "150000" => "qt1",
	       "INF" => "qt1",
	     );

  # check if already Akamaized:
  if (($url =~ "kamai\.net") || ($url =~ "akamaistream\.net")) {
     if ($reakamaize) {
       $url = &getOriginalUrlQT($url);
     } else {
       return($url);
     }
  }

  my ($path, $file);
  ($path, $file) = getUriSegments($url);

  my $serial = &compute_serial($url);
  my $time = get_time();

  if ( $mungeEnabled ) {
      ($path) = munge($cpcode, $path);
      $typeCode = "5";
  }

  my ($map);
  if ( ! (defined $rate && defined($qtMap{$rate})) ) {
      $map = "q";
  } else {
      $map = $qtMap{$rate};
  }


  # This is the old format dns name.
  # my $arl = "rtsp://a$serial.$map.kamai.net/$typeCode/$serial/$cpcode/$time/$path/$file"; 
  my ($stream_id) = compute_streamid ($path . $file,$cpcode,'');
  # This is the new blocking arl format.
   my $arl = "rtsp://a$serial.v$stream_id.c$cpcode.$stream_prop.vq.akamaistream.net/$typeCode/$serial/$cpcode/$time/$path/$file";

  $arl = &rewrite_arl($arl);

  return $arl;
}

sub getOriginalUrlQT {

  print $error "\n\n\nEntering getOriginalUrlQT(): `$_'.\n\n" if $debug;

  my($url) = @_;

  my ($protocol, $blank, $domain, $typecode, $serialno, $cpcode, $objectdata, $originalurl) = split ("\/", $url, 8); 
    
  $originalurl = "http://" . $originalurl;
#  print "originalurl = " . $originalurl . "\n";
  return($originalurl);
}

##################################################################################
# SMIL Specific Code
##################################################################################

sub smil_parser {

  print $error "\n\n\nEntering smil_parser(): `$_'.\n\n" if $debug;

  my($infile) = @_;

  # open input file and scan for file type
  my @lines = &slurp_file($infile);

  my $outputFH = new FileHandle("> $tmp_file")
      or die ("Failed to open temporary output file ($!).");

  my $line;
  foreach $line (@lines) {
      my $outline = $line;
      if ($line =~ /\<(audio|video|textstream|ref|img)/i) {
          my $tag = $1;
          if ($line =~ /\s+src\s*=\s*/i) {
              my $pre_attrib  = $`;
              my $attrib      = $&;
              my $post_attrib = $';
              if (($post_attrib =~ m,(http|rtsp|mms|pnm)://(.*?)(?=\"),i)) {
                  my $equal    = $`;
                  my $protocol = $1;
                  my $url      = $2;
                  my $rest     = $';
                  my $arl      = &akamaize_url($protocol . "://" . $url);
                  $outline =  $pre_attrib . $attrib . $equal . $arl . $rest;
              } else {
                  if ($post_attrib =~ m,"(.*?)",) {
                      my $url = $1;
                      print $error "Skipping relative $tag src link: '$1'\n" if $verbose;
                  }
              }
          }
      }
      $outputFH->print($outline);
  }
  
  $outputFH->close();

  if (defined($out_filename)) {
      copy($tmp_file, $out_filename);
  } else {
      # make a backup:
      copy($infile, "$infile.bak");
      
      copy($tmp_file, $infile);
  }
  unlink($tmp_file);
}



sub rewrite_arl 
{
    my $input_arl = shift;

    # if the rewrite_input is not defined, no writing to do 
    if (! defined $rewrite_input || $rewrite_input eq '' ) {
        # and we're out of here...
        return $input_arl;
    }

    my $output_arl = $input_arl;

    if ($input_arl =~ /\Q$rewrite_input\E/) {
        print $error "found matching rewrite rule for $rewrite_input..." 
            if $debug;
        $output_arl =~ s/\Q$rewrite_input\E/$rewrite_output/g;
    } 

    return $output_arl;
}

sub slurp_file
{
    my $filename = shift;

    my $filehandle = new FileHandle("$filename",'r') or 
        die "can not open input file $filename";
    my @lines = $filehandle->getlines();
    $filehandle->close();
    return @lines;
}

sub munge
{
    my ($cpCode) = shift;
    my ($stringToMunge) = shift;
    my ($hash) = $cpCode+0;
    my ($result) = "1a1a1a";
    my ($character);

    foreach $character (split //, $stringToMunge) {
	$hash=($hash+ord($character))%256;
	$result.=sprintf("%02x",$hash);
    }

    return($result);
}

sub getUriSegments
{
    # hard-coded, add if necessary
    my @known_protocols = ( "http", "rtsp", "mms", "pnm" ); 
    
    my ($url) = shift;
    my ($protocol, $path, $file);
    $protocol = "";
    foreach my $prot (@known_protocols) # multiple protocol recognition added by abartov
    {
        if ($url =~ m!^$prot://!)
        {
            ($protocol, $path, $file) = ($url =~ m|(.*)://(.+)/([^/]+)$|);
            last;
        }
    }
    if ($protocol eq "")
    {
        $protocol = "http"; # assume http
        ($path, $file) = ($url =~ m|(.+)/([^/]+)$|);
    }
    
    #    if($url =~ m!^http://! or $url =~ m!^rtsp://!) { # rtsp added by abartov
    #     } else {
        
    #    }


    return($path, $file, $protocol);
}


# This function returns the streamid - a unique number 
#  - for live, the cpcode followed by the port number
#  - for VOD,  the cpcode followed by a hash on the directory and filename 
# we pad the cpcode to 5 digits with 0's if needed.
sub compute_streamid
{
  my ($data,$cpcode,$port) = @_;
  my($hash) = $port;
  $cpcode = sprintf  "%05s" , $cpcode;
  if ($port eq '') {
    $hash = substr ( md5_hex($data) , -1);
  }
  return ($cpcode . $hash);
}

###################################################################################
###################################################################################

sub usage 
{
    die <<EOF

usage: $0 [flags]

  Required:

    --cpcode <cpCode>    As given to you by your Account Manager

  Optional:

    --in <filename>        File to parse
    --out <filename>       Output parsed file to <filename>
    --url <URL>            URL to change to ARL (Akamai Resource Locator)
    --find <directory>     Parse all files in <directory>
                             [note: option incompatible with --in & --out]
    --munge                Encode original URL (not cryptographicly secure)
    --ad                   Invokes Real Ad Plug-in on Real Server
    --noreakamaize         Do not reAkamaize existing ARLs
    --verbose              Provide detailed information and version number
    --help                 Show usage information
    --usa                  adds the US-domestic stream property .d. 
    --1m                   adds the 1 Mbps or greater stream property .t.
    --objver <identifier>  specifies explicit object version to use instead
                             of hexadecimal time of Akamaization
EOF
}

# pacify require
1;
