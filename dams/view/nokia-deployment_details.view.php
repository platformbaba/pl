<!--                CONTENT 			-->
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
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
			#$file_1400x1400=json_decode($aContent[0]->providers_details,true)['file_1400x1400'];
			$fJson=json_decode($aContent[0]->providers_details,true);
			$file_1400x1400=$fJson['file_1400x1400'];
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
				$deploymentFolder=$providerDetails['PPID'];
	?>
	<div class="bloc" id="bloc_<?=$showData->id?>" style="margin-top: 0px;">
	<div class="content">
        <div class="clearfix">
		  <div class="input FL PR5">
			<label for="input">ISRC :</label>
            <input type="text" disabled="disabled" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">PPID :</label>
            <input type="text" disabled="disabled" id="ppid_<?=$showData->id?>" name="ppid[<?=$showData->id?>]" value="<?php echo $providerDetails['PPID']; ?>" class="WD150 validate[required]"/>
		  </div>	
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" disabled="disabled" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" disabled="disabled" id="genre_<?=$showData->id?>" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Sub Genre :</label>
            <input type="text" disabled="disabled" id="subgenre_<?=$showData->id?>" name="subgenre[<?=$showData->id?>]" value="<?php echo $providerDetails['subGenre']; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Is Compilation :</label>
            <input type="text" disabled="disabled" id="compilation_<?=$showData->id?>" name="compilation[<?=$showData->id?>]" value="<?php echo $providerDetails['isCompilation']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album :</label>
            <input type="text" disabled="disabled" id="album_<?=$showData->id?>" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Primary Artist :</label>
            <input type="text" disabled="disabled" id="keyArtist_<?=$showData->id?>" name="keyArtist[<?=$showData->id?>]" value="<?php echo $showData->keyartist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Track :</label>
            <input type="text" disabled="disabled" id="songTitle_<?=$showData->id?>" name="songTitle[<?=$showData->id?>]" value="<?php echo $showData->title; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Track Artist :</label>
            <input type="text" disabled="disabled" id="singer_<?=$showData->id?>" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Composer :</label>
            <input type="text" disabled="disabled" id="musicDirector_<?=$showData->id?>" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" disabled="disabled" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Banner :</label>
            <input type="text" disabled="disabled" id="banner_<?=$showData->id?>" name="banner[<?=$showData->id?>]" value="<?php echo $providerDetails['banner']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Producer :</label>
            <input type="text" disabled="disabled" id="keyProducer_<?=$showData->id?>"  name="keyProducer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" disabled="disabled" id="keyDirector_<?=$showData->id?>" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Copyright :</label>
            <input type="text" disabled="disabled" id="copyright_<?=$showData->id?>" name="copyright[<?=$showData->id?>]" value="<?php echo $providerDetails['copyright']; ?>" class="WD150 copyCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"copyCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Publish :</label>
            <input type="text" disabled="disabled" id="publish_<?=$showData->id?>" name="publish[<?=$showData->id?>]" value="<?php echo $providerDetails['publish']; ?>" class="WD150 pubCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"pubCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Label :</label>
            <input type="text" disabled="disabled" id="label_<?=$showData->id?>" name="label[<?=$showData->id?>]" value="<?php echo $providerDetails['label']; ?>" class="WD150 labCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"labCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Right To :</label>
            <input type="text" disabled="disabled" id="rightto_<?=$showData->id?>" name="rightto[<?=$showData->id?>]" value="<?php echo $providerDetails['rightTo']; ?>" class="WD150 labCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"labCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
			<label for="input">Release Year:</label>
            <input type="text" disabled="disabled" id="releaseYear_<?=$showData->id?>" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->album_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Territory:</label>
            <input type="text" disabled="disabled" id="territory_<?=$showData->id?>" name="territory[<?=$showData->id?>]" value="<?php echo $providerDetails['territory']; ?>" class="WD150 terr  validate[required]" <?=($s==1)?"onkeyup='applySame({\"cls\":\"terrCls\",\"val\":this.value})'":""?> />
		  </div>
		  <div class="input FL PR5">
			<label for="input">Actual Duration:</label>
            <input type="text" disabled="disabled" id="duration_<?=$showData->id?>" name="duration[<?=$showData->id?>]" value="<?php echo $providerDetails['duration']; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Audio File :</label>
			<?=$providerDetails['file']?><br/>
			<?php
				if($providerDetails['file']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['file']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['file']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['file']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['file']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['fileFullArr']){
					foreach($providerDetails['fileFullArr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_full_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
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
			<input type="hidden" name="hidden_file_full[<?=$showData->id?>]" value="<?=$providerDetails['file']?>" />
		  </div>
		</div>
        <div class="cb"></div>
	</div>
	</div>
  	<?php
			}
		}	
	?>
</form>
<div class="bloc">
	<div class="content">
		<div class="clearfix">
			<div class="cb"><a class="zoombox" href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$file_1400x1400."?".date("His");?>" title="view <?=$file_1400x1400?>"/><?=$file_1400x1400?></a>
			</div>
		</div>
	</div>		
</div>	  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->