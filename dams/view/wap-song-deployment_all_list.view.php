<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage WAP Song Deployment</h1></span>
		<span class='FR MT40'>
			  		<?php echo '<a href="'.SITEPATH.'report-deployment?srcDepType=WAPSONG&action=view" title="Deployment Audit Report" class="button">Report</a>'; ?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'wap-song-deployment?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
				<label for="input">Deployment Name:</label>
				<input type="text" id="srcDeployment" name="srcDeployment" value="<?php echo $aSearch['srcDeployment']; ?>" />
			</div>
			<div class="input FR50">
				<label for="input">Content Status:</label>
				<select name="srcCType" id="srcCType" >
					<option value="">Select</option>
					<?php
						$actionArr = TOOLS::getContentActionTypes( array('type'=>'form') );
						foreach( $actionArr as $k=>$act ){
							$check = ($aSearch['srcCType']==$act ? 'selected':'');
							echo '<option value="'.$act.'" '.$check.'>'.$act.'</option>';
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
        Deployment Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Name</th>
					<th>Insert Date</th>
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
						<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->deployment_id, 'status'=>$showData->status, 'model'=>'deployment' ) ); ?>	
					</td>
					<td><?php echo $showData->deployment_id; ?></td>
					<td><a href="<?=SITEPATH?>wap-song-deployment?action=view&id=<?=$showData->deployment_id?>&do=details&isPlane=1" title="view deployment details" class="fancybox fancybox.iframe"><?php echo $showData->deployment_name; ?></a></td>
					<td><?php echo $showData->insert_date; ?></td>
                    <td class="actions">
						<?php
						if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){
						
							if( $showData->status == 1 ){
								echo $retStr = '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$showData->deployment_id.', "model":"deployment", "action":"draft"})\' title="UnPublish this content"><img src="'.IMGPATH.'icons/publish.gif" alt="" /></a>';
							
							}else{
								echo $retStr = '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$showData->deployment_id.', "model":"deployment", "action":"publish"})\' title="Publish this content"><img src="'.IMGPATH.'icons/draft.gif" alt="" width="23" /></a>';
							}
						}else{
							if( $showData->status == 1 ){
								echo $retStr = '<a href="javascript:void(0)" title="UnPublish this content"><img src="'.IMGPATH.'icons/publish.gif" alt="" /></a>';
							
							}else{
								echo $retStr = '<a href="javascript:void(0)" title="Publish this content"><img src="'.IMGPATH.'icons/draft.gif" alt="" width="23" /></a>';
							}

						
						}
						if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){
							echo $retStr = '<a href="'.SITEPATH.strtolower(MODULENAME).'?action=edit&id='.$showData->deployment_id.'&do=manage" title="Edit this content"><img src="'.IMGPATH.'icons/edit.png" alt="" /></a>';
						} 
						if ($this->user->hasPrivilege(strtolower(MODULENAME)."_delete")){
							echo $retStr = '<a href="javascript:void(0)" onclick=\'cms.callAction({"id":'.$showData->deployment_id.', "model":"deployment", "action":"delete"})\' title="Delete this content"><img src="'.IMGPATH.'icons/delete.png" alt="" /></a>';
						}?>
						<?php #TOOLS::displayActionHtml( $this, array( 'id'=>$showData->deployment_id, 'status'=>$showData->status, 'model'=>'deployment' ) ); ?>
					</td>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=4>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
			
		<?php TOOLS::displayMultiActionHtml( $this ); ?>
		
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