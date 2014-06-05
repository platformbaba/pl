<!--            
    CONTENT 
			--> 
<div id="content">
	<h1><img src="<?php echo IMGPATH; ?>icons/eUser.png" alt=""  height="45px" width="45px" />Manage Roles Permissions for <?=ucwords($data['roleName'])?></h1>
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
<div class="bloc">
    <div class="title">
        Role Permissions Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
		            <th><input type="checkbox" class="checkall"/> Module</th>
					<th>Permission</th>
					<!-- th>Permission</th -->
					<th>Permission</th>
		            <th>Permission</th>
		            <th>Permission</th>
					<th>Permission</th>
					<th>Permission</th>
                </tr>
            </thead>
            <tbody>
                <?php #print_r($aContent);exit;
					ksort($aContent);
					if( !empty($aContent) ){
						$i=1;
						foreach( $aContent as $kData=>$showData){
							if( !in_array($kData, array('audiotools', 'videotools')) ){
				?>
					<tr>
						<td style="color:#151515;font-size:1.1em"><b><?php echo ucwords($kData); ?></b></td>
						<?php
							$p=0;
							foreach($showData as $kPID=>$vPID){
								$disString = ucfirst(str_replace($kData."_","",$vPID));
								if( $disString != 'Delete' ){
						?>	
						<td><input type="checkbox" <?=($aPermissions->permissions[$vPID])?'checked="checked"':''?> value="<?php echo $kPID; ?>" name="select_ids[]" /><?php echo $disString; ?></td>
						<?php
								$p++;
								}
							}
							if($p!=7){
								for($k=1;$k<=(int)6-$p;$k++){
									?><td></td><?php
								}
							}
						?>
					</tr>
						<?php
						$i++;
							}
						} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=4>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
				<tr>
					<td colspan="2">
						<div class="submit">
							<input type="submit" value="Submit" class="black"/>
						</div>
					</td>
				</tr>
			</tbody>
        </table>
		</form>
    </div>
</div>
</div>
<!--            
    CONTENT End 
			--> 