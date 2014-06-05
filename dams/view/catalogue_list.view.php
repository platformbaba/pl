<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/catalogue.png" alt=""  height="45px" width="45px" />Manage Catalogues</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'catalogue?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
				<label for="input">Catalogue Name:</label>
				<input type="text" id="srcCatalogue" name="srcCatalogue" value="<?php echo $aSearch['srcCatalogue']; ?>" />
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
        Catalogues Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Catalogues Name</th>
					<th>Legal</th>
					<th>Start Date</th>
					<th>Expire Date</th>
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
					<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->catalogue_id, 'status'=>$showData->status, 'model'=>'catalogue' ) ); ?>				
					</td>
					<td><?=$showData->catalogue_id; ?></td>
					<td>
					<a href="<?=SITEPATH?>catalogue?action=view&id=<?=$showData->catalogue_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Catalogue Details"><?php echo $showData->catalogue_name; ?></a>
					</td>
					<td>
					<?=$legal = ($showData->is_owned==1) ? 'Owned' : 'Acquired' ; ?>
					</td>
					<td>
					<?=$showData->start_date;?>
					</td>
					<td>
					<?=$showData->expiry_date;?>
					</td>
					<td>
					<?=$showData->insert_date;?>
					</td>
                    <td class="actions" style=" width:100px">
						<a href="<?=SITEPATH?>album?srcClgue=<?=$showData->catalogue_id?>" title="View Albums"><img src="<?=IMGPATH?>icons/content.png"  alt="View Albums"  height="20px" width="20px"/></a>
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->catalogue_id, 'status'=>$showData->status, 'model'=>'catalogue' ) );?>						
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