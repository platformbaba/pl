<!--            
    CONTENT 
			-->

<div id="content">
<div>
  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){?>
  	<?php if($aDeployment[0]->is_ready){?>
  	<span class="FL clearfix MT40">&nbsp;&nbsp;&nbsp;<a class="button" title="" href="<?=SITEPATH?>spice-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=xls">Generate .xls File</a></span>  
	<?php }?>
  <?php }?>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'spice-deployment?action=add&id='.(int)$_GET['id'].'&do=song" title="Add New" class="button">Add New Song</a>'; } ?>
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
	?>
	<div class="bloc" style="width: 250%;" id="bloc_<?=$showData->id?>">
	<div class="content">
        <div class="clearfix">
		  <div class="input FL PR5">
			<label for="input">ISRC :</label>
            <input type="text" id="isrc" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150"/>
		  </div>
          <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150" />
          </div>
		  <div class="input FL PR5">
            <label for="input">Song Title :</label>
            <input type="text" id="songTitle" name="songTitle[<?=$showData->id?>]" value="<?php echo $showData->title; ?>" class="WD150" />
          </div>
		  <div class="input FL PR5">
			<label for="input">Album Title :</label>
            <input type="text" id="album" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Artist :</label>
            <input type="text" id="singer" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Music Director :</label>
            <input type="text" id="musicDirector" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Filmstar :</label>
            <input type="text" id="starcast" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Director :</label>
            <input type="text" id="keyDirector" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Release Year</label>
            <input type="text" id="releaseYear" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->release_year; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Label :</label>
            <input type="text" id="label" name="label[<?=$showData->id?>]" value="<?php echo $providerDetails['label']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" id="genre" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR5">
			<a class="button" title="Rmove this song from deployment" onclick="removeSongFromImi({'id':'<?=$showData->id?>','afile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']?>','xfile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$showData->isrc?>.xml'})" href="javascript:void(0);">Remove This Song</a>
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