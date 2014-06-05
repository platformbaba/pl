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
<div class="bloc" style="margin-top:0px;">
    <div class='title'>
		<span>Song Edits</span>
	<a class="toggle" href="#"></a></div>
	<?php
		if( $this->user->hasPrivilege("song-edits_edit") && $this->user->hasPrivilege("song-edits_add") ){
	?>
	<a class="button FR" href="<?=SITEPATH?>song-edits?action=edit&isPlane=1&song_name=<?=$_GET['song_name']?>&id=<?=$_GET['id']?>&isrc=<?=$_GET['isrc']?>" style="margin-top: -30px; margin-right: 30px;">Add More Song Edits</a>
	<?php
		}
	?>
	<div class="content">
		<table>
            <thead>
                <tr>
					<th>Edit Config</th>
					<th>Edit Date</th>
					<th>File</th>
					<th>CRBT</th>
                </tr>
            </thead>
            <tbody>
				<?php if( !empty($aContent) ){ 
					foreach( $aContent as $kk=>$vv ){
				?>
				<tr>
					<td class='ML10'><?php echo $aEditConfig[$vv->config_id]['str']; ?></td>
					<td><?php echo $vv->insert_date; ?></td>
					<td>
						<audio id="audiox3_55" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$vv->path; ?>" controls="controls">
							<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$vv->path; ?>" type="audio/wav">
							<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$vv->path; ?>" height="50">
								<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$vv->path; ?>" height="50">
									Sorry, your browser does not support.
							</object>
						</audio>
					</td>
					<td>
						<?php if($this->user->hasPrivilege("crbt_edit") || $this->user->hasPrivilege("crbt_add") || $this->user->hasPrivilege("crbt_view")){?>	
						<a href="<?=SITEPATH?>song?action=view&do=crbt&id=<?=$_GET['id']?>&song_name=<?=$_GET['song_name']?>&isPlane=1&config_id=<?=$vv->id?>&path=<?=$vv->path?>" title="Click to view CRBT codes" class="button">CRBT</a>
						<?php }?>
					</td>
				</tr>
				<?php } }else { ?>
					<tr><td colspan='4'>No Contents.</td></tr>
                <?php } ?>
			</tbody>
        </table>
	
    </div>
</div>
</div>
<!--  CONTENT End --> 