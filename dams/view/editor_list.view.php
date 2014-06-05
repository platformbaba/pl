<!-- CONTENT --> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/eUser.png" alt="" height="45px" width="45px" />Manage Editors</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'editor?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<br class='clear' />
	</div>
	<?php
		/* To show errorr */
		if(cms::sanitizeVariable($_GET['msg'])!=''){
			$aParam = array(
						'type' => 'success',
						'msg' => array(cms::sanitizeVariable($_GET['msg'])),
					 );
			TOOLS::showNotification($aParam);
		}
		
		if( !empty($aError)){
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
        Editors Lists 
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
					<th>Image</th>
                    <th>Name</th>
                    <th>User Name</th>
					<th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><input type="checkbox" value="<?php echo $showData->id; ?>" name="select_ids[]" /></td>
					<td><?php echo $showData->id; ?></td>
					<td><a class="zoombox" href="<?php echo TOOLS::getImage(array('img'=>$showData->image)); ?>"><img alt="" src="<?php echo TOOLS::getImage(array('img'=>$showData->image)); ?>" style="max-height:100px; max-width:100px;"></a>
					</td>
					<td><?php echo $showData->name; ?></td>
					<td><?php echo $showData->username; ?></td>
					<td><?php echo $aRole[$showData->id]; ?></td>
                    <td class="actions">
						<?php if($showData->status == 1){ ?>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->id; ?>, "model":"editor", "action":"draft"})' title="UnPublish this content"><img src="<?php echo IMGPATH; ?>icons/publish.gif" alt="" /></a>
						<?php }else{ ?>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->id; ?>, "model":"editor", "action":"publish"})' title="Publish this content"><img src="<?php echo IMGPATH; ?>icons/draft.gif" alt="" /></a>
						<?php } ?>
						<a href="<?=SITEPATH."editor?action=edit&id=".$showData->id?>" title="Edit this content"><img src="<?php echo IMGPATH; ?>icons/edit.png" alt="" /></a>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->id; ?>, "model":"editor", "action":"delete"})' title="Delete this content"><img src="<?php echo IMGPATH; ?>icons/delete.png" alt="" /></a>
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
			

		<div class="left input">
            <select name="act" id="tableaction" onchange="cms.callMultiAction(this.value)">
                <option value="">Action</option>
				<?php
					$actionArr = TOOLS::getContentActionTypes();
					foreach( $actionArr as $k=>$act ){
						echo '<option value="'.$act.'">'.$act.'</option>';
					} 
				?>
            </select>
        </div>
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
<!--  CONTENT End --> 
