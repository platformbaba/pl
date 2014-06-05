<!--                CONTENT 			-->
<div id="content"> 
<div>
  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage Batch Id - <?=$_GET['bid']?></h1></span>
  <br class='clear' />	
</div>
  <?php
		/* To show errorr */
		if( !empty($aError) ){
			$aParam = array(
						'type' => 'error',
						'msg' => $aError,
					 );
			TOOLS::showNotification( $aParam );
		}
		/* To show success */
		if( !empty($aSuccess) || ( isset($_GET['msg']) && $_GET['msg'] != '') ){
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ $aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
  <!-- Search Box start -->
<form id='srcFrm' name='srcFrm' method='post' enctype="multipart/form-data">
    <?php
		if( !empty($aContent) ){
			$s=1;
			foreach( $aContent as $showData){
				$remarks=json_decode($showData->remarks,true);
				if($showData->status==1){
					$class="background-color:#E9FBB4;";
				}else{
					$class="background-color:#FBB4B4;";
				}
	?>
	<div class="bloc" style="width: 520%;" id="bloc_<?=$showData->id?>">
	<div class="content" style="<?=$class?>">
        <div class="clearfix">
          <div class="input FL PR5">
            <label for="input">ISRC :</label>
            <input type="text" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['isrc']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Song Title :</label>
            <input type="text" id="song_title_<?=$showData->id?>" name="song_title[<?=$showData->id?>]" value="<?php echo $showData->song_title; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['song_title']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="song_language_<?=$showData->id?>" name="song_language[<?=$showData->id?>]" value="<?php echo $showData->song_language; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['song_language']?></span>
          </div>
		  <div class="input FL PR5">
			<label for="input">Release Date :</label>
            <input type="text" id="release_date_<?=$showData->id?>" name="release_date[<?=$showData->id?>]" value="<?php echo $showData->release_date; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['release_date']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Track Duration :</label>
            <input type="text" id="track_duration_<?=$showData->id?>" name="track_duration[<?=$showData->id?>]" value="<?php echo $showData->track_duration; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['track_duration']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Song Tempo :</label>
            <input type="text" id="song_tempo_<?=$showData->id?>" name="song_tempo[<?=$showData->id?>]" value="<?php echo $showData->song_tempo; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Subject Parody :</label>
            <input type="text" id="subject_parody_<?=$showData->id?>" name="subject_parody[<?=$showData->id?>]" value="<?php echo $showData->subject_parody; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album Name :</label>
            <input type="text" id="album_name_<?=$showData->id?>" name="album_name[<?=$showData->id?>]" value="<?php echo $showData->album_name; ?>" class="autosuggestalbum WD150 "/>
			<span class="error-message"><?=$remarks['album_name']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Singer :</label>
            <input type="text" id="singer_<?=$showData->id?>" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="autosuggestsinger WD150 "/>
			<?php
				foreach($remarks['singer'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Director :</label>
            <input type="text" id="music_director_<?=$showData->id?>" name="music_director[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="autosuggestmdirector WD150 "/>
			<?php
				foreach($remarks['music_director'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="autosuggestlyricist WD150 "/>
			<?php
				foreach($remarks['lyricist'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Starcast :</label>
            <input type="text" id="starcast_<?=$showData->id?>" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="autosuggeststarcast WD150 "/>
			<?php
				foreach($remarks['starcast'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Mimicked Star :</label>
            <input type="text" id="mimicked_star_<?=$showData->id?>" name="mimicked_star[<?=$showData->id?>]" value="<?php echo $showData->mimicked_star; ?>" class="autosuggestmimicked_star WD150 "/>
		  	<?php
				foreach($remarks['mimicked_star'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Version :</label>
            <input type="text" id="version_<?=$showData->id?>" name="version[<?=$showData->id?>]" value="<?php echo $showData->version; ?>" class="autosuggestversion WD150 "/>
			<?php
				foreach($remarks['version'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" id="genre_<?=$showData->id?>" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="autosuggestgenre WD150 "/>
			<?php
				foreach($remarks['genre'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Mood :</label>
            <input type="text" id="mood_<?=$showData->id?>" name="mood[<?=$showData->id?>]" value="<?php echo $showData->mood; ?>" class="autosuggestmood WD150"/>
			<?php
				foreach($remarks['mood'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Relationship :</label>
            <input type="text" id="relationship_<?=$showData->id?>" name="relationship[<?=$showData->id?>]" value="<?php echo $showData->relationship; ?>" class="autosuggestrelationship WD150 "/>
			<?php
				foreach($remarks['relationship'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Raag :</label>
            <input type="text" id="raag_<?=$showData->id?>" name="raag[<?=$showData->id?>]" value="<?php echo $showData->raag; ?>" class="autosuggestraag WD150 "/>
			<?php
				foreach($remarks['raag'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Taal :</label>
            <input type="text" id="taal_<?=$showData->id?>" name="taal[<?=$showData->id?>]" value="<?php echo $showData->taal; ?>" class="autosuggesttaal WD150 "/>
			<?php
				foreach($remarks['taal'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Time of Day :</label>
            <input type="text" id="time_of_day_<?=$showData->id?>" name="time_of_day[<?=$showData->id?>]" value="<?php echo $showData->time_of_day; ?>" class="autosuggesttod WD150 "/>
			<?php
				foreach($remarks['time_of_day'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Religion :</label>
            <input type="text" id="religion_<?=$showData->id?>" name="religion[<?=$showData->id?>]" value="<?php echo $showData->religion; ?>" class="autosuggestreligion WD150 "/>
			<?php
				foreach($remarks['religion'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Saint :</label>
            <input type="text" id="saint_<?=$showData->id?>" name="saint[<?=$showData->id?>]" value="<?php echo $showData->saint; ?>" class="autosuggestsaint WD150 "/>
			<?php
				foreach($remarks['saint'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Instrument :</label>
            <input type="text" id="instrument_<?=$showData->id?>" name="instrument[<?=$showData->id?>]" value="<?php echo $showData->instrument; ?>" class="autosuggestinstrument WD150 "/>
			<?php
				foreach($remarks['instrument'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Festival :</label>
            <input type="text" id="festival_<?=$showData->id?>" name="festival[<?=$showData->id?>]" value="<?php echo $showData->festival; ?>" class="autosuggestfest WD150 "/>
			<?php
				foreach($remarks['festival'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Occasion :</label>
            <input type="text" id="occasion_<?=$showData->id?>" name="occasion[<?=$showData->id?>]" value="<?php echo $showData->occasion; ?>" class="autosuggestocca WD150 "/>
			<?php
				foreach($remarks['occasion'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Grade :</label>
            <input type="text" id="grade_<?=$showData->id?>" name="grade[<?=$showData->id?>]" value="<?php echo $showData->grade; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['grade']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">File Path :</label>
            <input type="text" id="file_path_<?=$showData->id?>" name="file_path[<?=$showData->id?>]" value="<?php echo $showData->file_path; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['file_path']?></span>
		  </div>
  		</div>
		<input type="hidden" name="status[<?=$showData->id?>]" value="<?=$showData->status?>" />
		<input type="hidden" name="gotodb[<?=$showData->id?>]" value="<?=$showData->gotodb?>" />
		<input type="hidden" name="batch_id" value="<?=$_GET['bid']?>" />
		<input type="hidden" name="primaryId[]" value="<?=$showData->id?>" />
        <div class="cb"></div>
		<script type="text/javascript">
		var albumOptions, albumautocom;
			jQuery(function(){
			  albumOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Album', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestalbum"};
			  albumautocom = $('#album_name_<?=$showData->id?>').autocomplete(albumOptions);
			});
		var singerOptions, singerautocom;
		jQuery(function(){
		  singerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=singer', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestsinger"};
		  singerautocom = $('#singer_<?=$showData->id?>').autocomplete(singerOptions);
		});
		var mdirectorOptions, mdirectorautocom;
			jQuery(function(){
			  mdirectorOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Music Director', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestmdirector"};
			  mdirectorautocom = $('#music_director_<?=$showData->id?>').autocomplete(mdirectorOptions);
			});	
		var lyricistOptions, lyricistautocom;
			jQuery(function(){
			  lyricistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=lyricist', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestlyricist"};
			  lyricistautocom = $('#lyricist_<?=$showData->id?>').autocomplete(lyricistOptions);
			});
		var poetOptions, poetautocom;
			jQuery(function(){
			  poetOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=poet', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestpoet"};
			  poetautocom = $('.autosuggestpoet').autocomplete(poetOptions);
			});
		var starcastOptions, starcastautocom;
			jQuery(function(){
			  starcastOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=starcast', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggeststarcast"};
			  starcastautocom = $('#starcast_<?=$showData->id?>').autocomplete(starcastOptions);
			});
		var mimicked_starOptions, mimicked_starautocom;
			jQuery(function(){
			  mimicked_starOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=starcast', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestmimicked_star"};
			  mimicked_starautocom = $('#mimicked_star_<?=$showData->id?>').autocomplete(mimicked_starOptions);
			});
		var versionOptions, versionautocom;
			jQuery(function(){
				versionOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1889&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestversion"};
				versionautocom = $('#version_<?=$showData->id?>').autocomplete(versionOptions);
			});
		var genreOptions, genreautocom;
			jQuery(function(){
				genreOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1688&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestgenre"};
				genreautocom = $('#genre_<?=$showData->id?>').autocomplete(genreOptions);
			});
		var moodOptions, moodautocom;
			jQuery(function(){
				moodOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestmood",multiple: true};
				moodautocom = $('#mood_<?=$showData->id?>').autocomplete(moodOptions);
			});
		var relationshipOptions, relationshipautocom;
			jQuery(function(){
				relationshipOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=16&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestrelationship"};
				relationshipautocom = $('#relationship_<?=$showData->id?>').autocomplete(relationshipOptions);
			});
		var raagOptions, raagautocom;
			jQuery(function(){
				raagOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1189&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestraag"};
				raagautocom = $('#raag_<?=$showData->id?>').autocomplete(raagOptions);
			});
		var taalOptions, taalautocom;
			jQuery(function(){
				taalOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1383&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggesttaal"};
				taalautocom = $('#taal_<?=$showData->id?>').autocomplete(taalOptions);
			});
		var todOptions, todautocom;
			jQuery(function(){
				todOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1415&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggesttod"};
				todautocom = $('#time_of_day_<?=$showData->id?>').autocomplete(todOptions);
			});
		var religionOptions, religionautocom;
			jQuery(function(){
				religionOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=498&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestreligion"};
				religionautocom = $('#religion_<?=$showData->id?>').autocomplete(religionOptions);
			});
		var saintOptions, saintautocom;
			jQuery(function(){
				saintOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=506&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestsaint"};
				saintautocom = $('#saint_<?=$showData->id?>').autocomplete(saintOptions);
			});
		var instrumentOptions, instrumentautocom;
			jQuery(function(){
				instrumentOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1424&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestinstrument"};
				instrumentautocom = $('#instrument_<?=$showData->id?>').autocomplete(instrumentOptions);
			});
		var festOptions, festautocom;
			jQuery(function(){
				festOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=29&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestfest"};
				festautocom = $('#festival_<?=$showData->id?>').autocomplete(festOptions);
			});
		var occaOptions, occaautocom;
			jQuery(function(){
				occaOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=487&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestocca"};
				occaautocom = $('#occasion_<?=$showData->id?>').autocomplete(occaOptions);
			});	
		</script>
    	</div>
	</div>
  	<?php
			$statusArr[]=$showData->status;
			$gotodbArr[]=$showData->gotodb;
			$s++;
			}
		}	
	?>
	<br/>
	<div class="submit" align='left' >
          <?php
		  	if(in_array(0,$gotodbArr)){
		  ?>
			  <input type="submit" value="Save" name="submitBtn" style='margin:0 auto' />
			  <?php
				if(!in_array(0,$statusArr)){
			  ?>
					<input type="submit" value="Go To DB" name="gotodb" style='margin:0 auto' />
			  <?php
				}
			}
		  ?>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/songbulk?action=view' " /> 
    </div>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->