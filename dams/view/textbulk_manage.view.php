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
            <label for="input">Text Title :</label>
            <input type="text" id="text_title_<?=$showData->id?>" name="text_title[<?=$showData->id?>]" value="<?php echo $showData->text_title; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['text_title']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Text Type :</label>
            <input type="text" id="text_type_<?=$showData->id?>" name="text_type[<?=$showData->id?>]" value="<?php echo $showData->text_type; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['text_type']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Text Language :</label>
            <input type="text" id="text_language_<?=$showData->id?>" name="text_language[<?=$showData->id?>]" value="<?php echo $showData->text_language; ?>" class="WD150 " />
			<span class="error-message"><?=$remarks['text_language']?></span>
          </div>
		  <div class="input FL PR5">
            <label for="input">Text Description :</label>
            <input type="text" id="text_description_<?=$showData->id?>" name="text_description[<?=$showData->id?>]" value="<?php echo $showData->text_description; ?>" class="WD150 " />
          </div>
		  <div class="input FL PR5">
			<label for="input">Album Name :</label>
            <input type="text" id="album_name_<?=$showData->id?>" name="album_name[<?=$showData->id?>]" value="<?php echo $showData->album_name; ?>" class="autosuggestalbum WD150 "/>
			<span class="error-message"><?=$remarks['album_name']?></span>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Artist Name :</label>
            <input type="text" id="artist_name_<?=$showData->id?>" name="artist_name[<?=$showData->id?>]" value="<?php echo $showData->artist_name; ?>" class="autosuggestsinger WD150 "/>
			<?php
				foreach($remarks['artist_name'] as $sinEr){
			?>
				<span class="error-message"><?=$sinEr?></span>
			<?php
			}
			?>
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
		  singerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestsinger"};
		  singerautocom = $('#artist_name_<?=$showData->id?>').autocomplete(singerOptions);
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
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/textbulk?action=view' " /> 
    </div>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->