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
		<span><?=$_GET['song_name']?> Song Edits</span>
	<a class="toggle" href="#"></a></div><a class="button FR" href="<?=SITEPATH?>song?action=view&do=showedits&id=<?=$_GET['id']?>&song_name=<?=$_GET['song_name']?>&isPlane=1&isrc=<?=$_GET['isrc']?>" style="margin-top: -30px; margin-right: 30px;">All Song Edits</a>
	
	<div class="content">
	<form id='srcFrm' name='srcFrm' enctype="multipart/form-data" method="post">
		<table>
            <thead>
                <tr>
					<th>Sr. No.</th>
					<!--<th>Song Edits Config</th>-->
					<th></th>
					<th>Format</th>
					<th>Sample Size<br/>(bit)</th>
					<th>Audio Bitrate<br/>(kbps)</th>
					<th>Sample Rate<br/>(hz)</th>
					<th>Audio Channel</th>
					<th>Codec</th>
					<th>Duration<br/>(sec)</th>
					<th>Known As</th>
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
						<audio id="audiox3_<?=$kk?>" style="width: 90px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aContent[$kk]->path; ?>?<?=date('His')?>" controls="controls">
							<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aContent[$kk]->path; ?>?<?=date('His')?>">
							<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$aContent[$kk]->path; ?>?<?=date('His')?>" height="50">
								<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aContent[$kk]->path; ?>?<?=date('His')?>" height="50">
									Sorry, your browser does not support.
								</embed>	
							</object>
						</audio>
						<?php }?>
					</td>
					<!--<td ><?php echo $vv['str']; ?></td>-->
					<td>&nbsp;<?php echo $vv['data']->format; ?></th>
					<td><?php echo $vv['data']->sample_size; ?></td>
					<td><?php echo $vv['data']->audio_bitrate; ?></td>
					<td><?php echo $vv['data']->sample_rate; ?></td>
					<td><?php echo $vv['data']->audio_channel; ?></td>
					<td><?php echo $vv['data']->codec; ?></td>
					<td><?php echo $vv['data']->duration_limit; ?></td>
					<td><?php echo $vv['data']->known_as; ?></td>
					<input type="hidden" value="<?=$kk?>" name="config_id" />
					<td>
						<input type="file" name="file[<?=$kk?>]" />
						<input type="hidden" name="hidden_file[<?=$kk?>]" value="<?=$providerDetails['0808m']?>" />	
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
			<input type="hidden" name="song_id" value="<?=$_GET['id']?>" />
			<input type="hidden" name="isrc" value="<?=$_GET['isrc']?>" />
			<input type="submit" value="submit" name="submitBtn" style='margin:0 auto' />
		</div>	
	</form>
    </div>
</div>
</div>
<!--  CONTENT End --> 