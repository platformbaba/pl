<!--                CONTENT 			-->
<div id="content"> 
	<div>
	  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
	  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){?>
		<?php if($aDeployment[0]->is_ready==1 && $aDeployment[0]->status!=1){?>
		<span class="FL clearfix MT40" id="ftpCont">&nbsp;&nbsp;&nbsp;<a class="button" title="Ready to deploy to WAP" href="javascript:void(0);" onclick="cms.ajaxCall({'url':'<?=SITEPATH?>wap-song-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=wap','container':'ftpCont','msg':'All data successfully deployed to WAP Server!'});">Ready to deploy to WAP</a></span>
		<?php }elseif($aDeployment[0]->status==1){?>
			<span class="FL clearfix MT40" id="ftpCont" style="color:#009966">
		<?php
			echo "These contents already deployed to WAP Server!";
		?>
			</span>	
		<?php }?>
	  <?php }?>
	  <span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'wap-song-deployment?action=add&id='.(int)$_GET['id'].'&do=song" title="Add New" class="button">Add New Song</a>'; } ?>
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
		$deploymentFolder=tools::cleaningName($aDeployment[0]->deployment_name)."-".$aDeployment[0]->deployment_id;
		if( !empty($aContent) ){
			$s=1;
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
				if($providerDetails['status']==1){
					$class="background-color:#E9FBB4;";
				}else{
					$class="background-color:#FBB4B4;";
				}
	?>
	<div class="bloc" style="width: 500%;" id="bloc_<?=$showData->id?>">
	<div class="content" style="<?=$class?>">
        <div class="clearfix">
		   <div class="input FL PR5">
            <label for="input">Category :</label>
			<select class="textarea1" id="category_<?=$showData->id?>" name="category[<?=$showData->id?>]">
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
          </div>	
		  <div class="input FL PR5">
			<label for="input">Sub Category :</label>
            <input type="text" id="album_<?=$showData->id?>" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150 "/>
		  </div>
          <div class="input FL PR5">
            <label for="input">Description :</label>
            <input type="text" id="songTitle_<?=$showData->id?>" name="songTitle[<?=$showData->id?>]" value="<?php echo ucwords(strtolower($showData->title)); ?>" class="WD150 " />
          </div>
		  <div class="input FL PR5">
			<label for="input">Search Keywords :</label>
            <input type="text" id="searchKey_<?=$showData->id?>" name="searchKey[<?=$showData->id?>]" value="<?php echo $showData->search_key; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Vendor Id :</label>
            <select class="textarea1" name="vendor[<?=$showData->id?>]" id="vendor_<?=$showData->id?>">
				<option value="1" <?=($providerDetails['vendorId']==1)?"selected='selected'":""?>>Sa Re Ga Ma</option>
				<option value="2" <?=($providerDetails['vendorId']==2)?"selected='selected'":""?>>Bikini.com</option>
				<option value="3" <?=($providerDetails['vendorId']==3)?"selected='selected'":""?>>Nitizart</option>
				<option value="4" <?=($providerDetails['vendorId']==4)?"selected='selected'":""?>>Trigma</option>
				<option value="5" <?=($providerDetails['vendorId']==5)?"selected='selected'":""?>>Binaca Tunes</option>
				<option value="6" <?=($providerDetails['category']==6)?"selected='selected'":""?>>Stardust</option>
				<option value="7" <?=($providerDetails['vendorId']==7)?"selected='selected'":""?>>Galatta</option>
				<option value="8" <?=($providerDetails['vendorId']==8)?"selected='selected'":""?>>Apricot</option>
			</select>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Display File Name :</label>
            <input type="text" id="display" name="display[<?=$showData->id?>]" value="<?php echo $providerDetails['display']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Actor Actress :</label>
            <input type="text" id="starcast_<?=$showData->id?>" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Year :</label>
            <input type="text" id="releaseYear_<?=$showData->id?>" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->release_year; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" id="genre_<?=$showData->id?>" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Mood :</label>
            <input type="text" id="mood_<?=$showData->id?>" name="mood[<?=$showData->id?>]" value="<?php echo $providerDetails['mood']; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Director :</label>
            <input type="text" id="musicDirector_<?=$showData->id?>" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Label :</label>
            <input type="text" id="label_<?=$showData->id?>" name="label[<?=$showData->id?>]" value="<?php echo $providerDetails['label']; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Rights :</label>
            <input type="text" id="rights_<?=$showData->id?>" name="rights[<?=$showData->id?>]" value="<?php echo $providerDetails['rights']; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 " />
          </div>
		  <div class="input FL PR5">
			<label for="input">Singer :</label>
            <input type="text" id="singer_<?=$showData->id?>" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="WD150 "/>
		  </div>	
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Producer :</label>
            <input type="text" id="keyProducer_<?=$showData->id?>"  name="keyProducer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" id="keyDirector_<?=$showData->id?>" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Primary Artist :</label>
            <input type="text" id="keyArtist_<?=$showData->id?>" name="keyArtist[<?=$showData->id?>]" value="<?php echo $showData->keyartist; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">ISRC Code :</label>
            <input type="text" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Distribution Rights :</label>
            <input type="text" id="distributionRights_<?=$showData->id?>" name="distributionRights[<?=$showData->id?>]" value="<?php echo $providerDetails['distributionRights']; ?>" class="WD150 "/>
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">Wap Preview :</label>
			<br/>
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
			<label for="input" style="display: inline-table">Web Preview :</label>
			<br/>
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
			<label for="input" style="display: inline-table">AMR :</label>
			<br/>
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
			<label for="input" style="display: inline-table">AWB :</label>
			<br/>
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
			<label for="input" style="display: inline-table">MP3_1MB :</label>
			<br/>
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
			<label for="input" style="display: inline-table">HQ :</label>
			<br/>
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
			<label for="input" style="display: inline-table">WMA :</label>
			<br/>
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
		  <div class="input FL PR5">
			<a class="button" title="Rmove this song from deployment" onclick="removeSongFromImi({'id':'<?=$showData->id?>','afile':'','xfile':''})" href="javascript:void(0);">Remove This Song</a>
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
          <?php
		  	if($aDeployment[0]->status!=1){
		  ?>
		  <input type="submit" value="Save" name="submitBtn" style='margin:0 auto' />
		  <?php
		  	}
		  ?>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>wap-song-deployment?action=view' " /> 
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