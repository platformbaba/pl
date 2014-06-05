<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
	/* To show errorr */
	if( !empty($aSuccess) ){
		$aParam = array(
					'type' => 'success',
					'msg' => $aSuccess,
				 );
		TOOLS::showNotification( $aParam );
	}


	$youTubeChannelArr= array(1=>'Saregama Tamil',2=>'Saregama Hindi',3=>'Saregama Bollywood');
	$youTubeModeArr= array(1=>'private',2=>'unlisted',3=>'public');
?>		
<div class="bloc" style="margin-top:0px;">
    <div class="title">Video Youtube Deployment<div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" >
	<input type="hidden" name="vFile" value="<?=$aContent['videoFilePath'];?>" />
      <div class="clearfix">
		<div class="clearfix">	
        <div class="input FL50">
          <label for="input1">Video Name <span class='mandatory'>*&nbsp;</span></label>
          <input type="text" id="videoName" name="videoName" value="<?=$aContent['videoName'];?>"/>
      	 </div>
		 <div class="input FL50"> 
		  <a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$aContent['videoImage']));?>"><img alt="<?=$aContent['videoImage'];?>" src="<?=TOOLS::getImage(array('img'=>$aContent['videoImage']));?>" style="max-height:100px; max-width:100px;"></a>
		  <?php
		  $file_2 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mp4",(int)$aContent['videoId']);
		  if(file_exists($file_2)){?><br/>
					<a href="<?=MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mp4",(int)$aContent['videoId']); ?>" class="zoombox" title="<?=$aContent['videoName'];?>"><img src="<?=IMGPATH;?>blue_play.png" height="20px" width="20px" alt="<?=$aContent['videoName']; ?>Preview Video" /></a>
			<?php }
			
			?>
	</div>	
	</div>	
	 <div class="clearfix">	
		<div class="input FL50">
            <label for="input1">Youtube Channel <span class='mandatory'>*&nbsp;</span></label>
			<select name='yChannel' id="yChannel">
			<option value="" >Select Channel</option>
			<?php
			     foreach($youTubeChannelArr as $key=>$Channel){
				  $sel = ($Channel==$aContent['yChannel']) ? "selected='selected'" : "" ;				 
					 echo "<option value='$Channel' $sel>$Channel</option>";
				 }
			?>
			</select>
        </div>
		<div class="input FL50">
            <label for="input1">Youtube Mode</label>
			<select name='yMode' id="yMode">
			<?php
			     foreach($youTubeModeArr as $key=>$Mode){
				  $sel = ($Mode==$aContent['yMode']) ? "selected='selected'" : "" ;
				 	 echo "<option value='$Mode' $sel>".ucfirst($Mode)."</option>";
				 }
			?>
			</select>
        </div>
		</div>		  
				  
	<div style="clear:both"></div>		
		<div class="input textarea">
            <label for="textarea2">Video Description</label>
            <textarea name="videoDescription" id="videoDescription" rows="7" cols="4"  data-prompt-position="topLeft:60" ><?=$aContent['videoDescription']?></textarea>
        </div>	
      <div class="input">
          <label for="input1">Video Tags</label>
          <input type="text" id="videoTags" name="videoTags" value="<?=$aContent['videoTags']?>"/>
		  Tagg name with comma seperated.
      	  </div>
		
	
	    <?php
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		?>
		<div class="submit">
            <input type="submit" value="Submit" name="submitBtn" class="black"/>
			<input type="hidden" name="refferer" value="<?=$_SERVER["HTTP_REFERER"]?>" />
			<input type="hidden" name="albumRightId" value="<?=$aContent['is_owned']?>" />
        </div>
		<?php } ?>
	</form>
    </div>
</div>
</div>