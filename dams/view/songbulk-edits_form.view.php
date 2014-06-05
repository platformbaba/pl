<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="song" />Songs Bulk Edits Uploads</h1>
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
  <div class="bloc">
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      song</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="songFrm" name="songFrm">
		<div class="clearfix">
		  <div class="input FL50">
            <label for="input4">ISRC : </label>
			<textarea rows="15" cols="" id="isrcs" name="isrcs" style="width: 196%;"><?=$aContent?></textarea>
			(put song isrc comma seperated)
          </div>
        </div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <!--<input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>songbulk-edits?action=view' " /> -->
        </div>
      </form>
    </div>
  </div>
</div>