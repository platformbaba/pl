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
<?php
$pJson=json_decode($aContent[0]->providers_details,true);
$ddFolder=$pJson['PPID'];
?>
<div>
  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){?>
  	<?php if($aDeployment[0]->is_ready==1 || $aDeployment[0]->is_ready==2){?>
  	<span class="FL clearfix MT40">&nbsp;&nbsp;&nbsp;<a class="button" title="" href="<?=SITEPATH?>nokia-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=xml">Generate XML File</a></span>  
	<span class="FL clearfix MT40">&nbsp;&nbsp;&nbsp;<a  class="fancybox fancybox.iframe button" title="View Contents" href="<?=SITEPATH?>explorer?action=view&isPlane=1&ldir=<?=MEDIA_READ_SEVERPATH_DEPLOY.$ddFolder?>&dir=<?=MEDIA_READ_SEVERPATH_DEPLOY.$ddFolder?>">View Contents</a></span>
	<?php }?>
	<?php if($aDeployment[0]->is_ready==2){?>
	<span class="FL clearfix MT40" id="ftpCont">&nbsp;&nbsp;&nbsp;<a class="button" title="Move to FTP Location" href="javascript:void(0);" onclick="cms.ajaxCall({'url':'<?=SITEPATH?>nokia-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=ftp','container':'ftpCont','msg':'Folder successfully uploaded to Nokia Ftp!'});">Move to FTP Location</a></span>  
	<?php }?>
  <?php }?>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'nokia-deployment?action=add&id='.(int)$_GET['id'].'&do=song" title="Add New" class="button">Add New Song</a>'; } ?>
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
		if( !empty($aContent) ){
			$s=1;
			$fJson=json_decode($aContent[0]->providers_details,true);
			$file_1400x1400=$fJson['file_1400x1400'];
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
				$deploymentFolder=$providerDetails['PPID'];
	?>
	<div class="bloc" style="width: 400%;" id="bloc_<?=$showData->id?>">
	<div class="content">
        <div class="clearfix">
		  <div class="input FL PR5">
			<label for="input">ISRC :</label>
            <input type="text" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">PPID :</label>
            <input type="text" id="ppid_<?=$showData->id?>" name="ppid[<?=$showData->id?>]" value="<?php echo $providerDetails['PPID']; ?>" class="WD150 validate[required]"/>
		  </div>	
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" id="genre_<?=$showData->id?>" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Sub Genre :</label>
            <input type="text" id="subgenre_<?=$showData->id?>" name="subgenre[<?=$showData->id?>]" value="<?php echo $providerDetails['subGenre']; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Is Compilation :</label>
            <input type="text" id="compilation_<?=$showData->id?>" name="compilation[<?=$showData->id?>]" value="<?php echo $providerDetails['isCompilation']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album :</label>
            <input type="text" id="album_<?=$showData->id?>" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Primary Artist :</label>
            <input type="text" id="keyArtist_<?=$showData->id?>" name="keyArtist[<?=$showData->id?>]" value="<?php echo $showData->keyartist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Track :</label>
            <input type="text" id="songTitle_<?=$showData->id?>" name="songTitle[<?=$showData->id?>]" value="<?php echo $showData->title; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Track Artist :</label>
            <input type="text" id="singer_<?=$showData->id?>" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Composer :</label>
            <input type="text" id="musicDirector_<?=$showData->id?>" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Banner :</label>
            <input type="text" id="banner_<?=$showData->id?>" name="banner[<?=$showData->id?>]" value="<?php echo $providerDetails['banner']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Producer :</label>
            <input type="text" id="keyProducer_<?=$showData->id?>"  name="keyProducer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" id="keyDirector_<?=$showData->id?>" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
            <label for="input">Copyright :</label>
            <input type="text" id="copyright_<?=$showData->id?>" name="copyright[<?=$showData->id?>]" value="<?php echo $providerDetails['copyright']; ?>" class="WD150 copyCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"copyCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Publish :</label>
            <input type="text" id="publish_<?=$showData->id?>" name="publish[<?=$showData->id?>]" value="<?php echo $providerDetails['publish']; ?>" class="WD150 pubCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"pubCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Label :</label>
            <input type="text" id="label_<?=$showData->id?>" name="label[<?=$showData->id?>]" value="<?php echo $providerDetails['label']; ?>" class="WD150 labCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"labCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Right To :</label>
            <input type="text" id="rightto_<?=$showData->id?>" name="rightto[<?=$showData->id?>]" value="<?php echo $providerDetails['rightTo']; ?>" class="WD150 labCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"labCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
			<label for="input">Release Year:</label>
            <input type="text" id="releaseYear_<?=$showData->id?>" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->album_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Territory:</label>
            <input type="text" id="territory_<?=$showData->id?>" name="territory[<?=$showData->id?>]" value="<?php echo $providerDetails['territory']; ?>" class="WD150 terr  validate[required]" <?=($s==1)?"onkeyup='applySame({\"cls\":\"terrCls\",\"val\":this.value})'":""?> />
		  </div>
		  <div class="input FL PR5">
			<label for="input">Actual Duration:</label>
            <input type="text" id="duration_<?=$showData->id?>" name="duration[<?=$showData->id?>]" value="<?php echo $providerDetails['duration']; ?>" class="WD150 validate[required]"/>
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
			<input type="file" name="file_full[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_full[<?=$showData->id?>]" value="<?=$providerDetails['file']?>" />
		  </div>
		  <div class="input FL PR5">
			<a class="button" title="Rmove this song from deployment" onclick="removeSongFromImi({'id':'<?=$showData->id?>','afile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['file']?>','xfile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/"?>bundle.xml'})" href="javascript:void(0);">Remove This Song</a>
		  </div>
		</div>
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="ppIdOne" value="<?=$providerDetails['PPID']?>" />
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
	<div class="input FL PR5">
			<label for="input" style="display: inline-table"><b>Image 1400x1400 jpg :</b></label>
			<?php
				if($file_1400x1400){
			?>
			<a class="zoombox" href="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$file_1400x1400."?".date("His");?>" title="view <?=$file_1400x1400?>"/><?=$file_1400x1400?></a>
			<br/>
			<?php }?>
			<input type="file" name="file_1400x1400" accept="image/jpg"  />
			<input type="hidden" name="hidden_file_1400x1400" value="<?=$file_1400x1400?>" />
	</div><br/><br/><br/><br/>
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