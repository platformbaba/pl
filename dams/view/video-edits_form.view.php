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
		<span><?=$_GET['video_name']?> Video Edits</span>
	<a class="toggle" href="#"></a></div><a class="button FR" href="<?=SITEPATH?>video?action=view&do=showedits&id=<?=$_GET['id']?>&video_name=<?=$_GET['video_name']?>&isPlane=1" style="margin-top: -30px; margin-right: 30px;">All Video Edits</a>
	
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
					<th>Frame Rate</th>
					<th>Video Codec</th>
					<th>Video Bitrate</th>
					<th>Audio Codec</th>
					<th>Audio Bitrate</th>
					<th>Sample Rate</th>
					<th>File Size Limit</th>
					<th>Duration</th>
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
							<a class="zoombox" href="<?php echo TOOLS::getVideoEditsPath($aContent[$kk]->path); ?>?<?=date('His')?>">VIEW</a>
						<?php }?>
					</td>
					<!--<td ><?php echo $vv['str']; ?></td>-->
					<td>&nbsp;<?php echo $vv['data']->format; ?></th>
					<td><?php echo $vv['data']->dimension; ?></td>
					<td><?php echo $vv['data']->frame_rate; ?></td>
					<td><?php echo $vv['data']->video_codec; ?></td>
					<td><?php echo $vv['data']->video_bitrate; ?></td>
					<td><?php echo $vv['data']->audio_codec; ?></td>
					<td><?php echo $vv['data']->audio_bitrate; ?></td>
					<td><?php echo $vv['data']->sample_rate; ?></td>
					<td><?php echo $vv['data']->file_size_limit; ?></td>
					<td><?php echo $vv['data']->duration; ?></td>
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
			<input type="hidden" name="video_id" value="<?=$_GET['id']?>" />
			<input type="hidden" name="video_name" value="<?=$_GET['video_name']?>" />
			<input type="submit" value="submit" name="submitBtn" style='margin:0 auto' />
		</div>	
	</form>
    </div>
</div>
</div>
<!--  CONTENT End --> 