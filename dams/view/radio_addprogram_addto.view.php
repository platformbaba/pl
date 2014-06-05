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
		if( !empty($aSuccess) || ( isset($_GET['msg']) && $_GET['msg'] != '') ){
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ $aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
<div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:818px;">
    <div class="title">
        Channel Name ( <?=ucfirst($_GET['chName']);?> )
    </div>

	<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>radio_bulk?action=add&id=<?=$_GET['id']?>&isPlane=1&chName=<?=urlencode($_GET['chName'])?>" class="button" title="Add Program">Bulk Upload</a>
		<!--<a href="<?=SITEPATH?>radio_addprogram?action=add&id=<?=$_GET['id']?>&isPlane=1&chName=<?=urlencode($_GET['chName'])?>" class="button" title="Add Program">Add Program</a>-->
	</div>
    <div class="content">
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th>P ID</th>
                    <th>Program Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Duration</th>
                    <th>Insert Date</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

				if( !empty($aContent) ){
				
				$program_arr = array();
				foreach( $pData as $showData){
					$program_arr[$showData->program_id]  = $showData->program_name;
				}


					foreach( $aContent as $showData){
				?>
				<tr>
					
					<td><?=$showData->program_id;?></td>
					<td><?=$program_arr[$showData->program_id];?></td>
					<td><?=$showData->start_date;?></td>
					<td><?=$showData->end_date;?></td>
					<td><?=$showData->start_time;?></td>
					<td><?=$showData->end_time;?></td>
					<td><?=$showData->duration;?></td>
					<td><?=$showData->insert_date ?></td>
					<td><a href="<?=SITEPATH?>radio_addprogram?action=edit&id=<?=$_GET['id']?>&eid=<?=$showData->program_id?>&isPlane=1&chName=<?=urlencode(strtolower($program_arr[$showData->program_id]));?>" title="Edit Channel Program"><img src="<?=IMGPATH?>icons/edit.png" alt="Edit Channel Program"  /></a>
					<a href="<?=SITEPATH?>radio_addprogram?action=add&id=<?=$_GET['id']?>&eid=<?=$showData->program_id?>&isPlane=1&do=draft&chName=<?=urlencode(strtolower($program_arr[$showData->program_id]));?>" title="Delete Channel Program" onclick="return confirm('Are you shure to delete program?')"><img src="<?=IMGPATH?>icons/draft.gif" alt="Delete Channel Program"  /></a></td>
                </tr>
				<?php
					} /* foreach end */
				}else{ 
				 ?>
				
				<td colspan="9" align="center">No Program</td>
				<?php 
				}
				?>
			</tbody>
        </table>
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>
    </div>
</div>
</div>
<!--  CONTENT End -->