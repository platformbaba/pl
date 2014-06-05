<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#songFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
	/*function checkHELLO(field, rules, i, options){
		alert("here");
	}*/
</script>
<style>
.uploadifyQueueItem .cancel { display:none; }
</style>
<script type="text/javascript">
$(function(){
      $('#uploadfile').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=song'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.wav',
 	 	'fileDesc'    : 'Audio Files',
		'removeCompleted' : false,
		'scriptData'	 : {'isrc' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile').uploadifySettings('scriptData',{'isrc' : $('#isrc').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
			$('.uploadifyQueue').show();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#audioFilePath').val("");
			$('#FileName').html("").show();
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
			response = eval('('+response+')');
			//console.log(fileObj);
			//console.log(data);
			//console.log(response);
			if(response.status == 'ERROR'){
				alert(response.msg);
				$('.uploadifyQueue').hide();
			}else if(response.status == 'OK'){
				$('#audioFilePath').val(response.filepath);
				$('#FileName').html('<audio controls><source src="<?=MEDIA_SITEPATH_TEMP?>'+response.filepath+'" type="audio/mpeg"></audio> ').show();
				$('#actions-bar').show();
				//$('.uploadifyQueue').hide();
			}
    	},
		'onError'     : function (event,ID,fileObj,errorObj) {
		  	alert(errorObj.type + ' Error: ' + errorObj.info);
			return false;
		}
      });
});

$(function(){
      $('#uploadfile_mp4').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=song_mp4'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.mp4',
 	 	'fileDesc'    : 'Audio Files',
		'removeCompleted' : false,
		'scriptData'	 : {'isrc' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile_mp4').uploadifySettings('scriptData',{'isrc' : $('#isrc').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
			$('.uploadifyQueue').show();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#audioFilePath_mp4').val("");
			$('#FileName_mp4').html("").show();
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
			response = eval('('+response+')');
			//console.log(fileObj);
			//console.log(data);
			//console.log(response);
			if(response.status == 'ERROR'){
				alert(response.msg);
				$('.uploadifyQueue').hide();
			}else if(response.status == 'OK'){
				$('#audioFilePath_mp4').val(response.filepath);
				$('#FileName_mp4').html('<a href="<?=MEDIA_SITEPATH_TEMP?>'+response.filepath+'" target="_blank">'+response.filename+'</a>').show();
				$('#actions-bar').show();
				//$('.uploadifyQueue').hide();
			}
    	},
		'onError'     : function (event,ID,fileObj,errorObj) {
		  	alert(errorObj.type + ' Error: ' + errorObj.info);
			return false;
		}
      });
});

$(function(){
      $('#uploadfile_mp3').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=song_mp3'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.mp3',
 	 	'fileDesc'    : 'Audio Files',
		'removeCompleted' : false,
		'scriptData'	 : {'isrc' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile_mp3').uploadifySettings('scriptData',{'isrc' : $('#isrc').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
			$('.uploadifyQueue').show();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#audioFilePath_mp3').val("");
			$('#FileName_mp3').html("").show();
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
			response = eval('('+response+')');
			//console.log(fileObj);
			//console.log(data);
			//console.log(response);
			if(response.status == 'ERROR'){
				alert(response.msg);
				$('.uploadifyQueue').hide();
			}else if(response.status == 'OK'){
				$('#audioFilePath_mp3').val(response.filepath);
				$('#FileName_mp3').html('<a href="<?=MEDIA_SITEPATH_TEMP?>'+response.filepath+'" target="_blank">'+response.filename+'</a>').show();
				$('#actions-bar').show();
				//$('.uploadifyQueue').hide();
			}
    	},
		'onError'     : function (event,ID,fileObj,errorObj) {
		  	alert(errorObj.type + ' Error: ' + errorObj.info);
			return false;
		}
      });
});

function startupload(){
	alert('start');
	$('#uploadfile').uploadify('upload');
	$('#uploadfile_mp4').uploadify('upload');
	$('#uploadfile_mp3').uploadify('upload');
}
</script>
<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Song" />Song</h1>
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
      <?=ucfirst($_GET['action'])?>Song <div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" name="songFrm" id="songFrm" >
       <div class="clearfix">
        <div class="input FL50">
          <label for="input1">Song Name <span class='mandatory'>*</span></label>
          <input type="text" id="songName" name="songName" value="<?=$aContent['songName']?>" class="validate[required]"  />
        </div>
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
			<input type="hidden" name="albumHidden" id="albumHidden" value=",<?=$albumHidden?>"  />
			<input type="hidden" name="albumHiddensData" id="albumHiddensData" value="<?=$aContent['albumNameStr']?>" class="validate[required]" data-errormessage="*Please select album." data-prompt-position="topLeft:1005,-1553;" />
			<div class="field-content" id="albumbox">
			  <?=$albumBox?>
			</div>
		</div>
		</div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">ISRC <span class='mandatory'>*</span></label>
            <input type="text" id="isrc" name="isrc" value="<?=$aContent['isrc']?>" class="validate[required]"/>
			(International Standard Recording Code)
          </div>
          <div class="input FL50">
            <label for="select">Language <span class='mandatory'>*</span></label>
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
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input4">Release Date <span class='mandatory'>*</span></label>
            <input type="text" name="releaseDate" class="datepicker validate[required]" id="releaseDate" value="<?=$aContent['releaseDate']?>"/>
          </div>
          <div class="input FL50">
            <label for="input1">Track/Clip Duration (in sec) <span class='mandatory'>*</span></label>
            <input type="text" id="songDuration" name="songDuration" value="<?=$aContent['songDuration']?>" class="validate[required]"/>
          </div>
        </div>
		<div class="clearfix">
			<div class="input FL50">
				<label for="input1">Song Tempo</label>
				<input type="text" id="songTempo" name="songTempo" value="<?=$aContent['songTempo']?>" />
			</div>
			<div class="input FL50">
				<label for="input1">Subject of Parody</label>
				<input type="text" id="subjectParody" name="subjectParody" value="<?=$aContent['subjectParody']?>" />
			</div>
		</div>
        <div class="clearfix">
        <div class="input FL50">
            <label for="input1">Upload Audio File (.wav)</label>
			WAV: <input type="text" name="uploadfile" id="uploadfile" value="" />
			<input	 type="hidden" id="audioFilePath" name="audioFilePath" value="" />
			<p id="FileName">
				<?php 
				$file_wav = MEDIA_SERVERPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"wav");
				if(file_exists($file_wav)){?>
					<a href="<?=MEDIA_SITEPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"wav")?>" target="_blank">Download File (.wav)</a> &nbsp;&nbsp;&nbsp;&nbsp;
				<?php }?>
			</p>
			<!--<br/>
			MP4: <input type="text" name="uploadfile_mp4" id="uploadfile_mp4" value="" />
			<input type="hidden" id="audioFilePath_mp4" name="audioFilePath_mp4" value="" />-->
			<!--<p id="FileName_mp4">
				<?php 
				#$file_mp4 = MEDIA_SEVERPATH.'songs/edits/mp4/full/'.TOOLS::getSongPath($aContent['isrc']).$aContent['isrc'].'.mp4';
				$file_mp4 = MEDIA_SERVERPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"mp4");
				#if($aContent['audioFilePath'] && file_exists($file_mp4)){?>
				<?php if(is_file($file_mp4)){?>
				<a href="<?php echo MEDIA_SITEPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"mp4"); ?>" target="_blank">Download File (.mp4)</a>
				<?php }?>
			</p>-->
			<!--<br/>
			MP3: <input type="text" name="uploadfile_mp3" id="uploadfile_mp3" value="" />
			<input type="hidden" id="audioFilePath_mp3" name="audioFilePath_mp3" value="" />-->
			<!--<p id="FileName_mp3">
				<?php 
				$file_mp3 = MEDIA_SERVERPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"mp3");
				#if($aContent['audioFilePath'] && file_exists($file_mp4)){?>
				<?php if(is_file($file_mp3)){?>
				<a href="<?php echo MEDIA_SITEPATH_SONGRAW.tools::getSongPathByIsrc($aContent['isrc'],"mp3"); ?>" target="_blank">Download File (.mp3)</a>
				<?php }?>
			</p>-->
        </div>
		<div class="input FL50">
				<a href="<?=SITEPATH?>explorer?action=view&isPlane=1&ldir=<?=MEDIA_SERVERPATH_TEMPFTP?>&dir=<?=MEDIA_SERVERPATH_TEMPFTP?>" class="fancybox fancybox.iframe button" title="BROWSE EXISTING FILES">BROWSE EXISTING FILES</a>
				<br/><br />	
				<span id="rawFile"></span>
				<input type="hidden" name="rawFileVal" id="rawFileVal" value=""	 />
		</div>
		</div>
        
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Singer <span class='mandatory'>*</span></label>
            <input type="text" name="singersrch" id="singersrch" class="full-width autosuggestStar validate[required]" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
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
            <input type="hidden" name="singerHiddensData" id="singerHiddensData" value="<?=$aContent['singerNameStr']?>" class="validate[required]" data-errormessage="*Please select singer." data-prompt-position="topLeft:510,-908;"/>
            <div class="field-content" id="singerbox">
              <?=$singerBox?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input1">Music Director <span class='mandatory'>*</span></label>
            <input type="text" name="mdirectorsrch" id="mdirectorsrch" class="full-width autosuggestDir validate[required]" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Music Director" href="javascript:void();" onclick="if(document.getElementById('mdirectorsrch').value != 'Search') {cms.srchartist(document.getElementById('mdirectorsrch'), 'mdirector', 'Music Director'); document.getElementById('mdirectorsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Music Director</a> Note : Double click to add Music Director
            <select  name="mdirector[]" id="mdirector" ondblclick="cms.getDetails(this,'mdirectorHidden','mdirectorbox','mdirector');" style="width:250px; height:100px;"  size="10" multiple="multiple">
              <?php
										$mdirectorBox="";
										$mdirectorHidden="";
										if($aContent['mdirectorId']){
											$mdirectorHidden=$aContent['mdirectorId'].",";
											if($aContent['mdirectorNameArr']){
												foreach($aContent['mdirectorNameArr'] as $kDir=>$vDir){
											$mdirectorBox .= "<span id='mdirector_".$kDir."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kDir."','mdirectorHidden','mdirector')\" title='Double Click to Remove' >".$vDir."</a><br></span>";
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
            <input type="hidden" name="mdirectorHidden" id="mdirectorHidden" value=",<?=$mdirectorHidden?>" />
            <input type="hidden" name="mdirectorHiddensData" id="mdirectorHiddensData" value="<?=$aContent['mdirectorNameStr']?>" />
            <div class="field-content" id="mdirectorbox">
              <?=$mdirectorBox?>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Lyricist <span class='mandatory'>*</span></label>
            <input type="text" name="lyricistsrch" id="lyricistsrch" class="full-width autosuggestStar validate[required]" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Lyricist" href="javascript:void();" onclick="if(document.getElementById('lyricistsrch').value != 'Search') {cms.srchartist(document.getElementById('lyricistsrch'), 'lyricist', 'Lyricist'); document.getElementById('lyricistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Lyricist</a> Note : Double click to add Lyricist
            <select  name="lyricist[]" id="lyricist" ondblclick="cms.getDetails(this,'lyricistHidden','lyricistbox','lyricist');" style="width:250px; height:100px;"  size="10" multiple="multiple">
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
													$poetBox .= "<span id='poet_".$kPoet."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kPoet."','poetHidden','poet')\" title='Double Click to Remove' >".$vPoet."</a><br></span>";*/
											?>
              <option value="<?=$kPoet;?>" selected="selected">
              <?=$vPoet;?>
              </option>
              <?php
									/*	}
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
            <label for="input1">Starcast</label>
            <input type="text" name="starcastsrch" id="starcastsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Starcast" href="javascript:void();" onclick="if(document.getElementById('starcastsrch').value != 'Search') {cms.srchartist(document.getElementById('starcastsrch'), 'starcast', 'Starcast'); document.getElementById('starcastsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Starcast</a> Note : Double click to add Starcast
            <select  name="starcast[]" id="starcast" ondblclick="cms.getDetails(this,'starcastHidden','starcastbox','starcast');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
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
            <input type="hidden" name="starcastHiddensData" id="starcastHiddensData" value="<?=$aContent['starcastNameStr']?>" />
            <div class="field-content" id="starcastbox">
              <?=$starcastBox?>
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
			  <label for="select">Version <span class='mandatory'>*</span></label>
			  <select name="version[]" id="version"  multiple="multiple" size="10" style="width:250px; height:100px;" class="validate[required]">
				<?php 
						foreach($versionList as $kVer=>$vVer){
							if($aContent['version']){
								if(in_array($vVer->tag_id,$aContent['version'])){
									echo '<option value="'.$vVer->tag_id.'" selected="selected" >'.ucwords($vVer->tag_name).'</option>';
								}
							}
						}
						foreach($versionList as $kVer=>$vVer){
								if(!in_array($vVer->tag_id,$aContent['version'])){
									echo '<option value="'.$vVer->tag_id.'">'.ucwords($vVer->tag_name).'</option>';
								}
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Genre <span class='mandatory'>*</span></label>
			  <select name="genre[]" id="genre"  multiple="multiple" size="10" style="width:250px; height:100px;" class="validate[required]">
				<?php 
						foreach($genreList as $kGenre=>$vGenre){
							if($aContent['genre']){
								if(in_array($vGenre->tag_id,$aContent['genre'])){
									echo '<option value="'.$vGenre->tag_id.'" '.$selGenre.' selected="selected" >'.ucwords($vGenre->tag_name).'</option>';
								}
							}
						}
						foreach($genreList as $kGenre=>$vGenre){
								if(!in_array($vGenre->tag_id,$aContent['genre'])){
									echo '<option value="'.$vGenre->tag_id.'" >'.ucwords($vGenre->tag_name).'</option>';							
								}
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Mood <span class='mandatory'>*</span></label>
			  <select name="mood[]" id="mood"  multiple="multiple" size="10" style="width:250px; height:100px;" class="validate[required]">
				<?php 
						foreach($moodList as $kMood=>$vMood){
							if($aContent['mood']){
								if(in_array($vMood->tag_id,$aContent['mood'])){
									echo '<option value="'.$vMood->tag_id.'" selected="selected" >'.ucwords($vMood->tag_name).'</option>';
								}
							}
						}
						foreach($moodList as $kMood=>$vMood){
								if(!in_array($vMood->tag_id,$aContent['mood'])){
									echo '<option value="'.$vMood->tag_id.'">'.ucwords($vMood->tag_name).'</option>';
								}
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
								if(in_array($vRelationship->tag_id,$aContent['relationship'])){
									echo '<option value="'.$vRelationship->tag_id.'" selected="selected" >'.ucwords($vRelationship->tag_name).'</option>';
								}
							}
						}
						foreach($relationshipList as $kRelationship=>$vRelationship){
								if(!in_array($vRelationship->tag_id,$aContent['relationship'])){
									echo '<option value="'.$vRelationship->tag_id.'" >'.ucwords($vRelationship->tag_name).'</option>';
								}
						}
				?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Raag</label>
			  <select name="raag[]" id="raag"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($raagList as $kRaag=>$vRaag){
							if($aContent['raag']){
								if(in_array($vRaag->tag_id,$aContent['raag'])){
									echo '<option value="'.$vRaag->tag_id.'" selected="selected" >'.ucwords($vRaag->tag_name).'</option>';
								}
							}
						}
						foreach($raagList as $kRaag=>$vRaag){
								if(!in_array($vRaag->tag_id,$aContent['raag'])){
									echo '<option value="'.$vRaag->tag_id.'" >'.ucwords($vRaag->tag_name).'</option>';
								}
						}
					?>
			  </select>
			</div>
			<div class="input FL50">
			  <label for="select">Taal</label>
			  <select name="taal[]" id="taal"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($taalList as $kTaal=>$vTaal){
							if($aContent['taal']){
								if(in_array($vTaal->tag_id,$aContent['taal'])){
									echo '<option value="'.$vTaal->tag_id.'" selected="selected" >'.ucwords($vTaal->tag_name).'</option>';
								}
							}
						}
						foreach($taalList as $kTaal=>$vTaal){
								if(!in_array($vTaal->tag_id,$aContent['taal'])){
									echo '<option value="'.$vTaal->tag_id.'" >'.ucwords($vTaal->tag_name).'</option>';
								}
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
			  <label for="select">Time of Day</label>
			  <select name="timeofday[]" id="timeofday"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
						foreach($timeofdayList as $kTimeofday=>$vTimeofday){
							if($aContent['timeofday']){
								if(in_array($vTimeofday->tag_id,$aContent['timeofday'])){
									echo '<option value="'.$vTimeofday->tag_id.'" selected="selected" >'.ucwords($vTimeofday->tag_name).'</option>';
								}
							}
						}
						foreach($timeofdayList as $kTimeofday=>$vTimeofday){
								if(!in_array($vTimeofday->tag_id,$aContent['timeofday'])){
									echo '<option value="'.$vTimeofday->tag_id.'" >'.ucwords($vTimeofday->tag_name).'</option>';
								}
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
								if(in_array($vReligion->tag_id,$aContent['religion'])){
									echo '<option value="'.$vReligion->tag_id.'" selected="selected" >'.ucwords($vReligion->tag_name).'</option>';
								}
							}
						}
						foreach($religionList as $kReligion=>$vReligion){
								if(!in_array($vReligion->tag_id,$aContent['religion'])){
									echo '<option value="'.$vReligion->tag_id.'" >'.ucwords($vReligion->tag_name).'</option>';
								}
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
								if(in_array($vSaint->tag_id,$aContent['saint'])){
									echo '<option value="'.$vSaint->tag_id.'" selected="selected" >'.ucwords($vSaint->tag_name).'</option>';
								}
							}
						}
						foreach($saintList as $kSaint=>$vSaint){
								if(!in_array($vSaint->tag_id,$aContent['saint'])){
									echo '<option value="'.$vSaint->tag_id.'" >'.ucwords($vSaint->tag_name).'</option>';
								}
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
								if(in_array($vInstrument->tag_id,$aContent['instrument'])){
									echo '<option value="'.$vInstrument->tag_id.'" selected="selected" >'.ucwords($vInstrument->tag_name).'</option>';
								}
							}
						}
						foreach($instrumentList as $kInstrument=>$vInstrument){
								if(!in_array($vInstrument->tag_id,$aContent['instrument'])){
									echo '<option value="'.$vInstrument->tag_id.'">'.ucwords($vInstrument->tag_name).'</option>';
								}
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
								if(in_array($vFestival->tag_id,$aContent['festival'])){
									echo '<option value="'.$vFestival->tag_id.'" selected="selected" >'.ucwords($vFestival->tag_name).'</option>';
								}
							}
						}
						foreach($festivalList as $kFestival=>$vFestival){
								if(!in_array($vFestival->tag_id,$aContent['festival'])){
									echo '<option value="'.$vFestival->tag_id.'"  >'.ucwords($vFestival->tag_name).'</option>';
								}
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
								if(in_array($vOccasion->tag_id,$aContent['occasion'])){
									echo '<option value="'.$vOccasion->tag_id.'" selected="selected" >'.ucwords($vOccasion->tag_name).'</option>';
								}
							}
						}
						foreach($occasionList as $kOccasion=>$vOccasion){
								if(!in_array($vOccasion->tag_id,$aContent['occasion'])){
									echo '<option value="'.$vOccasion->tag_id.'">'.ucwords($vOccasion->tag_name).'</option>';
								}
						}
					?>
			  </select>
			</div>
		</div>
		<div class="clearfix">
		<div class="input FL50">
		  <label for="select">Region</label>
		  <select name="region" id="region" >
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
		<div class="input FL50">
            <label for="input1">Grade</label>
			<select name='grade' id="grade" >
				<option value="">Select Grade</option>
				<?php
					foreach($aConfig['grade'] as $kkk=>$vvv ){
							$selectstr = '';
							if( $aContent['grade']==$vvv ){ $selectstr='selected'; }
						echo "<option value='".$vvv."' ".$selectstr.">".$vvv."</option>";
					}
				?>
			</select><br /><br />
			(UA,U,A, R etc. Completely based on  Production Quality and Potential Revenue.)
        </div>
		</div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn" />
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/song?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>