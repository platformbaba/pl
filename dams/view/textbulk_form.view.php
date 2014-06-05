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
<!--            
    CONTENT 
			-->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/song_icon.png" alt="" width='40' height='40'/>Manage Text Bulk Upload</h1>
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
  <div class="bloc">
    <div class="title"> Upload bulk text .csv file <a class="toggle" href="#"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='POST' enctype="multipart/form-data">
        <div class="clearfix">
          <div class="input FL50">
            <label for="input">Upload File</label>
            <input type="file" id="csv" name="csv" value="" class="validate[required]"/>
          </div>
		  <div class="input FL50">
            <label for="input">Download Sample .csv File</label>
            <a href="javascript:top.location='<?=MEDIA_SITEPATH_TEMP?>bulk/text_bulk.csv';" class="button">Download</a>
          </div>
        </div>
        <div class="submit" align='right'>
          <input type="submit" value="Submit" name="submitBtn" style='margin:0 auto' />
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/textbulk?action=view' " /> 
        </div>
        <div class="cb"></div>
      </form>
    </div>
  </div>
</div>
<!--            
    CONTENT End 
			-->
