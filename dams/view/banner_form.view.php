<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Banner</h1>
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
    <div class="title"><?=ucfirst($_GET['action'])?> Banner</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Banner Name <span class='mandatory'>*</span></label>
            <input type="text" id="bannerName" name="bannerName" value="<?=$aContent['bannerName']?>" />
        </div>
        		
        <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/banner?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>