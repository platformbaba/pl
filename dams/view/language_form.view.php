<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Language</h1>
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
    <div class="title">Add Language</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Language Name <span class='mandatory'>*</span></label> 
            <input type="text" id="languageName" name="languageName" value="<?=$aContent['languageName']?>" />
        </div>
        		
        <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/language?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>