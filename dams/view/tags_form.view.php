<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Tags</h1>
<?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
	
	
?>
<div class="bloc">
    <div class="title">Add Tags</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Tag Name <span class='mandatory'>*</span></label>
            <input type="text" id="tagName" name="tagName" value="<?=$aContent['tagName']?>" />
        </div>
        
		<div class="input">
            <label for="input1">Parent Tag Name</label>
            <select name="parentTagId" id="parentTagId">
				<option value='0'> -- </option>
				<?php
					foreach($aTags as $k=>$tag){
						$selStr = ($aContent['parentTagId']==$tag->tag_id)?"selected='selected'":"";
						echo '<option value="'.$tag->tag_id.'" '.$selStr.' >'.$tag->tag_name.'</option>';
					}
				?>
					
            </select>
        </div>
		
		<div class="input">
            <label for="input1">Tag Alias </label>
            <textarea id="tagAlias" name="tagAlias"><?=$aContent['tagAlias']?></textarea>
        </div>
		
		<div class="input">
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=9&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
        </div>
		<?php /* Commented on 18th Feb 2014?>
		<div class="input">
            <label for="input2"> Used only for Parent Tags:</label>
			<?php 				  
				  $isSong = $aContent['tagAccess']&2;
				  $isAlbum = $aContent['tagAccess']&4;
			?>
			Songs <input type="checkbox" name='tagAccess[]' value=2 <?php echo ($isSong?'checked':'')?> />
			Album <input type="checkbox" name='tagAccess[]' value=4 <?php echo ($isAlbum?'checked':'')?> />
        </div>
		<?php */ ?>
		
		<div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/tags?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>