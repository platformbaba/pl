<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/video.png" alt=""  height="45px" width="45px" />Manage Video</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'video?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<span  style="float: left; margin-top: 4%; margin-left: 1%;" >
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){?>
				<a class="button" href="<?=SITEPATH?>video?action=view&do=qclist" title="<?=(int)$qcPendingTotal?>">QC pending(<?=(int)$qcPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){?>	
				<a class="button" href="<?=SITEPATH?>video?action=view&do=legallist" title="<?=(int)$legalPendingTotal?>">LEGAL pending(<?=(int)$legalPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){?>
				<a class="button" href="<?=SITEPATH?>video?action=view&do=publishlist" title="<?=(int)$publishPendingTotal?>">Final Approval pending(<?=(int)$publishPendingTotal?>)</a>
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
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ 
			$aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
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
    <div class="title">Video Search Filters: <a class="toggle" href="javascript:void(0);"></a></div>
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
  </div>
  <!-- Search Box end -->
<?php
}
?>	
<div class="bloc">
    <div class="title">
        Video Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
   	<?php if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){?>
		<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>playlist?action=add&song_id=multi&isPlane=1&do=addto&ctype=15" class="fancybox fancybox.iframe button" title="Add to playlist">Add selected videos to playlist</a>
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
					<th>Video Title</th>
					<th>YouTube Deployment</th>
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
					<td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->video_id, 'status'=>$showData->status, 'model'=>'video', 'flow'=>'legal' , 'obj'=>$this) ); ?>	
					</td>
					<td>				
					<?php echo $showData->video_id; ?></td>
					<td>
						<a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$showData->image));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$showData->image));?>" style="max-height:100px; max-width:100px;"></a>
					</td>
					<td>
					<?php 
					$file_1 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"mov",(int)$showData->video_id);
					$file_2 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"mp4",(int)$showData->video_id);
					$file_3 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"avi",(int)$showData->video_id);
					$file_4 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"flv",(int)$showData->video_id);
					 if(file_exists($file_1)){?>
					<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"wav",(int)$showData->video_id); ?>" class="zoombox" title="<?=$showData->video_name?>"><img src="<?=IMGPATH?>blue_play.png" height="20px" width="20px" alt="Preview Video" /></a>
					<?php }else if(file_exists($file_2)){?><br/>
					<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"mp4",(int)$showData->video_id); ?>" class="zoombox" title="<?=$showData->video_name?>"><img src="<?=IMGPATH?>blue_play.png" height="20px" width="20px" alt="Preview Video" /></a>
					<?php }else if(file_exists($file_3)){?><br/>
					<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"3gp",(int)$showData->video_id); ?>" class="zoombox" title="<?=$showData->video_name?>"><img src="<?=IMGPATH?>blue_play.png" height="20px" width="20px" alt="Preview Video" /></a>
					<?php }else if(file_exists($file_4)){?><br/>
					<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($showData->video_name,"flv",(int)$showData->video_id); ?>" class="zoombox" title="<?=$showData->video_name?>"><img src="<?=IMGPATH?>blue_play.png" height="20px" width="20px" alt="Preview Video" /></a>
					<?php }?>

					<a href="<?=SITEPATH?>video?action=view&id=<?=$showData->video_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Video Details"><?php echo ucfirst($showData->video_name); ?></a>
					</td>
					<td>
					<?php
					if(strlen($showData->youtube_id)>0 && $showData->youtube_id!='NULL'){
					?>				
					<a href="<?=SITEPATH;?>video?action=view&id=<?=$showData->video_id?>&isPlane=1&do=youtubepop&yId=<?=$showData->youtube_id;?>&vName=<?=urlencode(strtolower($showData->video_name));?>" class="fancybox fancybox.iframe" title="Preview ( This Video Deployed On Youtube )"><img src="<?=IMGPATH?>icons/yt.png" height="20px" width="20px" /></a>
					<?php
					}else{
					?>
					<a href="<?=SITEPATH;?>video?action=view&id=<?=$showData->video_id?>&isPlane=1&do=youtube" class="fancybox fancybox.iframe" title="Deploy On Youtube">Youtube</a>					<?php
					}
					?>
					</td>
					<td><?php echo $showData->insert_date;#date("jS M Y",strtotime($showData->insert_date)); ?></td>
                   	<td class="" style=" width:150px">
					<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){ ?>
						<a href="<?=SITEPATH?>video?action=view&id=<?=$showData->video_id?>&isPlane=1&do=rights" class="fancybox fancybox.iframe" title="Manage Video Rights"><img src="<?=IMGPATH?>icons/legal_right.png" height="20px" width="20px" alt="Manage Video Rights"  /></a>
			<?php }
			     
				  	if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){
			?>		 
				  		<a href="<?=SITEPATH?>playlist?action=add&song_id=<?php echo $showData->video_id; ?>&isPlane=1&do=addto&song_name=<?php echo urlencode($showData->video_name); ?>&ctype=15" class="fancybox fancybox.iframe" title="Add to playlist"><img src="<?=IMGPATH?>icons/playlist-add.png" alt="Add to playlist"  /></a>
				  <?php
				  }
				  ?>
					<a href="<?=SITEPATH?>video?action=view&do=showedits&id=<?=$showData->video_id?>&video_name=<?php echo urlencode($showData->video_name); ?>&isPlane=1" class="fancybox fancybox.iframe" title="Manage Edits"><img src="<?=IMGPATH?>icons/edits.png" height="20px" width="20px"  alt="Manage Edits"  /></a>
					<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->video_id, 'status'=>$showData->status, 'model'=>'video', 'flow'=>'legal' ) ); ?>	
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
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->video_id, 'status'=>$showData->status, 'model'=>'video', 'flow'=>'legal' ) ); ?>
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