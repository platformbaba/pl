<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#imageFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Wallpaper/Animation" />Wallpaper/Animation</h1>
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
    <div class="title">Add Wallpaper/Animation<div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" id="imageFrm" name="imageFrm">
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Album/Collection <span class='mandatory'>*</span></label>
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
			Note : Double click on selected to remove 
			<input type="hidden" name="albumHidden" id="albumHidden" value=",<?=$albumHidden?>"/>
			<input type="hidden" name="albumHiddensData" id="albumHiddensData" value="<?=$aContent['albumNameStr']?>" class="validate[required]" data-errormessage="*Please select album." data-prompt-position="topLeft:500,-60;"/>
			<div class="field-content MT10" id="albumbox">
			  <?=$albumBox?>
			</div>
			</div>
		  
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
        </div>
		
		<div class="clearfix">
          <div class="input FL50">
            <label for="input4">Image Name <span class='mandatory'>*</span></label>
            <input type="text" id="imageName" name="imageName" value="<?=$aContent['imageName']?>" class="validate[required]"/>
          </div>
          <div class="input FL50">
            <label for="input1">Image Type <span class='mandatory'>*</span></label>
			<select name="imageType" id="select" class="validate[required]">
			<option value="">Select Image Type</option>
                <?php
					foreach($image_type as $type_name=>$type_id){
						$selStr = (($aContent['imageType']&$type_id)==$type_id)?"selected='selected'":"";
						echo '<option value="'.$type_id.'" '.$selStr.' >'.$type_name.'</option>';
					}
				?>
            </select>
          </div>
		  <div class="input FL50">
            <label for="input1">Image Category <span class='mandatory'>*</span></label>
			<select name="imageCategory" id="select" class="validate[required]">
			<option value="">Select Image Category</option>
                <?php
					foreach($imageCategory as $tags){
						$selStr = ($aContent['imageCategory']==$tags->tag_id)?"selected='selected'":"";
						echo '<option value="'.$tags->tag_id.'" '.$selStr.' >'.$tags->tag_name.'</option>';
					}
				?>
            </select>
          </div>
        </div>
		<div class="clearfix">	
			<div class="input FL50">
				<label for="input1">Image Desc</label>
				<TEXTAREA type="text" id="imageDesc" name="imageDesc" rows="8" cols="10" style="width: 475px; height: 140px;" ><?=$aContent['imageDesc']?></TEXTAREA>
			</div>
			<div class="input FL50">
			<label for="input1">Song</label>
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
			Note : Double click on selected to remove 
			<input type="hidden" name="songHidden" id="songHidden" value=",<?=$songHidden?>" />
			<input type="hidden" name="songHiddensData" id="songHiddensData" value="<?=$aContent['songNameStr']?>" />
			<div class="field-content" id="songbox">
			  <?=$songBox?>
			</div>
		</div>
		</div>
		<div class="input">
            <label for="file">Upload a file</label>
            <input type="file" id="file" name="pic" />
			<?php 
				if( !empty($data['aContent']['imageFile']) ){
			?>
				<div style="width:140px;" class="picture MT10"><a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['imageFile']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['imageFile']));?>" style="max-height:100px; max-width:100px;"></a></div>
				<input type="hidden" name="oPic" value="<?=$data['aContent']['imageFile']?>" />
			<?php	
				}
			
			?>
        </div>
	   <div class="submit MT10">
            <input type="submit" value="Submit" name="submitBtn" />
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/image?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>