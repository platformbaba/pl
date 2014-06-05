<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/text.png" alt="" width='40' height='40'/>Manage Text (SmS/General Text)</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'text?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<span  style="float: left; margin-top: 4%; margin-left: 1%;" >
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){?>
				<a class="button" href="<?=SITEPATH?>text?action=view&do=qclist" title="<?=(int)$qcPendingTotal?>">QC pending(<?=(int)$qcPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){?>	
				<a class="button" href="<?=SITEPATH?>text?action=view&do=legallist" title="<?=(int)$legalPendingTotal?>">LEGAL pending(<?=(int)$legalPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){?>
				<a class="button" href="<?=SITEPATH?>text?action=view&do=publishlist" title="<?=(int)$publishPendingTotal?>">Final Approval pending(<?=(int)$publishPendingTotal?>)</a>
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
				<label for="input">Text Name:</label>
				<input type="text" id="srcText" name="srcText" value="<?php echo $aSearch['srcText']; ?>" class="WD150" />
			</div>
			
			<div class="input FL PR30">
			
				<label for="input">Text Type:</label>
				<select name="srcTxtType" id="srcTxtType" >
					<option value="">Select</option>
					<?php
						
						foreach( $text_type as $v=>$k ){
							$check = ($aSearch['srcTxtType']==$k ? 'selected':'');
							echo '<option value="'.$k.'" '.$check.'>'.$v.'</option>';
						} 
					?>
				</select>
			</div>
		<div class="input FL PR30">
            <label for="select">Language</label>
            <select name="languageIds" id="select" >
              <option value="0">Select Language</option>
              <?php 
						foreach($languageList as $kL=>$vL){
							if($aSearch['languageIds']){
								$selStr = ($vL->language_id==$aSearch['languageIds'])?"selected='selected'":"";
							}
							echo '<option value="'.$vL->language_id.'" '.$selStr.' >'.ucwords($vL->language_name).'</option>';
						}
					?>
            </select>
          </div>			
			<div class="input FL">
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
        Text Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
						$dis_type = TOOLS::display_text_type($showData->text_type);
						//$dis_type = '';
				?>
				<tr>
					<td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->text_id, 'status'=>$showData->status, 'model'=>'text', 'flow'=>'legal','obj'=>$this ) ); ?>	</td>
					<td><?php echo $showData->text_id; ?></td>
					<td><a href="<?=SITEPATH?>text?action=view&id=<?=$showData->text_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Text Details"><?php echo $showData->text_name; ?></a></td>
					<td><?php echo $dis_type; ?></td>
                    <td class="actions">
					<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){ ?>
						<a href="<?=SITEPATH?>text?action=view&id=<?=$showData->text_id?>&isPlane=1&do=rights" class="fancybox fancybox.iframe" title="Manage Text Rights"><img src="<?=IMGPATH?>icons/legal_right.png" height="20px" width="20px" alt="Manage Text Rights"  /></a>
			<?php }
						 TOOLS::displayActionHtml( $this, array( 'id'=>$showData->text_id, 'status'=>$showData->status, 'model'=>'text', 'flow'=>'legal' ) );
			 ?>
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