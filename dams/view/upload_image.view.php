<!--  CONTENT -->
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
  <div class="bloc" style="margin-top:0px;">
    <div class="title"> Upload Image: <a class="toggle" href="#"></a> </div><a class="button FR" href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=<?=$_GET['cType']?>&cId=<?=$_GET['cId']?>&place=oPic&do=suggest" style="margin-top: -30px; margin-right: 30px;">Select Existing Images</a>
	<span style="clear:both" ></span>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='POST' enctype="multipart/form-data">
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Image Title: <span class='mandatory'>*</span></label>
            <input type="test" id="srcTitle" name="srcTitle" value="<?php echo $aContent['srcTitle']; ?>" />
          </div>
		  <div class="input FL PR30">
            <label for="input">Image Upload: <span class='mandatory'>*</span></label>
            <input type="file" id="srcImage" name="srcImage" value="<?php echo $aContent['srcImage']; ?>" />
			<input type="hidden" id="cType" name="cType" value="<?=$_GET['cType']?>" />
			<input type="hidden" id="cId" name="cId" value="<?=$_GET['cId']?>"  />
          </div>
        </div>
		<div class="clearfix">
			<div class="input">
				<label for="textarea2">Image Description</label>
	            <textarea name="srcDesc" id="textarea2" rows="7" cols="4"><?=$aContent['srcDesc']?></textarea>
			</div>
		</div>
        <div class="submit" align='right'>
          <input type="submit" value="Submit" name="submitBtn" style='margin:0 auto' />
        </div>
        <div class="cb"></div>
      </form>
    </div>
  </div>
  <!-- Search Box end -->
</div>
<!-- CONTENT End -->
