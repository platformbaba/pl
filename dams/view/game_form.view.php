<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#gameFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
</script>
<script type="text/javascript">
$(function(){
      $('#uploadfile').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=game'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.mov; *.mp4; *.avi;',
 	 	'fileDesc'    : '*.mov,*.mp4,*.avi Game Files',
		'removeCompleted' : false,
		'scriptData'	 : {'gameName' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile').uploadifySettings('scriptData',{'gameName' : $('#gameName').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#gameFilePath').val("");
			$('#FileName').html("").show();
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
			response = eval('('+response+')');
			//console.log(fileObj);
			//console.log(data);
			//console.log(response);
			if(response.status == 'ERROR'){
				alert(response.msg);
			}else if(response.status == 'OK'){
				$('#gameFilePath').val(response.filepath);
				$('#FileName').html('<a href="<?=MEDIA_SITEPATH_TEMP?>'+response.filepath+'" target="_blank" title="game preview">'+response.filename+'</a>').show();
				$('#actions-bar').show();
			}
    	},
		'onError'     : function (event,ID,fileObj,errorObj) {
		  	alert(errorObj.type + ' Error: ' + errorObj.info);
			return false;
		}
      });
});
</script>
<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Game" />Game</h1>
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
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Game</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="gameFrm" name="gameFrm">
		<div class="clearfix">
		<div class="input FL50">
			<label for="input1">Album <span class='mandatory'>*</span></label>
			<input type="text" name="albumsrch" id="albumsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
			<a title="Search Album" href="javascript:void();" onclick="if(document.getElementById('albumsrch').value != 'Search') {cms.srchartist(document.getElementById('albumsrch'), 'album', 'Album'); document.getElementById('albumsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Album</a> Note : Double click to add Album
			<select  name="album[]" id="album" ondblclick="cms.getDetails(this,'albumHidden','albumbox','album');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
			  <?php
										$albumBox="";
										$albumHidden="";
										if($aContent['albumId']){
											$albumHidden=$aContent['albumId'].",";;
											if($aContent['albumNameArr']){
												foreach($aContent['albumNameArr'] as $kStar=>$vStar){
													$albumBox .= "<span id='album_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','albumHidden','album')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
											?>
			  <option value="<?=$kStar;?>" selected="selected">
			  <?=$vStar;?>
			  </option>
			  <?php
												}
											}
										}	
									?>
			</select>
			<!--data-prompt-position="topLeft:420,-1585;-->
			<input type="hidden" name="albumHidden" id="albumHidden" value=",<?=$albumHidden?>" class="validate[required]" data-errormessage="*Please select album." data-prompt-position="topLeft:320,-1485;"/>
			<input type="hidden" name="albumHiddensData" id="albumHiddensData" value="<?=$aContent['albumNameStr']?>" class="validate[required]" data-errormessage="*Please select album." data-prompt-position="topLeft:420,-1485;" />
			<div class="field-content" id="albumbox">
			  <?=$albumBox?>
			</div>
		</div>
		<div class="input FL50">
				<label for="input1">Publisher :<span class='mandatory' id="red">*</span></label>
									
	
									<input type="text" name="banner" id="banner" class="full-width autosuggestBanner" value="<?=$aContent['bannerNameStr']?>" /> 
									<input type="hidden" name="bannerHidden" id="bannerHidden" value=",<?=$bannerHidden?>" />
									<input type="hidden" name="bannerHiddensData" id="bannerHiddensData" value="<?=$aContent['bannerNameStr']?>" />
		</div>
       </div> 
        <div class="clearfix">
		<div class="input FL50">
          <label for="input1">Game Name <span class='mandatory'>*</span></label>
          <input type="text" id="gameName" name="gameName" value="<?=$aContent['gameName']?>" class="validate[required]"/>
        </div>
		<div class="input FL50">
		  <label for="select">Category <span class='mandatory'>*</span></label>
		  <select name="tag_id[]" id="tag_id" >
			<?php 
					foreach($catagoryList as $kVer=>$vVer){
						if($aContent['tag_id']){
							$selVer = (in_array($vVer->tag_id,$aContent['tag_id']))?"selected='selected'":"";
						}
						echo '<option value="'.$vVer->tag_id.'" '.$selVer.' >'.ucwords($vVer->tag_name).'</option>';
					}
				?>
		  </select>
		</div>
		</div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select" >Platform<span class='mandatory'>*</span></label>
            <select name="languageIds" id="select" class="validate[required]">
              <option value="">Select Platform</option>
              <?php 
						foreach($aConfig['game_platform'] as $kL=>$vL){
							if($aContent['platform']){
								$selStr = ($kL==$aContent['platform'])?"selected='selected'":"";
							}
							echo '<option value="'.$kL.'" '.$selStr.' >'.ucwords($vL).'</option>';
						}
					?>
            </select>
          </div>
		  <div class="input FL50">
            <label for="input4">Version</label>
            <input type="text" name="version" id="version" value="<?=$aContent['version']?>" />
          </div>
        </div>
		<div class="clearfix">
			<div class="input FL50">
				<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=15&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
					<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
					<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
					<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
			</div>
			
		</div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Upload Game File (.apk)</label>
			<input type="text" name="uploadfile" id="uploadfile" value="" />
			<input type="hidden" id="gameFilePath" name="gameFilePath" value="<?=$aContent['gameFilePath']?>" />
			<p id="FileName">
				<?php if($aContent['gameFilePath']){?>
				<!--<a href="<?=MEDIA_SITEPATH_VIDEORAW.$aContent['gameFilePath']?>" target="_blank"><?=$aContent['gameFilePath']?></a>
				<br/>-->
				<?php 
				$file_1 = MEDIA_SERVERPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"mov",(int)$_GET['id']);
				 if(file_exists($file_1)){?>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"mov",(int)$_GET['id']); ?>" target="_blank">Download File (.mov)</a>
				<?php }?>
				<?php 
				$file_2 = MEDIA_SERVERPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"mp4",(int)$_GET['id']);
				 if(file_exists($file_2)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"mp4",(int)$_GET['id']); ?>" target="_blank">Download File (.mp4)</a>
				<?php }?>
				<?php 
				$file_3 = MEDIA_SERVERPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"avi",(int)$_GET['id']);
				 if(file_exists($file_3)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"avi",(int)$_GET['id']); ?>" target="_blank">Download File (.avi)</a>
				<?php }?>
				<?php 
				$file_4 = MEDIA_SERVERPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"flv",(int)$_GET['id']);
				 if(is_file($file_4)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getGamePathByTitle($aContent['gameName'],"flv",(int)$_GET['id']); ?>" target="_blank">Download File (.flv)</a>
				<?php }?>
				<?php }?>
			</p>
          </div>
		  <div class="input FL50">
				<a href="<?=SITEPATH?>explorer?action=view&isPlane=1&ldir=<?=MEDIA_SERVERPATH_TEMPFTP?>&dir=<?=MEDIA_SERVERPATH_TEMPFTP?>" class="fancybox fancybox.iframe button" title="BROWSE EXISTING FILES">BROWSE EXISTING GAME FILES</a>
				<br/><br />	
				<span id="rawFile"></span>
				<input type="hidden" name="rawFileVal" id="rawFileVal" value=""	 />
		</div>
        </div>
		<div class="clearfix">
		  <div class="input FL50">
            <label for="input4">Keywords </label>
            <input type="text" id="gameFilePath" name="gameFilePath" value="<?=$aContent['gameFilePath']?>" />
          </div>
        </div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/game?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
var bannerOptions, bannerautocom;
	jQuery(function(){
	  bannerOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=writer', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestwriter"};
	  bannerautocom = $('#banner_<?=$showData->id?>').autocomplete(writerOptions);
	});
</script>		