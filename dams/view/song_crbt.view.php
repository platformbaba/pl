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
		<span><?=$aSongName?> CRBT</span>
	<a class="toggle" href="#"></a></div>
	<?php
		if( $this->user->hasPrivilege("song-edits_edit") && $this->user->hasPrivilege("song-edits_add") ){
	?>
	<a class="button FR" href="javascript:void(0)" onclick="window.history.back();" style="margin-top: -30px; margin-right: 30px;">back</a>
	<?php
		}
	?>
	<div class="content">
		<form method="post">
		<table>
            <thead>
                <tr>
					<th>File</th>
					<?php
						unset($aField[0]);unset($aField[1]);
						foreach($aField as $kk=>$vv ){
							echo "<th>".ucfirst($vv->Field)."</th>";
						}
					?>
                </tr>
            </thead>
            <tbody>
				<tr>
					<td>
						<audio id="audiox3_55" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aPath; ?>" controls="controls">
							<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aPath; ?>" type="audio/wav">
							<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$aPath; ?>" height="50">
								<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$aPath; ?>" height="50">
									Sorry, your browser does not support.
								</embed>	
							</object>
						</audio>
					</td>
					<?php
						foreach($aField as $kk=>$vv ){
							$field=$vv->Field;?>
							<td><input type="text" name="<?=$field?>" id="<?=$field?>" value="<?=$aContent[0]->$field?>" /></td>
							<?php
						}
					?>	
				</tr>
				<tr>
				<td colspan="10">
					<div class="submit">
					<?php
					if( $this->user->hasPrivilege("crbt_edit") || $this->user->hasPrivilege("crbt_add") ){
					?>
					<input type="submit" value="Submit" name="submitBtn"/>
					<?php } ?>
					</div>
				</td>
				</tr>	
			</tbody>
        </table>
		</form>
    </div>
</div>
</div>
<!--  CONTENT End --> 