<!--            
    CONTENT 
			--> 
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
		if( !empty($aSuccess) ){
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
	
<div class="bloc" style="margin-top:0px;">
	<?php
		$params = array(
							'cType'=>$cType,
							'relatedCType'=>$relatedCType,
							'id'=>$id,
							'tab'=>'logs'
						);
		echo TOOLS::displayViewTabsHtml( $params );
	?>
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