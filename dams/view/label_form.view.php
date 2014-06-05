<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Label</h1>
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
    <div class="title"><?=ucfirst($_GET['action'])?> Label</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Label Name <span class='mandatory'>*</span></label>
            <input type="text" id="labelName" name="labelName" value="<?=$aContent['labelName']?>" />
        </div>
        
		<div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/label?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>