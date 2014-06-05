<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/song_icon.png" alt=""  height="45px" width="45px" />Manage Image Bulk Upload</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'imagebulk?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ 
			$aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
<div class="bloc">
    <div class="title">
        Bulk Image Upload Batch Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
                    <th>Batch Id</th>
					<th>Date</th>
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
					<?php echo $showData->batch_id; ?></td>
					<td><?php echo $showData->insert_date;#date("jS M Y",strtotime($showData->insert_date)); ?></td>
                   	<td class="" style=" width:150px">
					<a href="<?=SITEPATH?>imagebulk?action=edit&bid=<?=$showData->batch_id?>" title="Edit this content"><img src="<?=IMGPATH?>icons/edit.png" alt="" /></a>
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