<?php


/*
These are data holders, please create class porperties as private and relevant getters and setter, with convention

get<variable_name>
set<variable_name>

*/

class base_db_dto{
	
	protected function object_to_array($data)
	{
		$result = array();
		if (is_array($data))
		{
			
			foreach ($data as $key => $value)
			{
				$val = $this->object_to_array($value);
				if($val != null )
					$result[$key] = $val;
			}
			return $result;
		}else if(is_object($data)){
		
			
			$reflect = new ReflectionClass($data);
			$props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
			foreach ($props as $prop) {
				$getter = "get".$prop->getName();
				try{
					$val = $this->object_to_array($data->$getter());
					if($val != null)
						$result[$prop->getName()] = $val;
				}catch(Exception $e){
					// do nothing
				}
			}
			return $result;
		}
		return $data;
	}
	
	public function to_array(){
		return $this->object_to_array($this);
	}}

class container_db_dto extends base_db_dto{
	private $data;
	private $current_count;
	private $total_count;

	    
	public function gettotal_count() 
	{
	  return $this->total_count;
	}
	
	public function settotal_count($value) 
	{
	  $this->total_count = $value;
	}
	public function getcurrent_count() 
	{
		if($this->current_count == null){
			if(is_array($this->data)){
				return count($this->data);
			}else
				return 1;
		}
	  
	}
	
	public function setcurrent_count($value) 
	{
	  $this->current_count = $value;
	}	    
	public function getdata() 
	{
	  return $this->data;
	}
	
	public function setdata($value) 
	{
	  $this->data = $value;
	}
	    
	
	}

class artist_db_dto extends base_db_dto{

	private $artist_id;
	private $artist_name;
	private $artist_image;
	private $artist_dob;
	private $artist_dod;
	private $artist_gender;
	private $artist_role =array();
	private $artist_biography;

	public function getartist_biography() 
	{
	  return $this->artist_biography;
	}
	
	public function setartist_biography($value) 
	{
	  $this->artist_biography = $value;
	}  
	public function appendartist_role($value){
		array_push( $this->artist_role , $value);
	}
	public function setartist_role($value)
	{
		$this->artist_role = $value;
	}  
	public function getartist_role() 
	{
	  return $this->artist_role;
	}
	 
	public function getartist_gender() 
	{
	  return $this->artist_gender;
	}
	
	public function setartist_gender($value) 
	{
	  $this->artist_gender = $value;
	}
	
	public function getartist_dod() 
	{
	  return $this->artist_dod;
	}
	
	public function setartist_dod($value) 
	{
	  $this->artist_dod = $value;
	}    
	public function getartist_dob() 
	{
	  return $this->artist_dob;
	}
	
	public function setartist_dob($value) 
	{
	  $this->artist_dob = $value;
	}
	    
	public function getartist_image() 
	{
	  return $this->artist_image;
	}
	
	public function setartist_image($value) 
	{
	  $this->artist_image = $value;
	}
	    
	public function getartist_name() 
	{
	  return ucwords(strtolower($this->artist_name));
	}
	
	public function setartist_name($value) 
	{
	  $this->artist_name = $value;
	}
	    
	public function getartist_id() 
	{
	  return $this->artist_id;
	}
	
	public function setartist_id($value) 
	{
	  $this->artist_id = $value;
	}
}

class album_db_dto extends base_db_dto {
	
	private $album_id;
	private $album_name;
	private $album_audio=array();
	private $album_artist;
	private $album_df_image;
	private $album_title_rel_dt;
	private $album_label;
	private $album_language;
	private $album_type;
	private $album_description;
	private $album_excerpt;
	private $album_broadcast_year;
	private $album_grade;
	private $album_tags;
	private $album_music_rel_dt;	
	private $album_content_type;
	private $album_film_rating;
	private $album_language_id;
	private $album_images;
	private $album_banners;
	private $album_video;

	    
	public function getalbum_video() 
	{
	  return $this->album_video;
	}
	
	public function setalbum_video($value) 
	{
	  $this->album_video = $value;
	}

	public function getalbum_language_id() 
	{
	  return $this->album_language_id;
	}
	
	public function setalbum_language_id($value) 
	{
	  $this->album_language_id = $value;
	}
	
	public function getalbum_film_rating() 
	{
	  return $this->album_film_rating;
	}
	
	public function setalbum_film_rating($value) 
	{
	  $this->album_film_rating = $value;
	}
	
	public function getalbum_content_type() 
	{
	  return $this->album_content_type;
	}
	
	public function setalbum_content_type($value) 
	{
	  $this->album_content_type = $value;
	}
	    
	public function getalbum_banners() 
	{
	  return $this->album_banners;
	}
	
	public function setalbum_banners($value) 
	{
	  $this->album_banners = $value;
	}

	public function getalbum_images() 
	{
	  return $this->album_images;
	}
	
	public function setalbum_images($value) 
	{
	  $this->album_images = $value;
	}
	public function getalbum_title_rel_dt() 
	{
	  return $this->album_title_rel_dt;
	}
	
	public function setalbum_title_rel_dt($value) 
	{
	  $this->album_title_rel_dt = $value;
	}
	    
	public function getalbum_music_rel_dt() 
	{
	  return $this->album_music_rel_dt;
	}
	
	public function setalbum_music_rel_dt($value) 
	{
	  $this->album_music_rel_dt = $value;
	}
	    
	public function getalbum_tags() 
	{
	  return $this->album_tags;
	}
	
	public function setalbum_tags($value) 
	{
	  $this->album_tags = $value;
	}
	
	public function getalbum_grade() 
	{
	  return $this->album_grade;
	}
	
	public function setalbum_grade($value) 
	{
	  $this->album_grade = $value;
	}
	
	public function getalbum_broadcast_year() 
	{
	  return $this->album_broadcast_year;
	}
	
	public function setalbum_broadcast_year($value) 
	{
	  $this->album_broadcast_year = $value;
	}
	
	public function getalbum_excerpt() 
	{
	  return $this->album_excerpt;
	}
	
	public function setalbum_excerpt($value) 
	{
	  $this->album_excerpt = $value;
	}
	
	public function getalbum_description() 
	{
	  return $this->album_description;
	}
	
	public function setalbum_description($value) 
	{
	  $this->album_description = $value;
	}
	
	public function getalbum_type() 
	{
	  return $this->album_type;
	}
	
	public function setalbum_type($value) 
	{
	  $this->album_type = $value;
	}
	
	public function getalbum_artist() 
	{
	  return $this->album_artist;
	}
	
	public function setalbum_artist($value) 
	{
	  $this->album_artist = $value;
	}
	
	    
	public function getalbum_audio() 
	{
	  return $this->album_audio;
	}
	
	public function setalbum_audio($value) 
	{
	  $this->album_audio = $value;
	}
	
	
	public function getalbum_name() 
	{
	  return $this->album_name;
	}
	
	public function setalbum_name($value) 
	{
	  $this->album_name = $value;
	}    
	public function getalbum_df_image() 
	{
	  return $this->album_df_image;
	}
	
	public function setalbum_df_image($value) 
	{
	  $this->album_df_image = $value;
	}    
	public function getalbum_release_date() 
	{
	  return $this->album_release_date;
	}
	
	public function setalbum_release_date($value) 
	{
	  $this->album_release_date = $value;
	}    
	public function getalbum_label() 
	{
	  return $this->album_label;
	}
	
	public function setalbum_label($value) 
	{
	  $this->album_label = $value;
	}    
	public function getalbum_language() 
	{
	  return $this->album_language;
	}
	
	public function setalbum_language($value) 
	{
	  $this->album_language = $value;
	}
	
	
	public function getalbum_id() 
	{
	  return $this->album_id;
	}
	
	public function setalbum_id($value) 
	{
	  $this->album_id = $value;
	}}

class audio_db_dto extends base_db_dto {
	
	private $audio_id;
	private $audio_name;
	private $audio_album_id;
	private $audio_album_name;
	private $audio_artist;
	private $audio_language_id;
	private $audio_language_name;
	private $audio_release_date;
	private $audio_duration;
	private $audio_isrc;
	private $audio_file;
	private $audio_tags;
	private $audio_tags_songs = array();
	private $audio_tempo;
	private $audio_subject_parody;
	private $audio_label_id;
	private $audio_label_name;
	private $audio_lyrics;
	private $audio_album_img;
	private $audio_video = array();
	private $audio_image;
	    
	public function getaudio_image() 
	{
	  return $this->audio_image;
	}
	
	public function setaudio_image($value) 
	{
	  $this->audio_image = $value;
	}

	public function getaudio_album_img() 
	{
	  return $this->audio_album_img;
	}
	
	public function setaudio_album_img($value) 
	{
	  $this->audio_album_img = $value;
	}

	public function getaudio_tags_songs() 
	{
	  return $this->audio_tags_songs;
	}
	
	public function setaudio_tags_songs($value) 
	{
	  $this->audio_tags_songs = $value;
	}
	
	public function getaudio_video() 
	{
	  return $this->audio_video;
	}
	
	public function setaudio_video($value) 
	{
	  $this->audio_video = $value;
	}
	    
	public function getaudio_lyrics() 
	{
	  return $this->audio_lyrics;
	}
	
	public function setaudio_lyrics($value) 
	{
	  $this->audio_lyrics = $value;
	}

	public function getaudio_album_id() 
	{
	  return $this->audio_album_id;
	}
	
	public function setaudio_album_id($value) 
	{
	  $this->audio_album_id = $value;
	}
	public function getaudio_album_name() 
	{
	  return $this->audio_album_name;
	}
	
	public function setaudio_album_name($value) 
	{
	  $this->audio_album_name= $value;
	}


				
	public function getaudio_label_id() 
	{
	  return $this->audio_label_id;
	}
	
	public function setaudio_label_id($value) 
	{
	  $this->audio_label_id = $value;
	}

	public function getaudio_label_name() 
	{
	  return $this->audio_label_name;
	}
	
	public function setaudio_label_name($value) 
	{
	  $this->audio_label_name = $value;
	}


	public function getaudio_subject_parody() 
	{
	  return $this->audio_subject_parody;
	}
	
	public function setaudio_subject_parody($value) 
	{
	  $this->audio_subject_parody = $value;
	}

	public function getaudio_tempo() 
	{
	  return $this->audio_tempo;
	}
	
	public function setaudio_tempo($value) 
	{
	  $this->audio_tempo = $value;
	}
	    
	public function getaudio_isrc() 
	{
	  return $this->audio_isrc;
	}
	
	public function setaudio_isrc($value) 
	{
	  $this->audio_isrc = $value;
	}

	public function getaudio_tags() 
	{
	  return $this->audio_tags;
	}
	
	public function setaudio_tags($value) 
	{
	  $this->audio_tags = $value;
	}

	
	public function getaudio_file() 
	{
	  return $this->audio_file;
	}
	
	public function setaudio_file($value) 
	{
	  $this->audio_file = $value;
	}
	
	
	
	public function getaudio_duration() 
	{
	  return $this->audio_duration;
	}
	
	public function setaudio_duration($value) 
	{
	  $this->audio_duration = $value;
	}
	
	public function getaudio_release_date() 
	{
	  return $this->audio_release_date;
	}
	
	public function setaudio_release_date($value) 
	{
	  $this->audio_release_date = $value;
	}
	    
	public function getaudio_language_id() 
	{
	  return $this->audio_language_id;
	}
	
	public function setaudio_language_id($value) 
	{
	  $this->audio_language_id = $value;
	}
	
	public function getaudio_language_name() 
	{
	  return $this->audio_language_name;
	}
	
	public function setaudio_language_name($value) 
	{
	  $this->audio_language_name= $value;
	}
	
	public function getaudio_name() 
	{
	  return $this->audio_name;
	}
	
	public function setaudio_name($value) 
	{
	  $this->audio_name = $value;
	}
	
	public function getaudio_id() 
	{
	  return $this->audio_id;
	}
	
	public function setaudio_id($value) 
	{
	  $this->audio_id = $value;
	}
	
	public function getaudio_artist() 
	{
	  return $this->audio_artist;
	}
	
	public function setaudio_artist($value) 
	{
	  $this->audio_artist = $value;
	}

	}

class image_db_dto extends base_db_dto {
	private $image_id;
	private $image_name;
	private $image_description;
	private $image_type;

	    
	public function getimage_type() 
	{
	  return $this->image_type;
	}
	
	public function setimage_type($value) 
	{
	  $this->image_type = $value;
	}    
	public function getimage_description() 
	{
	  return $this->image_description;
	}
	
	public function setimage_description($value) 
	{
	  $this->image_description = $value;
	}    
	public function getimage_name() 
	{
	  return $this->image_name;
	}
	
	public function setimage_name($value) 
	{
	  $this->image_name = $value;
	}    
	public function getimage_id() 
	{
	  return $this->image_id;
	}
	
	public function setimage_id($value) 
	{
	  $this->image_id = $value;
	}}

class video_db_dto extends base_db_dto {
	
	private $video_id;
	private $video_name;
	private $video_image;
	private $video_language;
	private $video_duration;
	private $video_release_date;
	private $video_file;
	private $video_tempo;
	private $video_artist;
	    
	public function getvideo_artist() 
	{
	  return $this->video_artist;
	}
	
	public function setvideo_artist($value) 
	{
	  $this->video_artist = $value;
	}

	public function getvideo_tempo() 
	{
	  return $this->video_tempo;
	}
	
	public function setvideo_tempo($value) 
	{
	  $this->video_tempo = $value;
	}    


	public function getvideo_file() 
	{
	  return $this->video_file;
	}
	
	public function setvideo_file($value) 
	{
	  $this->video_file = $value;
	}    

	public function getvideo_release_date() 
	{
	  return $this->video_release_date;
	}
	
	public function setvideo_release_date($value) 
	{
	  $this->video_release_date = $value;
	}    

	public function getvideo_duration() 
	{
	  return $this->video_duration;
	}
	
	public function setvideo_duration($value) 
	{
	  $this->video_duration = $value;
	}    

	public function getvideo_language() 
	{
	  return $this->video_language;
	}
	
	public function setvideo_language($value) 
	{
	  $this->video_language = $value;
	}    
	public function getvideo_image() 
	{
	  return $this->video_image;
	}
	
	public function setvideo_image($value) 
	{
	  $this->video_image = $value;
	}    
	public function getvideo_name() 
	{
	  return $this->video_name;
	}
	
	public function setvideo_name($value) 
	{
	  $this->video_name = $value;
	}    
	public function getvideo_id() 
	{
	  return $this->video_id;
	}
	
	public function setvideo_id($value) 
	{
	  $this->video_id = $value;
	}}

class playlist_db_dto extends base_db_dto {
	
	private $playlist_id;
	private $playlist_name;
	private $language_id;
	private $language_name;
	private $playlist_image;
	private $playlist_type;
	private $playlist_content;
	    
	public function getplaylist_content() 
	{
	  return $this->playlist_content;
	}
	
	public function setplaylist_content($value) 
	{
	  $this->playlist_content = $value;
	}
	    
	public function getplaylist_type() 
	{
	  return $this->playlist_type;
	}
	
	public function setplaylist_type($value) 
	{
	  $this->playlist_type = $value;
	}
	public function getplaylist_image() 
	{
	  return $this->playlist_image;
	}
	
	public function setplaylist_image($value) 
	{
	  $this->playlist_image = $value;
	}    
	public function getlanguage_name() 
	{
	  return $this->language_name;
	}
	
	public function setlanguage_name($value) 
	{
	  $this->language_name = $value;
	}    
	public function getlanguage_id() 
	{
	  return $this->language_id;
	}
	
	public function setlanguage_id($value) 
	{
	  $this->language_id = $value;
	}    
	public function getplaylist_name() 
	{
	  return $this->playlist_name;
	}
	
	public function setplaylist_name($value) 
	{
	  $this->playlist_name = $value;
	}    
	public function getplaylist_id() 
	{
	  return $this->playlist_id;
	}
	
	public function setplaylist_id($value) 
	{
	  $this->playlist_id = $value;
	}
	
	
	}

class event_db_dto extends base_db_dto {
	
	private $event_id;
	private $event_name;
	private $event_language_id;
	private $event_language_name;
	private $event_image;
	private $event_type_id;
	private $event_artist_ids;
	private $event_playlist_ids;
	private $event_start_date;
	private $event_end_date;
	private $event_desc;
	    
	public function getevent_id() 
	{
	  return $this->event_id;
	}
	
	public function setevent_id($value) 
	{
	  $this->event_id = $value;
	}

	public function getevent_name() 
	{
	  return $this->event_name;
	}
	
	public function setevent_name($value) 
	{
	  $this->event_name = $value;
	}
	
	public function getevent_language_id() 
	{
	  return $this->event_language_id;
	}
	
	public function setevent_language_id($value) 
	{
	  $this->event_language_id = $value;
	}
	
	public function getevent_language_name() 
	{
	  return $this->event_language_name;
	}
	
	public function setevent_language_name($value) 
	{
	  $this->event_language_name = $value;
	}
	
	public function getevent_image() 
	{
	  return $this->event_image;
	}
	
	public function setevent_image($value) 
	{
	  $this->event_image = $value;
	}
	
	public function getevent_type_id() 
	{
	  return $this->event_type_id;
	}
	
	public function setevent_type_id($value) 
	{
	  $this->event_type_id = $value;
	}	    
	
	public function getevent_artist_ids() 
	{
	  return $this->event_artist_ids;
	}
	
	public function setevent_artist_ids($value) 
	{
	  $this->event_artist_ids = $value;
	}	    
	
	public function getevent_playlist_ids() 
	{
	  return $this->event_playlist_ids;
	}
	
	public function setevent_playlist_ids($value) 
	{
	  $this->event_playlist_ids = $value;
	}	    
	
	public function getevent_start_date() 
	{
	  return $this->event_start_date;
	}
	
	public function setevent_start_date($value) 
	{
	  $this->event_start_date = $value;
	}	    

	public function getevent_end_date() 
	{
	  return $this->event_end_date;
	}
	
	public function setevent_end_date($value) 
	{
	  $this->event_end_date = $value;
	}	
	
	public function getevent_desc() 
	{
	  return $this->event_desc;
	}
	
	public function setevent_desc($value) 
	{
	  $this->event_desc = $value;
	}	    	
	    	
}


?>