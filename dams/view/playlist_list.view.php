<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/playlist.png" alt=""  height="45px" width="45px" />Manage Playlist</h1></span>
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
  <div class="bloc">
    <div class="title">Playlist Search Filters: <a class="toggle" href="javascript:void(0);"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='GET'>
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Playlist Title :</label>
            <input type="text" id="srcPlaylist" name="srcPlaylist" value="<?php echo $aSearch['srcPlaylist']; ?>" class="WD150" />
          </div>
          <!--<div class="input FL PR30">
            <label for="input">Status :</label>
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
          </div>-->
		  <div class="input FL PR30">
            <label for="input">Content Type :</label>
            <select name="srcCtype" id="srcCtype" >
              <option value="">Select</option>
              <?php
					$check1 = ($aSearch['srcCtype']==4 ? 'selected':'');
					$check2 = ($aSearch['srcCtype']==15 ? 'selected':'');
					$check3 = ($aSearch['srcCtype']==17 ? 'selected':'');
					echo '<option value="4" '.$check1.'>Song</option>';
					echo '<option value="15" '.$check2.'>Video</option>';
					echo '<option value="17" '.$check3.'>Image</option>';
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
			<label for="input">Playlist Id :</label>
            <input type="text" id="srcPlaylistId" name="srcPlaylistId" value="<?php echo $aSearch['srcPlaylistId']; ?>" class="WD150"/>
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
        Playlist Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Image</th>
					<th>Playlist Title</th>
					<th>Type</th>
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
					<?php
						if($showData->user_id==TOOLS::getEditorId()){
					?>
					<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->playlist_id, 'status'=>$showData->status, 'model'=>'playlist', 'flow'=>'' , 'obj'=>$this) ); ?>	
					<?php
						}
					?>
					</td>
					<td>				
					<?php echo $showData->playlist_id; ?></td>
					<td>
						<a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$showData->image));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$showData->image));?>" style="max-height:100px; max-width:100px;"></a>
					</td>
					<td>
					<a href="<?=SITEPATH?>playlist?action=view&id=<?=$showData->playlist_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Playlist Details"><?php echo ucfirst($showData->playlist_name); ?></a>
					</td>
					<td><?php echo ucfirst($aConfig['module'][$showData->content_type]); ?></td>
					<td><?php echo $showData->insert_date;#date("jS M Y",strtotime($showData->insert_date)); ?></td>
                   	<td class="actions">
					<?php
						if($showData->user_id==TOOLS::getEditorId()){
					?>	
					<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->playlist_id, 'status'=>$showData->status, 'model'=>'playlist') ); ?>	
					<?php
						}
					?>
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
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->playlist_id, 'status'=>$showData->status, 'model'=>'playlist' ) ); ?>
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