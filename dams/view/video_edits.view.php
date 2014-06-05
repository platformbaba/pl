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
		<span>Video Edits</span>
	<a class="toggle" href="#"></a></div>
	<?php
		if( $this->user->hasPrivilege("video-edits_edit") && $this->user->hasPrivilege("video-edits_add") ){
	?>
	<a class="button FR" href="<?=SITEPATH?>video-edits?action=edit&isPlane=1&video_name=<?=$_GET['video_name']?>&id=<?=$_GET['id']?>" style="margin-top: -30px; margin-right: 30px;">Add More Video Edits</a>
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
                </tr>
            </thead>
            <tbody>
				<?php if( !empty($aContent) ){ 
					$i=1;
					foreach( $aContent as $kk=>$vv ){
				?>
				<tr>
					<td class='ML10'><?=$i?>.&nbsp;<?php echo $aEditConfig[$vv->config_id]['str']; ?></td>
					<td><?php echo $vv->insert_date; ?></td>
					<td>
						<?php 
						if($vv->path){ ?>
							<a class="zoombox" href="<?php echo TOOLS::getVideoEditsPath($vv->path); ?>?<?=date('His')?>">VIEW</a>
						<?php }?>
					</td>
				</tr>
				<?php $i++;
				} }else { ?>
					<tr><td colspan='3'>No Contents.</td></tr>
                <?php } ?>
			</tbody>
        </table>
	
    </div>
</div>
</div>
<!--  CONTENT End --> 