<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#playlistFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<!-- CONTENT -->
<script src="<?=JSPATH?>jquery.sortable.js" ></script>
<style>
		#demos section {
			overflow: hidden;
		}
		.sortable {
			width: 310px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.sortable.grid {
			overflow: hidden;
		}
		.sortable li {
			list-style: none;
			border: 1px solid #CCC;
			background: #F6F6F6;
			color: #1C94C4;
			margin: 5px;
			padding: 5px;
			height: 22px;
		}
		.sortable.grid li {
			line-height: 80px;
			float: left;
			width: 80px;
			height: 80px;
			text-align: center;
		}
		.handle {
			cursor: move;
		}
		.sortable.connected {
			width: 200px;
			min-height: 100px;
			float: left;
		}
		li.disabled {
			opacity: 0.5;
		}
		li.highlight {
			background: #FEE25F;
		}
		li.sortable-placeholder {
			border: 1px dashed #CCC;
			background: none;
		}
</style>
<div id="content">
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" /> Manage <?=$aContent['playlistName']?> Playlist</h1>
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
  <div class="bloc" >
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Playlist</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="playlistFrm" name="playlistFrm">
		<div class="clearfix">
        <div class="input FL50">
          <label for="input1">Playlist Name <span class='mandatory'>*</span></label>
          <input type="text" id="playlistName" name="playlistName" value="<?=$aContent['playlistName']?>" class="validate[required]"/>
        </div>
		<div class="input FL50">
            <label for="select">Language</label>
			<select name="languageIds" id="select" >
                <option value="0">Select Language</option>
				<?php 
					foreach($languageList as $kL=>$vL){
						if($aContent['languageIds']){
							$selStr = ($vL->language_id==$aContent['languageIds'])?"selected='selected'":"";
						}
						echo '<option value="'.$vL->language_id.'" '.$selStr.' >'.ucwords($vL->language_name).'</option>';
					}
				?>
            </select>
        </div>
		</div>
		<div class="clearfix">
		<div class="input FL50">
			<label for="input1">Contents <span class='mandatory'>*</span></label>(drag and drop to sort)
			<ul class="sortable list" id="sortable-with-handles">
				<?php 
										$songBox="";
										$songHidden="";
										if($aContent['songId']){
											$songHidden=$aContent['songId'].",";;
											if($aContent['songNameArr']){
												$r=1;
												foreach($aContent['songNameArr'] as $kStar=>$vStar){
											?>
												<li draggable="true" class="" style="display: list-item;" id="li_<?=$r?>">
													<span class="handle"><?=$r?> ::
													<?=$vStar;?>
													<input type="hidden" value="<?=$kStar?>" name="songIds[]" />
													<a title="Remove this content" href="javascript:void(0)" style="float:right" onclick="removeThis('li_<?=$r?>')"><img alt="Remove this content" src="<?=IMGPATH?>icons/delete.png"></a>
													<?php
														if($aContent['songImageArr'][$kStar]){
													?>
													<a href="<?=MEDIA_SITEPATH_IMAGE.$aContent['songImageArr'][$kStar]?>" style="float:right" class="zoombox" title="view"><img src="<?=IMGPATH?>icons/eye.png" width="20" height="20"  /></a>
													<?php	}
													?>
													</span> 
												</li>
											  <?php
													$r++;
												}
											}
										}	
									?>
			</ul>
		</div>
		<div class="input FL50">
			<label for="input1">Image</label>
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=29&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
        </div>
        </div> 
        <div class="submit">
		  <input type="hidden" value="<?=$data['aContent']['ctype']?>" name="ctype"  />
		  <?php
			if($data['aContent']['userId']==TOOLS::getEditorId()){
		  ?>
          <input type="submit" value="Submit" name="submitBtn"/>
		  <?php
		  	}
		  ?>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>playlist?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#sortable-with-handles').sortable({
	handle: '.handle'
});
function removeThis(obj){
	$("#"+obj).remove();
}
</script>