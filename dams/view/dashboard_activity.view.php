<!--            
    CONTENT 
			--> 
<div id="content">
	<h1><img src="<?php echo IMGPATH; ?>icons/dashboard.png" alt="" />CMS Activity</h1>
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
		if( !empty($aSuccess) ){
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
<div class="bloc">
    <div class="title">
        Search Filters:
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='GET'>
		<div class="clearfix">
			<div class="input FL PR30">
				<label for="input">Users:</label>
				<select name="srcUser" id="srcUser" >
					<option value="">Select</option>
					<?php
						foreach( $aEditors as $k=>$edt ){
							$check = ($_GET['srcUser']==$edt->id ? 'selected':'');
							echo '<option value="'.$edt->id.'" '.$check.'>'.$edt->name.'</option>';
						} 
					?>
				</select>
			</div>
			<div class="input FL PR30">
				<label for="input">Activity:</label>
				<select name="srcActivity" id="srcActivity" >
					<option value="">Select</option>
					<?php
						foreach( $aActivity as $k=>$act ){
							$check = ($_GET['srcActivity']==$act ? 'selected':'');
							echo '<option value="'.$act.'" '.$check.'>'.$act.'</option>';
						} 
					?>
				</select>
			</div>
			<div class="input FL PR30">
				<label for="input">Sections:</label>
				<select name="srcSction" id="srcSction" >
					<option value="">Select</option>
					<?php
						foreach( $aSections as $k=>$sec ){
							$check = ($_GET['srcSction']==$k ? 'selected':'');
							echo '<option value="'.$k.'" '.$check.'>'.ucfirst($sec).'</option>';
						} 
					?>
				</select>
			</div>
			<div class="input FL PR30">
				<label for="input">Start Date :</label>
				<input type="text" id="srcSrtDate" name="srcSrtDate" value="<?php echo $_GET['srcSrtDate']; ?>" class="datepicker" />
			</div>
			<div class="input FL PR30">
				<label for="input">End Date :</label>
				<input type="text" id="srcEndDate" name="srcEndDate" value="<?php echo $_GET['srcEndDate']; ?>" class="datepicker"/>
			</div>

		</div>
		<div class="submit" align='right'>
			<input type="hidden" value="activity" name="do" />
			<input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
		</div>
		
		<div class="cb"></div>
		</form>
    </div>
</div>	
<div class="bloc">
    <div class="title">
        Activity Lists
    </div>
    <div class="content">
			
		<table>
            <thead>
                <tr>
					<th>Activity</th>
                    <th>Section</th>
                    <th width='375px'>Remarks</th>
                    <th>User</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					
					foreach( $aContent as $showData){
						$sEditorName = ( !empty($aEditors[$showData->editor_id]->name)? $aEditors[$showData->editor_id]->name : 'NA' );
				?>
				<tr class='dashboard_<?php echo $showData->action; ?>' >
					<td><?php echo ucfirst($showData->action); ?></td>
					<td><?php echo ucfirst($showData->module); ?></td>
					<td width='375px'><?php echo wordwrap($showData->remark, 20); ?></td>
					<td><?php echo $sEditorName; ?></td>
					<td><?php echo date('Y-m-d H:i', strtotime($showData->activity_date)); ?></td>
                </tr>
				<?php
						} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=5>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
			

		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>

</div>
<!--            
    CONTENT End 
			--> 