<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#textFrm").validationEngine({
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
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Text</h1>
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
    <div class="title">Add Text<div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" id="textFrm" name="textFrm">
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
			Note : Double click on selected to remove<br>
			<input type="hidden" name="albumHidden" id="albumHidden" value=",<?=$albumHidden?>" />
			<input type="hidden" name="albumHiddensData" id="albumHiddensData" value="<?=$aContent['albumNameStr']?>" class="validate[required]" data-errormessage="*Please select album." data-prompt-position="topLeft:420,10;" />
			<div class="field-content" id="albumbox">
			  <?=$albumBox?>
			</div>          </div>
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
			Note : Double click on selected to remove<br>
            <input type="hidden" name="artistHidden" id="artistHidden" value=",<?=$artistHidden?>" />
            <input type="hidden" name="artistHiddensData" id="artistHiddensData" value="<?=$aContent['artistNameStr']?>" />
            <div class="field-content" id="artistbox">
              <?=$artistBox?>
            </div>
          </div>          
        </div>

        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input4">Text Title <span class='mandatory'>*</span></label>
            <input type="text" id="textName" name="textName" value="<?=$aContent['textName']?>" class="validate[required]"/>
          </div>     
     <div class="input FL PR30">
            <label for="input1">Text Type <span class='mandatory'>*</span></label>
			<select name="textType" id="select" class="validate[required]">
			<option value="">Select Text Type</option>
			    <?php
					foreach($text_type as $type_name=>$type_id){
						$selStr = (($aContent['textType']&$type_id)==$type_id)?"selected='selected'":"";
						echo '<option value="'.$type_id.'" '.$selStr.' >'.ucwords($type_name).'</option>';
					}
				?>
            </select>
          </div>
			
		  <div class="input FL  PR30">
            <label for="select">Language <span class='mandatory'>*</span></label>
            <select name="languageIds" id="select" class="validate[required]">
              <option value="">Select Language</option>
              <?php 
			 
			 	$aContent['languageIds'];
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
		<div class="input FL">
            <label for="file">Upload here</label>
            <input type="file" id="file" name="txt_file" id="txt_file" />
				<?php
				if( !empty($aContent['textFile']) ){
			?>
					<input type="hidden" name="otxt_file" value="<?=$data['aContent']['textFile']?>" /><br>
           
			<?php	
				}
			?>
			<br>(pdf | image | text | doc | docx)
        </div>
		<?php
		  $file = explode("/",$data['aContent']['textFile']);
		?>
		<div class="input FL30" style="padding-top:40px;">	
			 &nbsp;&nbsp;&nbsp;<a href="<?=MEDIA_SITEPATH_DOC.$data['aContent']['textFile'];?>" target="_blank"><b><?=$file[3];?></b></a>
		</div>
		</div>	
		<div class="input">
            <label for="input1">Text Desc</label>
            <TEXTAREA type="text" id="textDesc" name="textDesc" maxlength="160"><?php echo urldecode(trim($aContent['textDesc']));?></TEXTAREA>
        </div>
	   <div class="submit">
            <input type="submit" value="Submit" name="submitBtn" />
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/text?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>