<!--                CONTENT 			-->
<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#srcFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<div id="content">
<div>
  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){?>
  	<?php if($aDeployment[0]->is_ready){?>
  	<span class="FL clearfix MT40">&nbsp;&nbsp;&nbsp;<a class="button" title="" href="<?=SITEPATH?>reliance-audio-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=zip">Generate Zip File</a></span>  
	<?php }?>
  <?php }?>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'reliance-audio-deployment?action=add&id='.(int)$_GET['id'].'&do=song" title="Add New" class="button">Add New Song</a>'; } ?>
	</span>
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
		$deploymentFolder=tools::deploymentFolderName(array('name'=>$aDeployment[0]->deployment_name))."-".$aDeployment[0]->deployment_id;
		if( !empty($aContent) ){
			$s=1;
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
	?>
	<div class="bloc" style="width: 700%;" id="bloc_<?=$showData->id?>">
	<div class="content">
        <div class="clearfix">
          <div class="input FL PR5">
            <label for="input">Song Title :</label>
            <input type="text" id="songTitle_<?=$showData->id?>" name="songTitle[<?=$showData->id?>]" value="<?php echo $showData->title; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Origial Code :</label>
            <input type="text" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album :</label>
            <input type="text" id="album_<?=$showData->id?>" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Category :</label>
            <input type="text" id="category_<?=$showData->id?>" name="category[<?=$showData->id?>]" value="<?php echo $providerDetails['category']; ?>" class="WD150 catCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"catCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Sub Category :</label>
            <input type="text" id="subCategory_<?=$showData->id?>" name="subCategory[<?=$showData->id?>]" value="<?php echo $providerDetails['subCategory']; ?>" class="WD150 subCatCls validate[required]"
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"subCatCls\",\"val\":this.value})'":""?> />
          </div>
 		  <div class="input FL PR5">
            <label for="input">Film/Non Film :</label>
            <input type="text" id="filmNonfilm_<?=$showData->id?>" name="filmNonfilm[<?=$showData->id?>]" value="<?php echo $providerDetails['isFilm']; ?>" class="WD150 filmNonfilmCls validate[required]"
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"filmNonfilmCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
			<label for="input">Start Date :</label>
            <input type="text" id="startDate_<?=$showData->id?>" name="startDate[<?=$showData->id?>]" value="<?php echo $providerDetails['startDate']; ?>" class="datepicker stdCls validate[required]"		            <?=($s==1)?"onkeyup='applySame({\"cls\":\"stdCls\",\"val\":this.value})'":""?>/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">End Date :</label>
            <input type="text" id="endDate_<?=$showData->id?>" name="endDate[<?=$showData->id?>]" value="<?php echo $providerDetails['endDate']; ?>" class="datepicker endCls validate[required]" <?=($s==1)?"onkeyup='applySame({\"cls\":\"endCls\",\"val\":this.value})'":""?>/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Artist :</label>
            <input type="text" id="keyArtist_<?=$showData->id?>" name="keyArtist[<?=$showData->id?>]" value="<?php echo $showData->keyartist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Director :</label>
            <input type="text" id="musicDirector_<?=$showData->id?>" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" id="keyDirector_<?=$showData->id?>" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Producer :</label>
            <input type="text" id="keyProducer_<?=$showData->id?>"  name="keyProducer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Starcast :</label>
            <input type="text" id="starcast_<?=$showData->id?>" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="WD150 validate[required]" />
		  </div>
		  <div class="input FL PR5">
			<label for="input">Search Keywords :</label>
            <input type="text" id="searchKey_<?=$showData->id?>" name="searchKey[<?=$showData->id?>]" value="<?php echo $showData->search_key; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Year of Release :</label>
            <input type="text" id="releaseYear_<?=$showData->id?>" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->release_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album Year :</label>
            <input type="text" id="albumYear_<?=$showData->id?>" name="albumYear[<?=$showData->id?>]" value="<?php echo $showData->album_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Copyright :</label>
            <input type="text" id="copyright_<?=$showData->id?>" name="copyright[<?=$showData->id?>]" value="<?php echo $providerDetails['copyright']; ?>" class="WD150 copyCls validate[required]" <?=($s==1)?"onkeyup='applySame({\"cls\":\"copyCls\",\"val\":this.value})'":""?>/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Label :</label>
            <input type="text" id="label_<?=$showData->id?>" name="label[<?=$showData->id?>]" value="<?php echo $providerDetails['label']; ?>" class="WD150 labelCls validate[required]" <?=($s==1)?"onkeyup='applySame({\"cls\":\"labelCls\",\"val\":this.value})'":""?>/>
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Wap Preview amr :</label>
			<?=$providerDetails['WapPreviewAmr']?><br/>
			<?php
				if($providerDetails['WapPreviewAmr']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewAmr_arr']){
					foreach($providerDetails['file_WapPreviewAmr_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewAmr_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_WapPreviewAmr[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_WapPreviewAmr[<?=$showData->id?>]" value="<?=$providerDetails['WapPreviewAmr']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Wap/Web Preview mp3 :</label>
			<?=$providerDetails['WapPreviewMp3']?><br/>
			<?php
				if($providerDetails['WapPreviewMp3']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewMp3_arr']){
					foreach($providerDetails['file_WapPreviewMp3_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewMp3_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_WapPreviewMp3[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_WapPreviewMp3[<?=$showData->id?>]" value="<?=$providerDetails['WapPreviewMp3']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Wap Preview gif(50x50) :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewGif5050']."?".date("His");?>" class="zoombox" ><?=$providerDetails['WapPreviewGif5050']?></a><br/>
			<?php
				if($providerDetails['WapPreviewGif5050']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewGif5050']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewGif5050_arr']){
					foreach($providerDetails['file_WapPreviewGif5050_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewGif5050_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$fVal."?".date("His");?>" style="display:none" />
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_WapPreviewGif5050[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_WapPreviewGif5050[<?=$showData->id?>]" value="<?=$providerDetails['WapPreviewGif5050']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Web Preview gif(101x80) :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif10180']."?".date("His");?>" class="zoombox" ><?=$providerDetails['WebPreviewGif10180']?></a><br/>
			<?php
				if($providerDetails['WebPreviewGif10180']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif10180']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_WebPreviewGif10180_arr']){
					foreach($providerDetails['file_WebPreviewGif10180_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WebPreviewGif10180_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none"  />
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_WebPreviewGif10180[<?=$showData->id?>]" accept="image/gif"  />
			<input type="hidden" name="hidden_file_WebPreviewGif10180[<?=$showData->id?>]" value="<?=$providerDetails['WebPreviewGif10180']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Web Preview gif(96x96) :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif9696']."?".date("His");?>" class="zoombox" ><?=$providerDetails['WebPreviewGif9696']?></a><br/>
			<?php
				if($providerDetails['WebPreviewGif9696']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif9696']."?".date("His");?>"  style="display:none"/>
			<br/>
			<?php }elseif($providerDetails['file_WebPreviewGif9696_arr']){
					foreach($providerDetails['file_WebPreviewGif9696_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WebPreviewGif9696_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none" />
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_WebPreviewGif9696[<?=$showData->id?>]" accept="image/gif"  />
			<input type="hidden" name="hidden_file_WebPreviewGif9696[<?=$showData->id?>]" value="<?=$providerDetails['WebPreviewGif9696']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">FLA Object Mp3 :</label>
			<?=$providerDetails['FlaObjMp3']?><br/>
			<?php
				if($providerDetails['FlaObjMp3']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_FlaObjMp3_arr']){
					foreach($providerDetails['file_FlaObjMp3_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObjMp3_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_FlaObjMp3[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_FlaObjMp3[<?=$showData->id?>]" value="<?=$providerDetails['FlaObjMp3']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">FLA Object amr :</label>
			<?=$providerDetails['FlaObjAmr']?><br/>
			<?php
				if($providerDetails['FlaObjAmr']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_FlaObjAmr_arr']){
					foreach($providerDetails['file_FlaObjAmr_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObjAmr_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_FlaObjAmr[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_FlaObjAmr[<?=$showData->id?>]" value="<?=$providerDetails['FlaObjAmr']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">FLA Object 140x140 jpg :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj140140Jpg']."?".date("His");?>" class="zoombox" ><?=$providerDetails['FlaObj140140Jpg']?></a><br/>
			<?php
				if($providerDetails['FlaObj140140Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj140140Jpg']."?".date("His");?>" style="display:none"  />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj140140Jpg_arr']){
					foreach($providerDetails['file_FlaObj140140Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj140140Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none"  />
					<br/>		
			<?php	}
			}?>
			<input type="file" name="file_FlaObj140140Jpg[<?=$showData->id?>]" accept="image/jpg"  />
			<input type="hidden" name="hidden_file_FlaObj140140Jpg[<?=$showData->id?>]" value="<?=$providerDetails['FlaObj140140Jpg']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">FLA Object 300x300 jpg :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj300300Jpg']."?".date("His");?>" class="zoombox" ><?=$providerDetails['FlaObj300300Jpg']?></a><br/>
			<?php
				if($providerDetails['FlaObj300300Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj300300Jpg']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj300300Jpg_arr']){
					foreach($providerDetails['file_FlaObj300300Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj300300Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none" />
						<br/>		
			<?php	}
			}?>
			<input type="file" name="file_FlaObj300300Jpg[<?=$showData->id?>]" accept="image/jpg"  />
			<input type="hidden" name="hidden_file_FlaObj300300Jpg[<?=$showData->id?>]" value="<?=$providerDetails['FlaObj300300Jpg']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">FLA Object 500x500 jpg :</label>
			<a href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj500500Jpg']."?".date("His");?>" class="zoombox" ><?=$providerDetails['FlaObj500500Jpg']?></a><br/>
			<?php
				if($providerDetails['FlaObj500500Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj500500Jpg']."?".date("His");?>" style="display:none"  />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj500500Jpg_arr']){
					foreach($providerDetails['file_FlaObj500500Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj500500Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  /><?=$fVal?>
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>"  style="display:none" />
						<br/>		
			<?php	}
			}?>
			<input type="file" name="file_FlaObj500500Jpg[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_FlaObj500500Jpg[<?=$showData->id?>]" value="<?=$providerDetails['FlaObj500500Jpg']?>" />
		  </div>
		  <div class="input FL PR5">
			<a class="button" title="Rmove this song from deployment" onclick="removeSongFromImi({'id':'<?=$showData->id?>','afile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewGif5050']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif10180']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif9696']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj140140Jpg']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj300300Jpg']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj500500Jpg']?>','xfile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$showData->isrc?>.xml'})" href="javascript:void(0);">Remove This Song</a>
		  </div>
		</div>
		<input type="hidden" name="providerCode[<?=$showData->id?>]" value="<?=$providerDetails['providerCode']?>" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="deploymentId" value="<?=(int)$_GET['id']?>" />
		<input type="hidden" name="do" value="manage" />
		<input type="hidden" name="contentId[<?=$showData->id?>]" value="<?=$showData->content_id?>" />
		<input type="hidden" name="primaryId[]" value="<?=$showData->id?>" />
        <div class="cb"></div>
    	</div>
	</div>
  	<?php
			$s++;
			}
		}	
	?>
	<br/>
	<div class="submit" align='left' >
          <input type="submit" value="Save" name="submitBtn" style='margin:0 auto' />
    </div>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->
<script type="text/javascript">
function applySame(obj){
	var className=obj.cls;
	var classValue=obj.val;
	$("."+className).val(classValue);	
}
function removeSongFromImi(obj){
	var r=confirm("Are you sure?");
	if (r==true){
		var id=obj.id;
		var afile=obj.afile;
		var xfile=obj.xfile;
		$.post( "<?=SITEPATH?>ajax?action=view&type=rmimisong",{ id: id, afile: afile, xfile:xfile }, function( data ) {
			if(data=="1"){
				$("#bloc_"+id).hide();		
			}
		});
	}
}
</script>