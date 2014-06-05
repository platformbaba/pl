<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/eUser.png" alt=""  height="45px" width="45px" />Manage Roles</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'role?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
<div class="bloc">
    <div class="title">
        Role Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Name</th>
					<th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><input type="checkbox" value="<?php echo $showData->role_id; ?>" name="select_ids[]" /></td>
					<td><?php echo $showData->role_id; ?></td>
					<td><?php echo $showData->role_name; ?></td>
					<td><a href="<?=SITEPATH?>role?action=view&do=roleperm&rId=<?php echo $showData->role_id; ?>">Manage Permissions</a></td>
                    <td class="actions">
						<?php if($showData->status == 1){ ?>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->role_id; ?>, "model":"role", "action":"draft"})' title="UnPublish this content"><img src="<?php echo IMGPATH; ?>icons/publish.gif" alt="" /></a>
						<?php }else{ ?>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->role_id; ?>, "model":"role", "action":"publish"})' title="Publish this content"><img src="<?php echo IMGPATH; ?>icons/draft.gif" alt="" /></a>
						<?php } ?>
						<a href="<?php echo SITEPATH.'role?action=edit&id='.$showData->role_id; ?>" title="Edit this content"><img src="<?php echo IMGPATH; ?>icons/edit.png" alt="" /></a>
						<a href="javascript:void(0)" onclick='cms.callAction({"id":<?php echo $showData->role_id; ?>, "model":"role", "action":"delete"})' title="Delete this content"><img src="<?php echo IMGPATH; ?>icons/delete.png" alt="" /></a>
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
<!--            
    CONTENT End 
			--> 