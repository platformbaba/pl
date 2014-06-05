<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/song_icon.png" alt=""  height="45px" width="45px" />Manage album Bulk Upload</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'albumbulk?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
  <!-- Search Box start -->
  <!--<div class="bloc">
    <div class="title">Bulk album Search Filters: <a class="toggle" href="javascript:void(0);"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='GET'>
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Video Title :</label>
            <input type="text" id="srcVideo" name="srcVideo" value="<?php echo $aSearch['srcVideo']; ?>" class="WD150" />
          </div>
          <div class="input FL PR30">
            <label for="input">Status :</label>
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
		  <div class="input FL PR30">
            <label for="input">Start Date :</label>
            <input type="text" id="srcSrtDate" name="srcSrtDate" value="<?php echo $aSearch['srcSrtDate']; ?>" class="datepicker" />
          </div>
		  <div class="input FL PR30">
            <label for="input">End Date :</label>
            <input type="text" id="srcEndDate" name="srcEndDate" value="<?php echo $aSearch['srcEndDate']; ?>" class="datepicker" />
          </div>
		   <div class="input FL PR30">
            <label for="input">Language :</label>
            <select name="srcLang" id="srcLang" >
              <option value="">Select</option>
              <?php
						foreach($aSearch['languageList'] as $act ){
							$check = ($aSearch['srcLang']==$act->language_id ? 'selected':'');
							echo '<option value="'.$act->language_id.'" '.$check.'>'.$act->language_name.'</option>';
						} 
					?>
            </select>
          </div>
        </div>
		
		<div class="clearfix">
          <div class="input FL PR30">
			<label for="input">Video Id :</label>
            <input type="text" id="srcVideoId" name="srcVideoId" value="<?php echo $aSearch['srcVideoId']; ?>" class="WD150"/>
		  </div>
		</div>   
		<div class="submit" align='right'>
          <input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
        </div>
        <div class="cb"></div>
      </form>
    </div>
  </div-->
  <!-- Search Box end -->
<div class="bloc">
    <div class="title">
        Bulk album Upload Batch Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
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
					<a href="<?=SITEPATH?>albumbulk?action=edit&bid=<?=$showData->batch_id?>" title="Edit this content"><img src="<?=IMGPATH?>icons/edit.png" alt="" /></a>
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