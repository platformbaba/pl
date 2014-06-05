<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Pack</h1>
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
    <div class="title">Add Pack</div>
    <div class="content">
	<form method="post">
              
		<div class="clearfix">
          <div class="input FL50">
            <label for="input1">Pack Name <span class='mandatory'>*</span></label> 
            <input type="text" id="packName" name="packName" value="<?=$aContent['packName']?>" />
          </div>
          <div class="input FL50">
            <label for="select">Category<span class='mandatory'>*</span></label>
            <select name="catIds" id="select" >
              <option value="">Select Category</option>
              <?php 
						foreach($catList as $kL=>$vL){
							if($aContent['catIds']){
								$selStr = ($vL->tag_id==$aContent['catIds'])?"selected='selected'":"";
							}
							echo '<option value="'.$vL->tag_id.'" '.$selStr.' >'.ucwords($vL->tag_name).'</option>';
						}
					?>
            </select>
          </div>
        </div>
		
		<div class="clearfix">
          <div class="input FL50">
            <label for="input1">Featured Artist <span class='mandatory'>*</span></label>
            <input type="text" name="artistsrch" id="artistsrch" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
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
            <input type="hidden" name="artistHidden" id="artistHidden" value=",<?=$artistHidden?>" />
            <input type="hidden" name="artistHiddensData" id="artistHiddensData" value="<?=$aContent['artistNameStr']?>" data-prompt-position="topLeft:510,-908;"/>
            <div class="field-content" id="artistbox">
              <?=$artistBox?>
            </div>
          </div>
		  <div class="input FL50">
			<label for="input1">Pack Albums <span class='mandatory'>*</span></label>
			<input type="text" name="albumsrch" id="albumsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
			<a title="Search Album" href="javascript:void();" onclick="if(document.getElementById('albumsrch').value != 'Search') {cms.srchartist(document.getElementById('albumsrch'), 'album', 'packAlbum'); document.getElementById('albumsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Album</a> Note : Double click to add Album
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
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=41&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
           </div>
		   <div class="input FL50">
            <label for="select">Language <span class='mandatory'>*</span></label>
            <select name="languageIds" id="select" >
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
		<div style="clear:both"></div>		
		<div class="input textarea">
            <label for="textarea2">Pack Description <span class='mandatory'>*</span></label>
            <textarea name="packDescription" id="packDescription" rows="7" cols="4" data-prompt-position="topLeft:130" ><?=$aContent['packDescription']?></textarea>
        </div>
        <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/packs?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>