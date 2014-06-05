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
		<span>Image Edits</span>
	<a class="toggle" href="#"></a></div>
	<?php
		if( $this->user->hasPrivilege("image-edits_edit") && $this->user->hasPrivilege("image-edits_add") ){
	?>
	<a class="button FR" href="<?=SITEPATH?>image-edits?action=edit&isPlane=1&image_name=<?=$_GET['image_name']?>&id=<?=$_GET['id']?>" style="margin-top: -30px; margin-right: 30px;">Add More Image Edits</a>
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
					foreach( $aContent as $kk=>$vv ){
				?>
				<tr>
					<td class='ML10'><?php echo $aEditConfig[$vv->config_id]['str']; ?></td>
					<td><?php echo $vv->insert_date; ?></td>
					<td>
						<?php 
						if($vv->path){ ?>
							<a class="zoombox" href="<?php echo TOOLS::getImageEditsPath($vv->path); ?>?<?=date('His')?>"><img alt="image" src="<?php echo TOOLS::getImageEditsPath($vv->path); ?>?<?=date('His')?>" style="max-height:75px; max-width:75px;"></a>
						<?php }?>
					</td>
				</tr>
				<?php } }else { ?>
					<tr><td colspan='3'>No Contents.</td></tr>
                <?php } ?>
			</tbody>
        </table>
	
    </div>
</div>
</div>
<!--  CONTENT End --> 