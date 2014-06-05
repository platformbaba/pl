<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/tag-icon.png" width='40' height='40' alt="" />Manage Tags</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'tags?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
				<label for="input">Tag Name:</label>
				<input type="text" id="srcTag" name="srcTag" value="<?php echo $aSearch['srcTag']; ?>" />
			</div>
			<div class="input FR50">
				<label for="input">Content Type:</label>
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
		<div class="clearfix">
			<div class="input FL50">
				<label for="input">Parent Tag:</label>
				<select name="srcPid" id="srcPid" >
					<option value="">Select</option>
					<?php
						foreach( $aTags as $k=>$val ){
							$check = ($aSearch['srcPid']==$k ? 'selected':'');
							echo '<option value="'.$k.'" '.$check.'>'.$val->tag_name.'</option>';
						} 
					?>
				</select>
			</div>
			<div class="input FR50">
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
        Tags Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th><a href="<?php echo TOOLS::getListSortingUrl(); ?>" title="sort by name">Name</a></th>
					<th>Parent Name</th>
					<th>Insert Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					
					foreach( $aContent as $showData){
						if( $showData->parent_tag_id > 0 ){
							$tagName = $showData->tag_name;
							$parentStr = ($aTags[$showData->parent_tag_id]->tag_name != '')?$aTags[$showData->parent_tag_id]->tag_name:" -- ";
						}else{
							$parentStr = ' -- ';
							$tagName = '<a href="'.SITEPATH.'tags?action=view&srcPid='.$showData->tag_id.'">'.$showData->tag_name.'</a>';
						}
				?>
				<tr>
					<td>
						<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->tag_id, 'status'=>$showData->status, 'model'=>'tags' ) ); ?>	
					</td>
					<td><?php echo $showData->tag_id; ?></td>
					<td><?php echo $tagName; ?></td>
					<td><?php echo $parentStr; ?></td>
					<td><?php echo $showData->insert_date; ?></td>
                    <td class="actions">
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->tag_id, 'status'=>$showData->status, 'model'=>'tags' ) ); ?>
					</td>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=6>'.$aConfig['no-contents'].'</td>
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