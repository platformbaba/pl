<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#artistFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<script type="text/javascript">
		//tinymce.PluginManager.load('moxiemanager', '<?php echo JSPATH; ?>tinymce/plugins/moxiemanager/plugin.min.js');
		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"//moxiemanager
			],
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link "
		});
</script>
<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Artist</h1>
<?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
?>
<div class="bloc">
    <div class="title"><?=ucfirst($_GET['action'])?> Artist</div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" id="artistFrm" name="artistFrm">
        <div class="input">
            <label for="input1">Artist Name <span class='mandatory'>*</span></label>
            <input type="text" id="artistName" name="artistName" value="<?=$aContent['artistName']?>" class="validate[required]"/>
        </div>
        <div class="input">
            <label for="select">Artist Type <span class='mandatory'>*</span></label>
            
			<select name="role[]" id="role" multiple="multiple" size="5" class="validate[required]">
                <?php
					foreach($aConfig['artist_type'] as $kR=>$vR){
						$selStr = (in_array($vR,$aContent['role']))?"selected='selected'":"";
						echo '<option value="'.$vR.'" '.$selStr.' >'.ucwords($kR).'</option>';
					}
				?>
            </select>
        </div>
		<div class="input">
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=13&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
        </div>
		<div class="input textarea">
            <label for="textarea2">Biography</label>
            <textarea name="content" id="textarea2" rows="7" cols="4"><?=$data['aContent']['content']?></textarea>
        </div>
		<div class="clearfix">
			<div class="input FL50">
				<label for="input4">Born On</label>
				<input type="text" name="dob" class="datepicker" id="input4" value="<?=str_replace("00:00:00","",$data['aContent']['dob'])?>"/>
			</div>
			<div class="input FL50">
				<label for="input5">Died On</label>
				<input type="text" name="dod" class="datepicker" id="input5" value="<?=str_replace("00:00:00","",$data['aContent']['dod'])?>"/>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
				<label for="select">Gender</label>
				<select name="gender" id="select">
					<?php
						foreach($aConfig['gender'] as $kG=>$vG){
							$selStr = ($aContent['gender']==$kG)?"selected='selected'":"";
							echo '<option value="'.$kG.'" '.$selStr.' >'.ucwords($vG).'</option>';
						}
					?>
				</select>
			</div>
			<div class="input">
            	<label for="input1">Alias</label>
            	<input type="text" id="alias" name="alias" value="<?=$data['aContent']['alias']?>" />
        	</div>
		</div>
		<div class="submit">
            <input type="submit" value="Submit" name="submitBtn" />
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/artist?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>