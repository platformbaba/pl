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
	<div id="sm2-container">
	 <!-- flash movie is added here -->
	</div>
    <div class='title'>
		<span><?=$_GET['image_name']?> Image Edits</span>
	<a class="toggle" href="#"></a></div><a class="button FR" href="<?=SITEPATH?>image?action=view&do=showedits&id=<?=$_GET['id']?>&image_name=<?=$_GET['image_name']?>&isPlane=1" style="margin-top: -30px; margin-right: 30px;">All Image Edits</a>
	
	<div class="content">
	<form id='srcFrm' name='srcFrm' enctype="multipart/form-data" method="post">
		<table>
            <thead>
                <tr>
					<th>Sr. No.</th>
					<!--<th>Song Edits Config</th>-->
					<th></th>
					<th>Format</th>
					<th>Dimension</th>
					<th>File Size (kb)</th>
					<th>Upload</th>
                </tr>
            </thead>
            <tbody>
				<?php if( !empty($aEditConfig) ){ 
					$i=1;
					foreach( $aEditConfig as $kk=>$vv ){
				?>
				<tr>
					<td width="1%" valign="middle" >
						&nbsp;<?php 
						echo $i;
						?>
					</td>
					<td width="1%">
						<?php 
						if($aContent[$kk]->path){ ?>
							<a class="zoombox" href="<?php echo TOOLS::getImageEditsPath($aContent[$kk]->path); ?>?<?=date('His')?>"><img alt="image" src="<?php echo TOOLS::getImageEditsPath($aContent[$kk]->path); ?>?<?=date('His')?>" style="max-height:75px; max-width:75px;"></a>
						<?php }?>
					</td>
					<!--<td ><?php echo $vv['str']; ?></td>-->
					<td>&nbsp;<?php echo $vv['data']->format; ?></th>
					<td><?php echo $vv['data']->dimension; ?></td>
					<td><?php echo $vv['data']->file_size; ?></td>
					<input type="hidden" value="<?=$kk?>" name="config_id" />
					<td>
						<input type="file" name="file[<?=$kk?>]" />
						<input type="hidden" name="hidden_file[<?=$kk?>]" value="" />	
					</td>
				</tr>
				<?php
					$i++; 
					} 
				}else { ?>
					<tr><td colspan='3'>No Contents.</td></tr>
                <?php } ?>
			</tbody>
        </table>
		<br/>
		<div class="submit" align='right'>
			<input type="hidden" name="image_id" value="<?=$_GET['id']?>" />
			<input type="hidden" name="image_name" value="<?=$_GET['image_name']?>" />
			<input type="submit" value="submit" name="submitBtn" style='margin:0 auto' />
		</div>	
	</form>
    </div>
</div>
</div>
<!--  CONTENT End --> 