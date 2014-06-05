<!-- CONTENT --> 
<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#radiostationFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
</script>
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/radiosnew.jpg" alt="Radio Station" height="45px" width="45px" />Radio Station</h1>
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
		<div class="title"><?=ucfirst($_GET['action'])?> Radio Station <div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
		<div class="content">
		<form method="post" enctype="multipart/form-data" id="radiostationFrm" name="radiostationFrm">		
			<div class="clearfix">
				<div class="input FL50">
					<label for="input2"> Radio Station Title : <span class='mandatory'>*</span></label>
					<input type="test" name='radiostation_name' value="<?=$aContent['radioName']?>" class="validate[required]"/>
				</div>
				<div class="input FL50">
				<label for="select">Language <span class='mandatory'>*</span></label>
				
				<select name="languageIds" id="languageIds" class="validate[required]" >
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
				<div class="input FL50">
				<label for="input1">Station Type : </label>				
				<select  name="stationType" id="stationType"> 				
				<option value='' >Select Station Type</option>
				<?php
				foreach($aConfig['stationType'] as $kStation=>$vStation){
					$bSelect = ($aContent['RadioType']==$kStation) ? 'selected="selected"' : '';
					echo '<option value='.$kStation.' '.$bSelect.'>'.$vStation.'</option>';
				
				}	
				?>
				</select>								
				</div>				
			 </div> 
			<div class="clearfix"> 
				<div class="input FL50">
					<label for="input2"> Preview Url : </label>
					<input type="test" name='preview_url' value="<?=$aContent['previewUrl']?>"/>
				</div>
				<div class="input FL50">
					<label for="input2"> Content Url : </label>
					<input type="test" name='content_url' value="<?=$aContent['contentUrl']?>"/>
				</div>
			</div>	

<div class="input">
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=39&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
</div>			
				<div class="input textarea">
					<label for="textarea2">Description : </label>
					<textarea name="description" cols="5" rows="5" id="desc"><?=$aContent['description']?></textarea>
				</div>
				
<!--
	    <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/radiostation?action=view' " /> 
        </div>
			
-->			<div class="submit">
				<input type="submit" value="Submit" name="submitBtn" class="black"/>
				<input type="hidden" name="refferer" value="<?=$_SERVER["HTTP_REFERER"]?>" />
			</div>
		</form>
		</div>
	</div>
</div>