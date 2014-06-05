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

<!--            
    CONTENT 
			--> 
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

<div class="bloc"  style="margin-top:0px;">
<div class="title">Manage Song Lyrics:</div>
<div class="content">
	<form method="post" target="_top">
        <input type='hidden' name='id' id='id' value="<?php echo (int)$_REQUEST['id']?>" />
		<div class="input">
            <label for="songLyrics">Song Lyrics : <?php echo urldecode(strip_tags(trim($_GET['song_name'])))?></label>
            <textarea id="songLyrics" name="songLyrics" rows="15" cols="4"><?=$aContent['songLyrics']?></textarea>
		</div>
		
		<div class="submit">
            <?php
			if( $this->user->hasPrivilege("song_edit") ){
			?>
			<input type="submit" value="Submit" name="submitBtn" class="black"/>
			<input type="hidden" name="refferer" value="<?=$_SERVER["HTTP_REFERER"]?>" />
			<?php } ?>
        </div>
	</form>
</div>	
</div>

</div>
<!--            
    CONTENT End 
			--> 