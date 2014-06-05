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
					$class="background-color:#E9FBB4";
				}else{
					$class="background-color:#FBB4B4";
				}
	?>
	<div class="bloc" style="width: 520%;" id="bloc_<?=$showData->id?>">
	<div class="content" style="<?=$class?>">
        <div class="clearfix">
          <div class="input FL PR5">
            <label for="input">Album Name :</label>
            <input type="text" id="album_name_<?=$showData->id?>" name="album_name[<?=$showData->id?>]" value="<?php echo $showData->album_name; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['album_name']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Catalogue :</label>
            <input type="text" id="catalogue_<?=$showData->id?>" name="catalogue[<?=$showData->id?>]" value="<?php echo $showData->catalogue; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['catalogue']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['language']?></span>
          </div>
		  <div class="input FL PR5">
			<label for="input">Label :</label>
            <input type="text" id="label_<?=$showData->id?>" name="label[<?=$showData->id?>]" value="<?php echo $showData->label; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['label']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Content Type :</label>
            <input type="text" id="content_type_<?=$showData->id?>" name="content_type[<?=$showData->id?>]" value="<?php echo $showData->content_type; ?>" class="WD150 "/>
			<span class="error-message"><?=$remarks['content_type']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Movie Release Date :</label>
            <input type="text" id="title_release_date_<?=$showData->id?>" name="title_release_date[<?=$showData->id?>]" value="<?php echo $showData->title_release_date; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Release Date :</label>
            <input type="text" id="music_release_date_<?=$showData->id?>" name="music_release_date[<?=$showData->id?>]" value="<?php echo $showData->music_release_date; ?>" class="autosuggestalbum WD150 "/>
			<span class="error-message"><?=$remarks['music_release_date']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Banner :</label>
            <input type="text" id="banner_<?=$showData->id?>" name="banner[<?=$showData->id?>]" value="<?php echo $showData->banner; ?>" class="autosuggestbanner WD150 "/>
			<?php
				foreach($remarks['banner'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Primary Artist :</label>
            <input type="text" id="primary_artist_<?=$showData->id?>" name="primary_artist[<?=$showData->id?>]" value="<?php echo $showData->primary_artist; ?>" class="autosuggestmdirector WD150 "/>
			<span class="error-message"><?=$remarks['primary_artist']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Starcast :</label>
            <input type="text" id="starcast_<?=$showData->id?>" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="autosuggestlyricist WD150 "/>
			<?php
				foreach($remarks['starcast'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" id="director_<?=$showData->id?>" name="director[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="autosuggestpoet WD150 "/>
			<?php
				foreach($remarks['director'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Producer :</label>
            <input type="text" id="producer_<?=$showData->id?>" name="producer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="autosuggeststarcast WD150 "/>
			<?php
				foreach($remarks['producer'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Writer :</label>
            <input type="text" id="writer_<?=$showData->id?>" name="writer[<?=$showData->id?>]" value="<?php echo $showData->writer; ?>" class="autosuggestmimicked_star WD150 "/>
		  	<?php
				foreach($remarks['writer'] as $sinEr){
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
			<label for="input">Music Director :</label>
            <input type="text" id="music_director_<?=$showData->id?>" name="music_director[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="autosuggestmusic_director WD150 "/>
		  	<?php
				foreach($remarks['music_director'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album Type :</label>
            <input type="text" id="album_type_<?=$showData->id?>" name="album_type[<?=$showData->id?>]" value="<?php echo $showData->album_type; ?>" class="autosuggestversion WD150 "/>
			<?php
				foreach($remarks['album_type'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album Description :</label>
			<textarea id="album_description_<?=$showData->id?>" name="album_description[<?=$showData->id?>]"><?php echo $showData->album_description; ?></textarea>
			<span class="error-message"><?=$remarks['album_description']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Coupling Ids :</label>
            <input type="text" id="coupling_ids_<?=$showData->id?>" name="coupling_ids[<?=$showData->id?>]" value="<?php echo $showData->coupling_ids; ?>" class="autosuggestmood WD150"/>
			<span class="error-message"><?=$remarks['coupling_ids']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Tv Channel :</label>
            <input type="text" id="tv_channel_<?=$showData->id?>" name="tv_channel[<?=$showData->id?>]" value="<?php echo $showData->tv_channel; ?>" class="autosuggestrelationship WD150 "/>
			<?php
				foreach($remarks['tv_channel'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Radio Station :</label>
            <input type="text" id="radio_station_<?=$showData->id?>" name="radio_station[<?=$showData->id?>]" value="<?php echo $showData->radio_station; ?>" class="autosuggestraag WD150 "/>
			<?php
				foreach($remarks['radio_station'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Show Name :</label>
            <input type="text" id="show_name_<?=$showData->id?>" name="show_name[<?=$showData->id?>]" value="<?php echo $showData->show_name; ?>" class="autosuggesttaal WD150 "/>
			<span class="error-message"><?=$remarks['show_name']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Year Broadcast :</label>
            <input type="text" id="year_broadcast_<?=$showData->id?>" name="year_broadcast[<?=$showData->id?>]" value="<?php echo $showData->year_broadcast; ?>" class="autosuggesttod WD150 "/>
			<span class="error-message"><?=$remarks['year_broadcast']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Grade :</label>
            <input type="text" id="grade_<?=$showData->id?>" name="grade[<?=$showData->id?>]" value="<?php echo $showData->grade; ?>" class="autosuggestreligion WD150 "/>
			<span class="error-message"><?=$remarks['grade']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Film Rating :</label>
            <input type="text" id="film_rating_<?=$showData->id?>" name="film_rating[<?=$showData->id?>]" value="<?php echo $showData->film_rating; ?>" class="autosuggestsaint WD150 "/>
			<span class="error-message"><?=$remarks['film_rating']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Artwork File Path :</label>
            <input type="text" id="artwork_file_path_<?=$showData->id?>" name="artwork_file_path[<?=$showData->id?>]" value="<?php echo $showData->artwork_file_path; ?>" class="autosuggestinstrument WD150 "/>
			<span class="error-message"><?=$remarks['artwork_file_path']?></span>
		  </div>
  		</div>
		<input type="hidden" name="status[<?=$showData->id?>]" value="<?=$showData->status?>" />
		<input type="hidden" name="do" value="manage" />
		<input type="hidden" name="batch_id" value="<?=$_GET['bid']?>" />
		<input type="hidden" name="primaryId[]" value="<?=$showData->id?>" />
        <div class="cb"></div>
		<script type="text/javascript">
		var primary_artistOptions, primary_artistautocom;
		jQuery(function(){
		  primary_artistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=starcast', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestprimary_artistOptions"};
		  primary_artistautocom = $('#primary_artist_<?=$showData->id?>').autocomplete(primary_artistOptions);
		});
		var starcastOptions, starcastautocom;
			jQuery(function(){
			  starcastOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=starcast', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggeststarcast"};
			  starcastautocom = $('#starcast_<?=$showData->id?>').autocomplete(starcastOptions);
			});
		var directorOptions, mdirectorautocom;
			jQuery(function(){
			  directorOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Director', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestdirector"};
			  directorautocom = $('#director_<?=$showData->id?>').autocomplete(directorOptions);
		});	
		var producerOptions, producerautocom;
			jQuery(function(){
			  producerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=producer', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestproducer"};
			  producerautocom = $('#producer_<?=$showData->id?>').autocomplete(producerOptions);
		});
		var writerOptions, writerautocom;
			jQuery(function(){
			  writerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=writer', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestwriter"};
			  writerautocom = $('#writer_<?=$showData->id?>').autocomplete(writerOptions);
		});
		var lyricistOptions, lyricistautocom;
			jQuery(function(){
			  lyricistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=lyricist', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestlyricist"};
			  lyricistautocom = $('#lyricist_<?=$showData->id?>').autocomplete(lyricistOptions);
		});
		var mdirectorOptions, mdirectorautocom;
			jQuery(function(){
			  mdirectorOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Music Director', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestmusic_director"};
			  mdirectorautocom = $('#music_director_<?=$showData->id?>').autocomplete(mdirectorOptions);
		});
		var tv_channelOptions, tv_channelautocom;
			jQuery(function(){
				tv_channelOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1466&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggesttv_channel"};
				tv_channelautocom = $('#tv_channel_<?=$showData->id?>').autocomplete(tv_channelOptions);
			});
		var radio_stationOptions, radio_stationautocom;
			jQuery(function(){
				radio_stationOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id=1635&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggestradio_station"};
				radio_stationautocom = $('#radio_station_<?=$showData->id?>').autocomplete(radio_stationOptions);
			});
		var bannerOptions, bannerautocom;
			jQuery(function(){
			  bannerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=banner', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestbanner"};
			  bannerautocom = $('#banner_<?=$showData->id?>').autocomplete(bannerOptions);
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
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>albumbulk?action=view' " /> 
    </div>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->
