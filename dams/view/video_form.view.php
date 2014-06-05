<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#videoFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
</script>
<script type="text/javascript">
$(function(){
      $('#uploadfile').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=video'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.mov; *.mp4; *.avi;',
 	 	'fileDesc'    : '*.mov,*.mp4,*.avi Video Files',
		'removeCompleted' : false,
		'scriptData'	 : {'videoName' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile').uploadifySettings('scriptData',{'videoName' : $('#videoName').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#videoFilePath').val("");
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
				$('#videoFilePath').val(response.filepath);
				$('#FileName').html('<a href="<?=MEDIA_SITEPATH_TEMP?>'+response.filepath+'" target="_blank" title="video preview">'+response.filename+'</a>').show();
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
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Video" />Video</h1>
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
    <div class="title"><?=ucfirst($_GET['action'])?>Video <div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="videoFrm" name="videoFrm">
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
			<label for="input1">Song/Dialogue</label>
			<input type="text" name="songsrch" id="songsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
			<a title="Search Song" href="javascript:void();" onclick="if(document.getElementById('songsrch').value != 'Search') {cms.srchartist(document.getElementById('songsrch'), 'song', 'Song'); document.getElementById('songsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Song</a> Note : Double click to add Song
			<select  name="song[]" id="song" ondblclick="cms.getDetails(this,'songHidden','songbox','song');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
			  <?php
										$songBox="";
										$songHidden="";
										if($aContent['songId']){
											$songHidden=$aContent['songId'].",";;
											if($aContent['songNameArr']){
												foreach($aContent['songNameArr'] as $kStar=>$vStar){
													$songBox .= "<span id='song_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','songHidden','song')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
			<input type="hidden" name="songHidden" id="songHidden" value=",<?=$songHidden?>" />
			<input type="hidden" name="songHiddensData" id="songHiddensData" value="<?=$aContent['songNameStr']?>" />
			<div class="field-content" id="songbox">
			  <?=$songBox?>
			</div>
		</div>
        </div> 
        <div class="input">
          <label for="input1">Video Name <span class='mandatory'>*</span></label>
          <input type="text" id="videoName" name="videoName" value="<?=$aContent['videoName']?>" class="validate[required]"/>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select" >Language<span class='mandatory'>*</span></label>
            <select name="languageIds" id="select" class="validate[required]">
              <option value="">Select Language</option>
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
		  <div class="input FL50">
            <label for="input4">Release Date <span class='mandatory'>*</span></label>
            <input type="text" name="releaseDate" class="datepicker validate[required]" id="releaseDate" value="<?=$aContent['releaseDate']?>"/>
          </div>
        </div>
        <div class="clearfix">
		  <!--<div class="input FL50">
				<label for="input1">Video Tempo</label>
				<input type="text" id="videoTempo" name="videoTempo" value="<?=$aContent['videoTempo']?>" />
			</div>-->
          <div class="input FL50">
            <label for="input1">Video Duration (in sec) <span class='mandatory'>*</span></label>
            <input type="text" id="videoDuration" name="videoDuration" value="<?=$aContent['videoDuration']?>" class="validate[required]"/>
          </div>
        </div>
		<div class="clearfix">
			<div class="input FL50">
				<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=15&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
					<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
					<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
					<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
			</div>
			<div class="input FL50">
				<label for="input1">Subject of Parody</label>
				<input type="text" id="subjectParody" name="subjectParody" value="<?=$aContent['subjectParody']?>" />
			</div>
		</div>
        <div class="clearfix">
		  <!--<div class="input FL50">
            <label for="input4">Video File Path <span class='mandatory'>*</span></label>
            <input type="text" id="videoFilePath" name="videoFilePath" value="<?=$aContent['videoFilePath']?>" />
          </div>-->
          <div class="input FL50">
            <label for="input1">Upload Video File (.mov,.mp4,.avi)</label>
			<input type="text" name="uploadfile" id="uploadfile" value="" />
			<input type="hidden" id="videoFilePath" name="videoFilePath" value="<?=$aContent['videoFilePath']?>" />
			<p id="FileName">
				<?php if($aContent['videoFilePath']){?>
				<!--<a href="<?=MEDIA_SITEPATH_VIDEORAW.$aContent['videoFilePath']?>" target="_blank"><?=$aContent['videoFilePath']?></a>
				<br/>-->
				<?php 
				$file_1 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mov",(int)$_GET['id']);
				 if(file_exists($file_1)){?>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mov",(int)$_GET['id']); ?>" target="_blank">Download File (.mov)</a>
				<?php }?>
				<?php 
				$file_2 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mp4",(int)$_GET['id']);
				 if(file_exists($file_2)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"mp4",(int)$_GET['id']); ?>" target="_blank">Download File (.mp4)</a>
				<?php }?>
				<?php 
				$file_3 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"avi",(int)$_GET['id']);
				 if(file_exists($file_3)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"avi",(int)$_GET['id']); ?>" target="_blank">Download File (.avi)</a>
				<?php }?>
				<?php 
				$file_4 = MEDIA_SERVERPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"flv",(int)$_GET['id']);
				 if(is_file($file_4)){?><br/>
				<a href="<?php echo MEDIA_SITEPATH_VIDEORAW.tools::getVideoPathByTitle($aContent['videoName'],"flv",(int)$_GET['id']); ?>" target="_blank">Download File (.flv)</a>
				<?php }?>
				<?php }?>
			</p>
          </div>
		  <div class="input FL50">
				<a href="<?=SITEPATH?>explorer?action=view&isPlane=1&ldir=<?=MEDIA_SERVERPATH_TEMPFTP?>&dir=<?=MEDIA_SERVERPATH_TEMPFTP?>" class="fancybox fancybox.iframe button" title="BROWSE EXISTING FILES">BROWSE EXISTING VIDIO FILES</a>
				<br/><br />	
				<span id="rawFile"></span>
				<input type="hidden" name="rawFileVal" id="rawFileVal" value=""	 />
		</div>
        </div>
		<div class="clearfix">
          <div class="input FL50">
            <label for="input1">Starcast <span class='mandatory'>*</span></label>
            <input type="text" name="starcastsrch" id="starcastsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Starcast" href="javascript:void();" onclick="if(document.getElementById('starcastsrch').value != 'Search') {cms.srchartist(document.getElementById('starcastsrch'), 'starcast', 'Starcast'); document.getElementById('starcastsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Starcast</a> Note : Double click to add Starcast
            <select  name="starcast[]" id="starcast" ondblclick="cms.getDetails(this,'starcastHidden','starcastbox','starcast');" style="width:250px; height:100px;"  size="10" multiple="multiple" class="validate[required]">
              <?php
										$starcastBox="";
										$starcastHidden="";
										if($aContent['starcastId']){
											$starcastHidden=$aContent['starcastId'].",";;
											if($aContent['starcastNameArr']){
												foreach($aContent['starcastNameArr'] as $kStar=>$vStar){
													$starcastBox .= "<span id='starcast_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','starcastHidden','starcast')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
            <input type="hidden" name="starcastHidden" id="starcastHidden" value=",<?=$starcastHidden?>" />
            <input type="hidden" name="starcastHiddensData" id="starcastHiddensData" value="<?=$aContent['starcastNameStr']?>"/>
            <div class="field-content" id="starcastbox">
              <?=$starcastBox?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input1">Director <span class='mandatory'>*</span></label>
            <input type="text" name="directorsrch" id="directorsrch" class="full-width autosuggestDir" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Director" href="javascript:void();" onclick="if(document.getElementById('directorsrch').value != 'Search') {cms.srchartist(document.getElementById('directorsrch'), 'director', 'Director'); document.getElementById('directorsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Director</a> Note : Double click to add Director
            <select  name="director[]" id="director" ondblclick="cms.getDetails(this,'directorHidden','directorbox','director');" style="width:250px; height:100px;"  size="10" multiple="multiple" class="validate[required]" >
              <?php
										$directorBox="";
										$directorHidden="";
										if($aContent['directorId']){
											$directorHidden=$aContent['directorId'].",";
											if($aContent['directorNameArr']){
												foreach($aContent['directorNameArr'] as $kDir=>$vDir){
											$directorBox .= "<span id='director_".$kDir."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kDir."','directorHidden','director')\" title='Double Click to Remove' >".$vDir."</a><br></span>";
									?>
              <option value="<?=$kDir;?>" selected="selected">
              <?=$vDir;?>
              </option>
              <?php
											}
										}
									}	
									?>
            </select>
            <input type="hidden" name="directorHidden" id="directorHidden" value=",<?=$directorHidden?>" />
            <input type="hidden" name="directorHiddensData" id="directorHiddensData" value="<?=$aContent['directorNameStr']?>"/>		
			
			
            <div class="field-content" id="directorbox">
              <?=$directorBox?>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Lyricist <span class='mandatory'>*</span></label>
            <input type="text" name="lyricistsrch" id="lyricistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Lyricist" href="javascript:void();" onclick="if(document.getElementById('lyricistsrch').value != 'Search') {cms.srchartist(document.getElementById('lyricistsrch'), 'lyricist', 'Lyricist'); document.getElementById('lyricistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Lyricist</a> Note : Double click to add Lyricist
            <select  name="lyricist[]" id="lyricist" ondblclick="cms.getDetails(this,'lyricistHidden','lyricistbox','lyricist');" style="width:250px; height:100px;"  size="10" multiple="multiple" class="validate[required]">
              <?php
										$lyricistBox="";
										$lyricistHidden="";
										if($aContent['lyricistId']){
											$lyricistHidden=$aContent['lyricistId'].",";
											if($aContent['lyricistNameArr']){
												foreach($aContent['lyricistNameArr'] as $kLyr=>$vLyr){
														$lyricistBox .= "<span id='lyricist_".$kLyr."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kLyr."','lyricistHidden','lyricist')\" title='Double Click to Remove' >".$vLyr."</a><br></span>";
												?>
              <option value="<?=$kLyr;?>" selected="selected">
              <?=$vLyr;?>
              </option>
              <?php
											}
										}
									}	
									?>
            </select>
            <input type="hidden" name="lyricistHidden" id="lyricistHidden" value=",<?=$lyricistHidden?>" />
            <input type="hidden" name="lyricistHiddensData" id="lyricistHiddensData" value="<?=$aContent['lyricistNameStr']?>" />
            <div class="field-content" id="lyricistbox">
              <?=$lyricistBox?>
            </div>
          </div>
          <!--<div class="input FL50">
            <label for="input1">Poet</label>
            <input type="text" name="poetsrch" id="poetsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Poet" href="javascript:void();" onclick="if(document.getElementById('poetsrch').value != 'Search') {cms.srchartist(document.getElementById('poetsrch'), 'poet', 'Poet'); document.getElementById('poetsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Poet</a> Note : Double click to add Poet
            <select  name="poet[]" id="poet" ondblclick="cms.getDetails(this,'poetHidden','poetbox','poet');" style="width:250px; height:100px;"  size="10" multiple="multiple">
              <?php
									/*$poetBox="";
									$poetHidden="";
									if($aContent['poetId']){
										$poetHidden=$aContent['poetId'].",";
										if($aContent['poetNameArr']){
											foreach($aContent['poetNameArr'] as $kPoet=>$vPoet){
													$poetBox .= "<span id='poet_".$kPoet."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kPoet."','poetHidden','poet')\" title='Double Click to Remove' >".$vPoet."</a><br></span>";
											?>
              <option value="<?=$kPoet;?>" selected="selected">
              <?=$vPoet;?>
              </option>
              <?php
										}
									}
								}	*/
							?>
            </select>
            <input type="hidden" name="poetHidden" id="poetHidden" value=",<?=$poetHidden?>" />
            <input type="hidden" name="poetHiddensData" id="poetHiddensData" value="<?=$aContent['poetNameStr']?>" />
            <div class="field-content" id="poetbox">
              <?=$poetBox?>
            </div>
          </div>-->
        </div>
        <div class="clearfix">          
		  <div class="input FL50">
            <label for="input1">Singer <span class='mandatory'>*</span></label>
            <input type="text" name="singersrch" id="singersrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Singer" href="javascript:void();" onclick="if(document.getElementById('singersrch').value != 'Search') {cms.srchartist(document.getElementById('singersrch'), 'singer', 'Singer'); document.getElementById('singersrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Singer</a> Note : Double click to add Singer
            <select  name="singer[]" id="singer" ondblclick="cms.getDetails(this,'singerHidden','singerbox','singer');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
              <?php
										$singerBox="";
										$singerHidden="";
										if($aContent['singerId']){
											$singerHidden=$aContent['singerId'].",";;
											if($aContent['singerNameArr']){
												foreach($aContent['singerNameArr'] as $kStar=>$vStar){
													$singerBox .= "<span id='singer_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','singerHidden','singer')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
            <input type="hidden" name="singerHidden" id="singerHidden" value=",<?=$singerHidden?>" />
            <input type="hidden" name="singerHiddensData" id="singerHiddensData" value="<?=$aContent['singerNameStr']?>" class="validate[required]" data-errormessage="*Please select singer." data-prompt-position="topLeft:450,-425;"/>
            <div class="field-content" id="singerbox">
              <?=$singerBox?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input1">Mimicked Star</label>
            <input type="text" name="mstarcastsrch" id="mstarcastsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Mimicked Star" href="javascript:void();" onclick="if(document.getElementById('mstarcastsrch').value != 'Search') {cms.srchartist(document.getElementById('mstarcastsrch'), 'mstarcast', 'Starcast'); document.getElementById('mstarcastsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Mimicked Star</a> Note : Double click to add Mimicked Star
            <select  name="mstarcast[]" id="mstarcast" ondblclick="cms.getDetails(this,'mstarcastHidden','mstarcastbox','mstarcast');" style="width:250px; height:100px;"  size="10" multiple="multiple">
              <?php
										$mstarcastBox="";
										$mstarcastHidden="";
										if($aContent['mstarcastId']){
											$mstarcastHidden=$aContent['mstarcastId'].",";
											if($aContent['mstarcastNameArr']){
												foreach($aContent['mstarcastNameArr'] as $kStar=>$vStar){
														$mstarcastBox .= "<span id='mstarcast_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','mstarcastHidden','mstarcast')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
            <input type="hidden" name="mstarcastHidden" id="mstarcastHidden" value=",<?=$mstarcastHidden?>" />
            <input type="hidden" name="mstarcastHiddensData" id="mstarcastHiddensData" value="<?=$aContent['mstarcastNameStr']?>" />
            <div class="field-content" id="mstarcastbox">
              <?=$mstarcastBox?>
            </div>
          </div>
        </div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Version</label>
			  <select name="version[]" id="version"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($versionList as $kVer=>$vVer){
							if($aContent['version']){
								$selVer = (in_array($vVer->tag_id,$aContent['version']))?"selected='selected'":"";
							}
							echo '<option value="'.$vVer->tag_id.'" '.$selVer.' >'.ucwords($vVer->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Genre</label>
			  <select name="genre[]" id="genre"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($genreList as $kGenre=>$vGenre){
							if($aContent['genre']){
								$selGenre = (in_array($vGenre->tag_id,$aContent['genre']))?"selected='selected'":"";
							}
							echo '<option value="'.$vGenre->tag_id.'" '.$selGenre.' >'.ucwords($vGenre->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Mood</label>
			  <select name="mood[]" id="mood"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($moodList as $kMood=>$vMood){
							if($aContent['mood']){
								$selMood = (in_array($vMood->tag_id,$aContent['mood']))?"selected='selected'":"";
							}
							echo '<option value="'.$vMood->tag_id.'" '.$selMood.' >'.ucwords($vMood->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Relationship</label>
			  <select name="relationship[]" id="relationship"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($relationshipList as $kRelationship=>$vRelationship){
							if($aContent['relationship']){
								$selRelationship = (in_array($vRelationship->tag_id,$aContent['relationship']))?"selected='selected'":"";
							}
							echo '<option value="'.$vRelationship->tag_id.'" '.$selRelationship.' >'.ucwords($vRelationship->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
		</div>
		<!--<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Raag</label>
			  <select name="raag[]" id="raag"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						/*foreach($raagList as $kRaag=>$vRaag){
							if($aContent['raag']){
								$selRaag = (in_array($vRaag->tag_id,$aContent['raag']))?"selected='selected'":"";
							}
							echo '<option value="'.$vRaag->tag_id.'" '.$selRaag.' >'.ucwords($vRaag->tag_name).'</option>';
						}*/
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Taal</label>
			  <select name="taal[]" id="taal"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						/*foreach($taalList as $kTaal=>$vTaal){
							if($aContent['taal']){
								$selTaal = (in_array($vTaal->tag_id,$aContent['taal']))?"selected='selected'":"";
							}
							echo '<option value="'.$vTaal->tag_id.'" '.$selTaal.' >'.ucwords($vTaal->tag_name).'</option>';
						}*/
					?>
			  </select>
			</div>
		</div>-->
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Time of Day</label>
			  <select name="timeofday[]" id="timeofday"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($timeofdayList as $kTimeofday=>$vTimeofday){
							if($aContent['timeofday']){
								$selTimeofday = (in_array($vTimeofday->tag_id,$aContent['timeofday']))?"selected='selected'":"";
							}
							echo '<option value="'.$vTimeofday->tag_id.'" '.$selTimeofday.' >'.ucwords($vTimeofday->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Religion</label>
			  <select name="religion[]" id="religion"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($religionList as $kReligion=>$vReligion){
							if($aContent['religion']){
								$selReligion = (in_array($vReligion->tag_id,$aContent['religion']))?"selected='selected'":"";
							}
							echo '<option value="'.$vReligion->tag_id.'" '.$selReligion.' >'.ucwords($vReligion->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Deity or Saint</label>
			  <select name="saint[]" id="saint"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($saintList as $kSaint=>$vSaint){
							if($aContent['saint']){
								$selSaint = (in_array($vSaint->tag_id,$aContent['saint']))?"selected='selected'":"";
							}
							echo '<option value="'.$vSaint->tag_id.'" '.$selSaint.' >'.ucwords($vSaint->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Instrument</label>
			  <select name="instrument[]" id="instrument"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($instrumentList as $kInstrument=>$vInstrument){
							if($aContent['instrument']){
								$selInstrument = (in_array($vInstrument->tag_id,$aContent['instrument']))?"selected='selected'":"";
							}
							echo '<option value="'.$vInstrument->tag_id.'" '.$selInstrument.' >'.ucwords($vInstrument->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Festival</label>
			  <select name="festival[]" id="festival"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($festivalList as $kFestival=>$vFestival){
							if($aContent['festival']){
								$selFestival = (in_array($vFestival->tag_id,$aContent['festival']))?"selected='selected'":"";
							}
							echo '<option value="'.$vFestival->tag_id.'" '.$selFestival.' >'.ucwords($vFestival->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Occasion</label>
			  <select name="occasion[]" id="occasion"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($occasionList as $kOccasion=>$vOccasion){
							if($aContent['occasion']){
								$selOccasion = (in_array($vOccasion->tag_id,$aContent['occasion']))?"selected='selected'":"";
							}
							echo '<option value="'.$vOccasion->tag_id.'" '.$selOccasion.' >'.ucwords($vOccasion->tag_name).'</option>';
						}
					?>
			  </select>
			</div>
		</div>
		<div class="input">
		  <label for="select">Region</label>
		  <select name="region" id="region">
		  	<option value="">Select Region</option>
			<?php 
					foreach($regionList as $kRegion=>$vRegion){
						if($aContent['region']){
							$selRegion = ($vRegion->region_id==$aContent['region'])?"selected='selected'":"";
						}
						echo '<option value="'.$vRegion->region_id.'" '.$selRegion.' >'.ucwords($vRegion->region_name).'</option>';
					}
				?>
		  </select>
		</div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/video?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>
