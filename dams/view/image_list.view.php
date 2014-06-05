<!--                CONTENT 			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/wallpaper.png" alt="" width='40' height='40'/>Manage Image (Wallpaper/Animation)</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'image?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<span  style="float: left; margin-top: 4%; margin-left: 1%;" >
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){?>
				<a class="button" href="<?=SITEPATH?>image?action=view&do=qclist" title="<?=(int)$qcPendingTotal?>">QC pending(<?=(int)$qcPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){?>	
				<a class="button" href="<?=SITEPATH?>image?action=view&do=legallist" title="<?=(int)$legalPendingTotal?>">LEGAL pending(<?=(int)$legalPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){?>
				<a class="button" href="<?=SITEPATH?>image?action=view&do=publishlist" title="<?=(int)$publishPendingTotal?>">Final Approval pending(<?=(int)$publishPendingTotal?>)</a>
			<?php }?>
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
<?php
	if($_GET['do']!="qclist" && $_GET['do']!="legallist"  &&$_GET['do']!="publishlist" ){
?>		
<!-- Search Box start -->
<div class="bloc">
    <div class="title">
        Search Filters:
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='GET'>
		<div class="clearfix">
			<div class="input FL PR30">
				<label for="input">Image Name:</label>
				<input type="text" id="srcImage" name="srcImage" value="<?php echo $aSearch['srcImage']; ?>" />
			</div>
			<div class="input FL PR30">
				<label for="input">Image Type:</label>
				<select name="srcImgType" id="srcImgType" >
					<option value="">Select</option>
					<?php
						
						foreach( $image_type as $v=>$k ){
							$check = ($aSearch['srcImgType']==$k ? 'selected':'');
							echo '<option value="'.$k.'" '.$check.'>'.$v.'</option>';
						} 
					?>
				</select>
			</div>
			<div class="input FL PR30">
		     <label for="input1">Image Category </label>
			<select name="srcImageCategory" id="select">
			<option value="">Select</option>
                <?php
					foreach($imageCategory as $tags){
						$selStr = ($aSearch['srcImageCategory']==$tags->tag_id)?"selected='selected'":"";
						echo '<option value="'.$tags->tag_id.'" '.$selStr.' >'.$tags->tag_name.'</option>';
					}
				?>
            </select>

			</div>
			<div class="input FL PR30">
				<label for="input">Status:</label>
				<select name="srcCType" id="srcCType" >
					<option value="">Select</option>
					<?php
						$actionArr = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
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
<?php
}
?>
<div class="bloc">
    <div class="title">
        Image Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
	<?php if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){?>
		<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>playlist?action=add&song_id=multi&isPlane=1&do=addto&ctype=17" class="fancybox fancybox.iframe button" title="Add to playlist">Add selected image to playlist</a>
		</div>
	<?php }?>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
					<th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
				
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
						$dis_type = TOOLS::display_image_type($showData->image_type);
					
					if(!empty($imageCategory)){
					
						foreach($imageCategory as $tags){
							if($showData->image_tag_id==$tags->tag_id){
								$dis_cat = $tags->tag_name;
								break;
							}else{
								$dis_cat ="";
							}
						}
					}
				?>
				<tr>
					<td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->image_id, 'status'=>$showData->status, 'model'=>'image', 'flow'=>'legal','obj'=>$this ) ); ?>	</td>
					<td><?php echo $showData->image_id; ?></td>
					<td><a class="zoombox" href="<?php echo TOOLS::getImage(array('img'=>$showData->image_file)); ?>"><img alt="image" src="<?php echo TOOLS::getImage(array('img'=>$showData->image_file)); ?>" style="max-height:100px; max-width:100px;"></a></td>
					<td><a href="<?=SITEPATH?>image?action=view&id=<?=$showData->image_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Image Details"><?php echo $showData->image_name; ?></a></td>
					<td><?php echo rtrim($dis_type,","); ?></td>
					<td><?php echo $dis_cat; ?></td>
                    <td class="" style=" width:150px">
					<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){ ?>
						<a href="<?=SITEPATH?>image?action=view&id=<?=$showData->image_id?>&isPlane=1&do=rights" class="fancybox fancybox.iframe" title="Manage Image Rights"><img src="<?=IMGPATH?>icons/legal_right.png" height="20px" width="20px" alt="Manage Image Rights"  /></a>
			<?php } 
						
							if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){
			 ?>		 
								<a href="<?=SITEPATH?>playlist?action=add&song_id=<?php echo $showData->image_id; ?>&isPlane=1&do=addto&song_name=<?php echo urlencode($showData->image_name); ?>&ctype=17" class="fancybox fancybox.iframe" title="Add to playlist"><img src="<?=IMGPATH?>icons/playlist-add.png" alt="Add to playlist"  /></a>
						  <?php
						  }
						  ?>
						<a href="<?=SITEPATH?>image?action=view&do=showedits&id=<?=$showData->image_id?>&image_name=<?php echo urlencode($showData->image_name); ?>&isPlane=1" class="fancybox fancybox.iframe" title="Manage Edits"><img src="<?=IMGPATH?>icons/edits.png" height="20px" width="20px"  alt="Manage Edits"  /></a>
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->image_id, 'status'=>$showData->status, 'model'=>'image', 'flow'=>'legal' ) ); ?>
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
			
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->image_id, 'status'=>$showData->status, 'model'=>'image', 'flow'=>'legal' ) ); ?>
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