<?php


/*
These are data holders, please create class porperties as private and relevant getters and setter, with convention

get<variable_name>
set<variable_name>

*/

class base_solr_dto{
	
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
	}
}



class container_solr_dto extends base_solr_dto{
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

class artist_solr_dto extends base_solr_dto{

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
		$this->artist_roles = $value;
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

class album_solr_dto extends base_solr_dto {
	
	private $album_id;
	private $album_name;
	private $album_audio=array();
	private $album_artist;
	private $album_image;
	private $album_release_date;
	private $album_label;
	private $album_language;
	private $album_type;
	private $album_description;
	private $album_excerpt;
	private $album_broadcast_year;
	private $album_grade;
	private $album_tags;
	private $album_title_release_date;
	    
	public function getalbum_title_release_date() 
	{
	  return $this->album_title_release_date;
	}
	
	public function setalbum_title_release_date($value) 
	{
	  $this->album_title_release_date = $value;
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
	public function getalbum_image() 
	{
	  return $this->album_image;
	}
	
	public function setalbum_image($value) 
	{
	  $this->album_image = $value;
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
	}
}


class audio_solr_dto extends base_solr_dto {
	
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
	private $audio_tempo;
	private $audio_subject_parody;
	private $audio_label_id;
	private $audio_label_name;

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

class image_solr_dto extends base_solr_dto {
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
	}
}

class video_solr_dto extends base_solr_dto {
	
	private $video_id;
	private $video_name;
	private $video_image;
	private $video_language;
	private $video_duration;
	    
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
	}
	
}


?>