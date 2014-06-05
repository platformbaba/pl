<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/radiostationnew.jpg" alt=""  height="45px" width="45px" />Radio Program</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'radioprogram?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<br class='clear' />
	</div>
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
//print_r($aContent);		
	$chName_arr = array();
					foreach($chData as $cData ){						
							$chName_arr[$cData->station_id] = $cData->name;
						}
	?>

	
<!-- Search Box start -->
<div class="bloc">
    <div class="title">
        Search Filters:
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='GET'>
		<div class="clearfix">
			<div class="input FL50">
				<label for="input">Radio Program Name:</label>
				<input type="text" id="radioProgram" name="radioProgram" value="<?php echo $aSearch['radioProgram']; ?>" />
			</div>
			
		</div>
		<div class="submit" align='right'>
			<input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
		</div>
		
		<div class="cb"></div>
		</form>
    </div>
</div>
<!-- Search Box end -->	
<div class="bloc">
    <div class="title">
        Radio Program Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>P Id</th>
                    <th>Program</th>
					<th>Channel</th>
					<th>Duration</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Insert Date</th>
					<th>View/Add Song</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
	
				
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
					
				?>
				<tr>
					<td>
					<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->program_id, 'status'=>$showData->status, 'model'=>'radioprogram' ) ); ?>				
					</td>
					<td><?=$showData->program_id; ?></td>
					<td>
					<a href="<?=SITEPATH?>radioprogram?action=view&id=<?=$showData->program_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Radio Program Details"><?=$showData->program_name; ?></a>
					</td>
					<td><?=$chName_arr[$showData->channel_id];
					 ?></td>
					<td>
					<?=$showData->duration;?>
					</td>
					<td>
					<?=$showData->start_date;?>
					</td>					
					<td>
					<?=$showData->end_date;?>
					</td>					
					<td>
					<?=$showData->start_time;?>
					</td>					
					<td>
					<?=$showData->end_time;?>
					</td>					

					<td>
					<?=$showData->insert_date;?>
					</td>					
 					<td>
					<a href="<?=SITEPATH?>radio_addprogramsong?action=add&id=<?=$showData->program_id?>&isPlane=1&do=addto&pName=<?=urlencode(strtolower($showData->program_name));?>" class="fancybox fancybox.iframe" title="Add / View Program Song"><img src="<?=IMGPATH?>icons/playlist-add.png" alt="Add / View Program Song"  /></a>
					</td>					
                     <td class="actions" style=" width:100px">						
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->program_id, 'status'=>$showData->status, 'model'=>'radioprogram' ) );?>						
					</td>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=12>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->program_id, 'status'=>$showData->status, 'model'=>'radioprogram', 'flow'=>'legal' ) ); ?>
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>

<form id='actionFrm' name='actionFrm' method="POST">
<input type="hidden" id="contentId" name="contentId" value="">
<input type="hidden" id="contentAction" name="contentAction" value="">
<input type="hidden" id="contentModel" name="contentModel" value="">
</form>

</div>
<!--            
    CONTENT End 
			--> 