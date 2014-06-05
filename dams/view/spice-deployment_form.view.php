<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="SPICE" />SPICE Deployment</h1>
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
      <form method="post" enctype="multipart/form-data">
        <div class="input">
          <label for="input1">Deployment Name <span class='mandatory'>*</span></label>
          <input type="text" id="deploymentName" name="deploymentName" value="<?=$aContent['deploymentName']?>" />
        </div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/spice-deployment?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>
