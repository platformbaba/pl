<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#nokiaFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Song" />NOKIA Deployment</h1>
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
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Deployment</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" name="nokiaFrm" id="nokiaFrm" >
        <div class="input">
          <label for="input1">Deployment Name <span class='mandatory'>*</span></label>
          <input type="text" id="deploymentName" name="deploymentName" value="<?=$aContent['deploymentName']?>" class="validate[required]" />
        </div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/nokia-deployment?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>