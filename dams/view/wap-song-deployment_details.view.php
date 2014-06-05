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
		$deploymentFolder=tools::cleaningName($aDeployment[0]->deployment_name)."-".$aDeployment[0]->deployment_id;
		if( !empty($aContent) ){
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
	?>
	<div class="bloc" id="bloc_<?=$showData->id?>">
	<div class="content" >
        <div class="clearfix">
		   <div class="input FL PR5">
            Category :
			<label for="input" style="display: inline-table">
			<select class="textarea1" id="category_<?=$showData->id?>" name="category[<?=$showData->id?>]" disabled="disabled">
				<option value="1" <?=($providerDetails['category']==1)?"selected='selected'":""?>>Bollywood</option>
				<option value="2" <?=($providerDetails['category']==2)?"selected='selected'":""?>>Devotional</option>
				<option value="3" <?=($providerDetails['category']==3)?"selected='selected'":""?>>Hollywood</option>
				<option value="4" <?=($providerDetails['category']==4)?"selected='selected'":""?>>Regional</option>
				<option value="5" <?=($providerDetails['category']==5)?"selected='selected'":""?>>Models</option>
				<option value="6" <?=($providerDetails['category']==6)?"selected='selected'":""?>>Generic</option>
				<option value="7" <?=($providerDetails['category']==7)?"selected='selected'":""?>>Festival</option>
				<option value="8" <?=($providerDetails['category']==8)?"selected='selected'":""?>>Patriotic</option>
				<option value="9" <?=($providerDetails['category']==9)?"selected='selected'":""?>>vuclip</option>
			</select>
			</label>
          </div>	
		  <div class="input FL PR5">
			Sub Category :
			<label for="input" style="display: inline-table">
            <?php echo $showData->album; ?>
			</label>
		  </div>
          <div class="input FL PR5">
            Description :
			<label for="input" style="display: inline-table">
            <?php echo ucwords(strtolower($showData->title)); ?>
			</label>
          </div>
		  <div class="input FL PR5">
			Search Keywords :
            <label for="input" style="display: inline-table">
			<?php echo $showData->search_key; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Vendor Id :
			<label for="input" style="display: inline-table">
            <select class="textarea1" name="vendor[<?=$showData->id?>]" id="vendor_<?=$showData->id?>" disabled="disabled">
				<option value="1" <?=($providerDetails['vendorId']==1)?"selected='selected'":""?>>Sa Re Ga Ma</option>
				<option value="2" <?=($providerDetails['vendorId']==2)?"selected='selected'":""?>>Bikini.com</option>
				<option value="3" <?=($providerDetails['vendorId']==3)?"selected='selected'":""?>>Nitizart</option>
				<option value="4" <?=($providerDetails['vendorId']==4)?"selected='selected'":""?>>Trigma</option>
				<option value="5" <?=($providerDetails['vendorId']==5)?"selected='selected'":""?>>Binaca Tunes</option>
				<option value="6" <?=($providerDetails['category']==6)?"selected='selected'":""?>>Stardust</option>
				<option value="7" <?=($providerDetails['vendorId']==7)?"selected='selected'":""?>>Galatta</option>
				<option value="8" <?=($providerDetails['vendorId']==8)?"selected='selected'":""?>>Apricot</option>
			</select>
			</label>
		  </div>
		  <div class="input FL PR5">
			Display File Name :
            <label for="input" style="display: inline-table">
			<?php echo $providerDetails['display']; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Actor Actress :
            <label for="input" style="display: inline-table">
			<?php echo $showData->starcast; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
            <label for="input" style="display: inline-table">
				<?php echo $showData->release_year; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
            <label for="input" style="display: inline-table">
			<?php echo $showData->genre; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Mood :
            <label for="input" style="display: inline-table">
			<?php echo $providerDetails['mood']; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Music Director :
            <label for="input" style="display: inline-table">
			<?php echo $showData->music_director; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Music Label :
            <label for="input" style="display: inline-table">
			<?php echo $providerDetails['label']; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Rights :
			<label for="input" style="display: inline-table">
            <?php echo $providerDetails['rights']; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
            Language :
			<label for="input" style="display: inline-table">
            <?php echo $showData->language; ?>
			</label>
          </div>
		  <div class="input FL PR5">
			Singer :
            <label for="input" style="display: inline-table">
			<?php echo $showData->singer; ?>
			</label>
		  </div>	
		  <div class="input FL PR5">
			Lyricist :
            <label for="input" style="display: inline-table">
			<?php echo $showData->lyricist; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Producer :
			<label for="input" style="display: inline-table">
            <?php echo $showData->producer; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Director :
            <label for="input" style="display: inline-table">
			<?php echo $showData->director; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Primary Artist :
			<label for="input" style="display: inline-table">
            <?php echo $showData->keyartist; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			ISRC Code :
			<label for="input" style="display: inline-table">
            <?php echo $showData->isrc; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Distribution Rights :
			<label for="input" style="display: inline-table">
            <?php echo $providerDetails['distributionRights']; ?>
			</label>
		  </div>
		  <div class="input FL PR5">
			Wap Preview :
			<?php
				if($providerDetails['wappreview']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wappreview']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wappreview']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wappreview']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wappreview']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }else{ echo "upload file first.";}?>
			<input type="hidden" name="wappreview[<?=$showData->id?>]" value="<?=$providerDetails['wappreview']?>" />
		  </div>
		  <div class="input FL PR5">
			Web Preview :
			<?php
				if($providerDetails['webpreview']){
			?>
			<audio id="audiox2_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['webpreview']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['webpreview']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['webpreview']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['webpreview']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }else{ echo "upload file first.";}?>
			<input type="hidden" name="webpreview[<?=$showData->id?>]" value="<?=$providerDetails['webpreview']?>" />
		  </div>
		  <div class="input FL PR5">
			AMR :
			<?php
				if($providerDetails['amr']){
			?>
			<audio id="audiox3_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['amr']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['amr']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['amr']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['amr']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }else{ echo "upload file first.";} ?>
			<input type="hidden" name="amr[<?=$showData->id?>]" value="<?=$providerDetails['amr']?>" />
		  </div>
		  <div class="input FL PR5">
			AWB :
			<?php
				if($providerDetails['awb']){
			?>
			<audio id="audiox4_<?=$showData->id?>" style="width: 200px;"  src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['awb']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['awb']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['awb']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['awb']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }else{ echo "upload file first.";}  ?>
			<input type="hidden" name="awb[<?=$showData->id?>]" value="<?=$providerDetails['awb']?>" />
		  </div>
		  <div class="input FL PR5">
			MP3_1MB :
			<?php
				if($providerDetails['1mb']){
			?>
			<audio id="audiox4_<?=$showData->id?>" style="width: 200px;"  src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['1mb']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['1mb']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['1mb']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['1mb']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }else{ echo "upload file first.";}  ?>
			<input type="hidden" name="1mb[<?=$showData->id?>]" value="<?=$providerDetails['1mb']?>" />
		  </div>
		  <div class="input FL PR5">
			HQ :
			<?php
				if($providerDetails['hq']){
			?>
			<audio id="audiox4_<?=$showData->id?>" style="width: 200px;"  src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['hq']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['hq']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['hq']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['hq']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }else{ echo "upload file first.";}  ?>
			<input type="hidden" name="hq[<?=$showData->id?>]" value="<?=$providerDetails['hq']?>" />
		  </div>
		  <div class="input FL PR5">
			WMA :
			<?php
				if($providerDetails['wma']){
			?>
			<audio id="audiox4_<?=$showData->id?>" style="width: 200px;"  src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wma']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wma']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wma']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$providerDetails['wma']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }else{ echo "upload file first.";}  ?>
			<input type="hidden" name="wma[<?=$showData->id?>]" value="<?=$providerDetails['wma']?>" />
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
			}
		}	
	?>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->