<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#eventFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<script type="text/javascript">
		//tinymce.PluginManager.load('moxiemanager', '<?php echo JSPATH; ?>tinymce/plugins/moxiemanager/plugin.min.js');
		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"//moxiemanager
			],
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link "
		});

</script>

<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png"  alt="" width="40" height="40" />Calendar Event</h1>
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
    <div class="title">Event Name</div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" id="eventFrm" name="eventFrm">
	
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input4">Event Name<span class='mandatory'>*</span></label>
            <input type="text" id="eventName" name="eventName" value="<?=$aContent['eventName']?>" class="validate[required]"/>
          </div>     
     <div class="input FL PR30">
            <label for="input1">Event Type<span class='mandatory'>*</span> </label>
			<select name="eventType" id="eventType" class="validate[required]">
				<option value="">Select Event</option>
			    <?php 
				
					foreach($calendar_event as $type_id=>$type_name){
					
						$selStr = ($aContent['eventType']==$type_id)?"selected='selected'":"";
						echo '<option value="'.$type_id.'" '.$selStr.' >'.ucwords($type_name).'</option>';
					}
				?>
            </select>
          </div>
		  <div class="input FL PR30">
            <label for="input">Start Date<span class='mandatory'>*</span> :</label>
            <input type="text" id="srcSrtDate" name="srcSrtDate" value="<?=$aContent['srcSrtDate']?>" class="datepicker validate[required]"/>
          </div>
		  <div class="input FL PR30">
            <label for="input">End Date :</label>
            <input type="text" id="srcEndDate" name="srcEndDate" value="<?=$aContent['srcEndDate']?>" class="datepicker"/>
          </div>
			
		  <div class="input FL  PR30">
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
<div class="clearfix" >		
			<div class="input FL50">
            <label for="input1">Artist</label>
            <input type="text" name="artistsrch" id="artistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Artist" href="javascript:void();" onclick="if(document.getElementById('artistsrch').value != 'Search') {cms.srchartist(document.getElementById('artistsrch'), 'artist', ''); document.getElementById('artistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Artist</a> Note : Double click to add Artist
            <select  name="artist[]" id="artist" ondblclick="cms.getDetails(this,'artistHidden','artistbox','artist');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
              <?php
										$artistBox="";
										$artistHidden="";
										if($aContent['artistId']){
											$artistHidden=$aContent['artistId'].",";;
											if($aContent['artistNameArr']){
												foreach($aContent['artistNameArr'] as $kStar=>$vStar){
													$artistBox .= "<span id='artist_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','artistHidden','artist')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
			Note : Double click on selected to remove 
            <input type="hidden" name="artistHidden" id="artistHidden" value=",<?=$artistHidden?>" />
            <input type="hidden" name="artistHiddensData" id="artistHiddensData" value="<?=$aContent['artistNameStr']?>" />
            <div class="field-content MT10" id="artistbox">
              <?=$artistBox?>
            </div>
			</div>
			<div class="input FL50">
            <label for="input1">Song Playlist</label>
            <input type="text" name="playlistsrch" id="playlistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Playlist" href="javascript:void();" onclick="if(document.getElementById('playlistsrch').value != 'Search') {cms.srchartist(document.getElementById('playlistsrch'), 'playlist', 'playlist'); document.getElementById('playlistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Playlist</a> Note : Double click to add Playlist
            <select  name="playlist[]" id="playlist" ondblclick="cms.getDetails(this,'playlistHidden','playlistbox','playlist');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
              <?php
										$playlistBox="";
										$playlistHidden="";
										if($aContent['playlistId']){
											$playlistHidden=$aContent['playlistId'].",";;
											if($aContent['playlistNameArr']){
												foreach($aContent['playlistNameArr'] as $kStar=>$vStar){
													$playlistBox .= "<span id='playlist_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','playlistHidden','playlist')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
			Note : Double click on selected to remove 
            <input type="hidden" name="playlistHidden" id="playlistHidden" value=",<?=$playlistHidden?>" />
            <input type="hidden" name="playlistHiddensData" id="playlistHiddensData" value="<?=$aContent['playlistNameStr']?>" />
            <div class="field-content MT10" id="playlistbox">
              <?=$playlistBox?>
            </div>
			</div>
		</div>			
<div class="clearfix" >
<div class="input FL50">
            <label for="input1">Video Playlist</label>
            <input type="text" name="videoplaylistsrch" id="videoplaylistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Playlist" href="javascript:void();" onclick="if(document.getElementById('videoplaylistsrch').value != 'Search') {cms.srchartist(document.getElementById('videoplaylistsrch'), 'videoplaylist', 'videoplaylist'); document.getElementById('videoplaylistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Playlist</a> Note : Double click to add Playlist
            <select  name="videoplaylist[]" id="videoplaylist" ondblclick="cms.getDetails(this,'videoplaylistHidden','videoplaylistbox','videoplaylist');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
              <?php
										$videoplaylistBox="";
										$videoplaylistHidden="";
										if($aContent['videoplaylistId']){
											$videoplaylistHidden=$aContent['videoplaylistId'].",";;
											if($aContent['videoplaylistNameArr']){
												foreach($aContent['videoplaylistNameArr'] as $kStar=>$vStar){
													$videoplaylistBox .= "<span id='videoplaylist_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','videoplaylistHidden','videoplaylist')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
			Note : Double click on selected to remove 
            <input type="hidden" name="videoplaylistHidden" id="videoplaylistHidden" value=",<?=$videoplaylistHidden?>" />
            <input type="hidden" name="videoplaylistHiddensData" id="videoplaylistHiddensData" value="<?=$aContent['videoplaylistNameStr']?>" />
            <div class="field-content MT10" id="videoplaylistbox">
              <?=$videoplaylistBox?>
            </div>
			</div>
			<div class="input FL50">
            <label for="input1">Image Playlist</label>
            <input type="text" name="imageplaylistsrch" id="imageplaylistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Playlist" href="javascript:void();" onclick="if(document.getElementById('imageplaylistsrch').value != 'Search') {cms.srchartist(document.getElementById('imageplaylistsrch'), 'imageplaylist', 'imageplaylist'); document.getElementById('imageplaylistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Playlist</a> Note : Double click to add Playlist
            <select  name="imageplaylist[]" id="imageplaylist" ondblclick="cms.getDetails(this,'imageplaylistHidden','imageplaylistbox','imageplaylist');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
              <?php
										$imageplaylistBox="";
										$imageplaylistHidden="";
										if($aContent['imageplaylistId']){
											$imageplaylistHidden=$aContent['imageplaylistId'].",";;
											if($aContent['imageplaylistNameArr']){
												foreach($aContent['imageplaylistNameArr'] as $kStar=>$vStar){
													$imageplaylistBox .= "<span id='imageplaylist_".$kStar."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kStar."','imageplaylistHidden','imageplaylist')\" title='Double Click to Remove' >".$vStar."</a><br></span>";
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
			Note : Double click on selected to remove 
            <input type="hidden" name="imageplaylistHidden" id="imageplaylistHidden" value=",<?=$imageplaylistHidden?>" />
            <input type="hidden" name="imageplaylistHiddensData" id="imageplaylistHiddensData" value="<?=$aContent['imageplaylistNameStr']?>" />
            <div class="field-content MT10" id="imageplaylistbox">
              <?=$imageplaylistBox?>
            </div>
			</div>
</div>  
<div class="input">
            <label for="input1">Event Desc</label>
            <TEXTAREA type="text" id="eventDesc" name="eventDesc" maxlength="160"><?php echo urldecode(trim($aContent['eventDesc']));?></TEXTAREA>
</div>
		     
	   <div class="submit">
            <input type="submit" value="Submit" name="submitBtn" />
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/event?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>