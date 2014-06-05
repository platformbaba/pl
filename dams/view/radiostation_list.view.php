<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/radiosnew.jpg" alt=""  height="45px" width="45px" />Radio Station</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'radiostation?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
				<label for="input">Radio Channel Name:</label>
				<input type="text" id="srcRstation" name="srcRstation" value="<?php echo $aSearch['srcRstation']; ?>" />
			</div>
			<div class="input FR50">
				<label for="input">Radio Channel Type:</label>
				<select name="srcSType" id="srcSType" >
					<option value="">Select</option>
					<?php
						foreach( $aConfig['stationType'] as $kStation=>$vStation){
							$check = ($aSearch['srcSType']==$kStation ? 'selected':'');
							echo '<option value="'.$kStation.'" '.$check.'>'.$vStation.'</option>';
						} 
					?>
				</select>
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
        Radio Channel Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Radio Channel Name</th>
					<th>Type</th>
					<th>Language</th>
					<th>Insert Date</th>
					<th>View Program</th>
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
					<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->station_id, 'status'=>$showData->status, 'model'=>'radiostation' ) ); ?>				
					</td>
					<td><?=$showData->station_id; ?></td>
					<td>
					<a href="<?=SITEPATH?>radiostation?action=view&id=<?=$showData->station_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Radio Station Details"><?php echo $showData->name; ?></a>
					</td>
					<td>
					<?=$legal = ($showData->type=='A') ? 'Artist station' : 'Standard station' ; ?>
					</td>
					<td>
					<?php
						foreach($languageList as $kL=>$vL){
							if($showData->language_id==$vL->language_id){
								echo ucwords($vL->language_name);	
								break;
							}
							
						}				
					?>
					</td>
					<td>
					<?=$showData->insert_date;?>
					</td>
					<td>
					<a href="<?=SITEPATH?>radio_addprogram?action=add&id=<?=$showData->station_id?>&isPlane=1&do=addto&chName=<?=urlencode(strtolower($showData->name));?>" class="fancybox fancybox.iframe" title="Add / View Channel Program"><img src="<?=IMGPATH?>icons/playlist-add.png" alt="Add / View Channel Program"  /></a>
					</td>					
                    <td class="actions" style=" width:100px">
						
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->station_id, 'status'=>$showData->status, 'model'=>'radiostation' ) );?>						
					</td>
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
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->station_id, 'status'=>$showData->status, 'model'=>'radiostation', 'flow'=>'legal' ) ); ?>
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