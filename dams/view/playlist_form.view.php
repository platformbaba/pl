<!-- CONTENT -->
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
?>
  <div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Playlist</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
		<div class="clearfix">
        <div class="input">
          <label for="input1">Playlist Name <span class='mandatory'>*</span></label>
          <input type="text" id="playlistName" name="playlistName" value="<?=$aContent['playlistName']?>" />
        </div>
        </div> 
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>playlist?action=add&song_id=<?php echo $_GET['song_id']; ?>&isPlane=1&do=addto&song_name=<?php echo urlencode($_GET['song_name']); ?>&ctype=<?=$_GET['ctype']?>' " /> 
        </div>
      </form>
    </div>
  </div>
</div>