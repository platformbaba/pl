<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#albumFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
	function checkPrimaryArtist(field, rules, i, options){
		var fieldVal=field.val();
		var fieldArr="";
		if(fieldVal!="" && fieldVal!=","){
			fieldArr=fieldVal.split(",");
			if(fieldArr.length>3){
				$("#artistsrch").focus();
				return options.allrules.validate2fields.alertText;
			}
		}
	}
</script>
<?php
if(!empty($aError))	
	$val =1;
else
	$val =0;
	
	
  if($aContent['albumType']){				  
	$isFilm		 = (in_array(1,$aContent['albumType'])) ? 'checked="checked"' : '';
	$isOriginal	 = (in_array(2,$aContent['albumType'])) ? 'checked="checked"' : '';
	
  }
	$isFilm2	 = (strlen($isFilm)>0) ? '' :'checked="checked"';
	$isOriginal2	 = (strlen($isOriginal)>0) ? '' :'checked="checked"'; 


?>
<script>

$(document).ready(function(){ 


	$('.hide').hide();

	var chk = document.getElementById('val').value;
	var isFilm = document.getElementById('isFilm').value;
	var isNonFilm = document.getElementById('isNonFilm').value;
	//alert("isFilm=="+isFilm+"----isNonFilm"+isNonFilm);
    $("input[name$='albumTypeF']").click(function() {
        var chkVal = $(this).val();
         if(chkVal=="1"){
             $(".hide").show();
		
        }else{
			$(".hide").hide();
			
		}	    	
    });
	
	if(isFilm!=''){
		$(".hide").show();
	}else{
		$(".hide").hide();
	}		
		
	
});
</script>
<!-- CONTENT --> 
<input type="hidden" id="val" value="<?=$val?>" />
<input type="hidden" id="isFilm" value="<?=$isFilm?>" />
<input type="hidden" id="isNonFilm" value="<?=$isOriginal?>" />
<div id="content">
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Album" />Album</h1>
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

    <div class="title"><?=ucfirst($_GET['action'])?> Album<div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" id="albumFrm" name="albumFrm">
        <div class="clearfix">
			<div class="input FL50">
            <label for="input1" title="Album/Movie Name">Album/Movie Name <span class='mandatory'>*</span></label>
            <input type="text" id="albumName" name="albumName" value="<?=$aContent['albumName']?>"  class="validate[required]"/>
        </div>
		<div class="input FL50">
            <label for="select">Catalogue/Genre<span class='mandatory'>*</span></label>
			<select name="catalogueIds" id="catalogueIds" class="validate[required]" >
                <option value="">Select Catalogue/Genre</option>
				<?php 
					foreach($catalogueList as $kL=>$vL){
						if($aContent['catalogueIds']){
							$selStr = ($vL->catalogue_id==$aContent['catalogueIds'])?"selected='selected'":"";
						}
						echo '<option value="'.$vL->catalogue_id.'" '.$selStr.' >'.ucwords($vL->catalogue_name).'</option>';
					}
				?>
            </select>
        </div>
		
		</div>
		<div class="clearfix">
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
		<div class="input FL50">
            <label for="select">Label<span class='mandatory'>*</span></label>
 			<select name="labelIds" id="select" class="validate[required]">
                <option value="">Select Label</option>
				<?php
					foreach($labelList as $kL=>$vL){
						if($aContent['labelIds']){
							$selStr = ($vL->label_id==$aContent['labelIds'])?"selected='selected'":"";
						}	
						echo '<option value="'.$vL->label_id.'" '.$selStr.' >'.ucwords($vL->label_name).'</option>';
					}
				?>
            </select>
        </div>
		</div>
		<div class="clearfix">
		<div class="input FL50">
			<a href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=14&cId=<?=$_GET['id']?>&place=oPic" class="button fancybox fancybox.iframe" title="Upload a Image">Upload a Image</a>
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
				<input type="hidden" name="oPic" id="oPic" value="<?=$data['aContent']['image']?>" />
				<input type="hidden" name="oPicImageId" id="oPicImageId" value="<?=$data['aContent']['oPicImageId']?>" />
        </div>
		<div class="input FL50">
            <label >Content Types <span class='mandatory'>*</span></label>
            <select name='album_content_type[]' size="6" multiple class="validate[required]">
				<?php
					foreach($aConfig['album_content_type'] as $kkk=>$vvv ){
							$selectstr = '';
							if( ($aContent['albumContentType']&$kkk)==$kkk ){ $selectstr='selected'; }
						echo "<option value='".$kkk."' ".$selectstr.">".$vvv."</option>";
					}
				?>
			</select>
        </div>
		</div> 
		
		<div class="clearfix">
		<div class="input FL50">
			<label for="input4">Movie Release Date</label>
            <input type="text" name="titleReleaseDate" class="datepicker" id="input5" value="<?=$aContent['titleReleaseDate']?>"/>
        </div>
		<div class="input FL50">
            <label for="input4">Release Date<span class='mandatory'>*</span></label>
            <input type="text" name="musicReleaseDate" id="input4" value="<?=$aContent['musicReleaseDate']?>" class="datepicker validate[required]"/>
        </div>
		</div>	
		<div style="clear:both"></div>
		<div class="clearfix">
		<div class="input FL50">
            <label for="input2"> Album Type:</label>
		Non Film :<input type="radio" name="albumTypeF" value="0"  <?=$isFilm2;?>  />&nbsp;&nbsp;Film :<input type="radio" name="albumTypeF" value="1" <?=$isFilm;?>  />
		Orignal :<input type="radio" name="albumTypeO" value="2" <?=$isOriginal;?>  />&nbsp;&nbsp;Compile :<input type="radio" name="albumTypeO" value="0" <?=$isOriginal2;?>  />
		<input type="hidden" name="albumTypeD" value="4" />
       </div>
		<div class="input FL50">            
        </div>
		</div>
	
		<div class="clearfix">
			<div class="input FL50">
					<label for="input1">Banner :<span class='mandatory hide'>*</span></label>
		
										<input type="text" name="bannersrch" id="bannersrch" class="full-width autosuggestBanner" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
										<a title="Search Banner" href="javascript:void();" onclick="if(document.getElementById('bannersrch').value != 'Search') {cms.srchartist(document.getElementById('bannersrch'), 'banner', 'banner'); document.getElementById('bannersrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Banner</a>
										Note : Double click to add Banner
				
										<select  name="banner[]" id="banner" ondblclick="cms.getDetails(this,'bannerHidden','bannerbox','banner');" style="width:250px; height:100px;"  size="10" multiple="multiple" >
										<?php
											$bannerBox="";
											$bannerHidden="";
											if($aContent['bannerId']){
												$bannerHidden=$aContent['bannerId'].",";;
												if($aContent['bannerNameArr']){
													foreach($aContent['bannerNameArr'] as $kBanner=>$vBanner){
														$bannerBox .= "<span id='banner_".$kBanner."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kBanner."','bannerHidden','banner')\" title='Double Click to Remove' >".$vBanner."</a><br></span>";
												?>
												<option value="<?=$kBanner;?>" selected="selected"><?=$vBanner;?></option>
										<?php
													}
												}
											}	
										?>
										</select>								
										<input type="hidden" name="bannerHidden" id="bannerHidden" value=",<?=$bannerHidden?>" />
										<input type="hidden" name="bannerHiddensData" id="bannerHiddensData" value="<?=$aContent['bannerNameStr']?>" />
										<div class="field-content" id="bannerbox"><?=$bannerBox?></div>
			</div>
			<div class="input FL50">
				<label for="input1">Primary Artist:</label>
	
									<input type="text" name="artistsrch" id="artistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
									<a title="Search Artist" href="javascript:void();" onclick="if(document.getElementById('artistsrch').value != 'Search') {cms.srchartist(document.getElementById('artistsrch'), 'artist', ''); document.getElementById('artistsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Artist</a>
									Note : Double click to add Artist
			
									<select  name="artist" id="artist" ondblclick="cms.getDetails(this,'artistHidden','artistbox','artist');" style="width:250px; height:100px;"  size="10">
									<?php
										$artistBox="";
										$artistHidden="";
										if($aContent['artistId']){
											$artistHidden=$aContent['artistId'].",";;
											$artistBox .= "<span id='artist_".$aContent['artistId']."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$aContent['artistId']."','artistHidden','artist')\" title='Double Click to Remove' >".$aContent['artistNameArr'][$aContent['artistId']]."</a><br></span>";
									?>
									<option value="<?=$aContent['artistId'];?>" selected="selected"><?=$aContent['artistNameArr'][$aContent['artistId']];?></option>
									<?php
										}
									?>
									</select>								
									<!--<input type="hidden" name="artistHidden" id="artistHidden" value=",<?=$artistHidden?>" class="validate[required,funcCall[checkPrimaryArtist]]" data-errormessage="*Primary artist should be only one!" data-prompt-position="topLeft:890"/>-->
									<input type="hidden" name="artistHidden" id="artistHidden" value=",<?=$artistHidden?>"  data-prompt-position="topLeft:890"/>
									<input type="hidden" name="artistHiddensData" id="artistHiddensData" value="<?=$aContent['artistNameStr']?>" />
									<div class="field-content" id="artistbox"><?=$artistBox?></div>
									(Lead Artist of the Album should be only one)
			</div>
			
		</div>		
		<div class="clearfix">
			<div class="input" style="float:left; width:50%">
				<label for="input1">Starcast : <span class='mandatory hide'>*</span></label>
	
									<input type="text" name="starcastsrch" id="starcastsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
									<a title="Search Starcast" href="javascript:void();" onclick="if(document.getElementById('starcastsrch').value != 'Search') {cms.srchartist(document.getElementById('starcastsrch'), 'starcast', 'Starcast'); document.getElementById('starcastsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Starcast</a>
									Note : Double click to add Starcast
			
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
											<option value="<?=$kStar;?>" selected="selected"><?=$vStar;?></option>
									<?php
												}
											}
										}	
									?>
									</select>								
									<input type="hidden" name="starcastHidden" id="starcastHidden" value=",<?=$starcastHidden?>" />
									<input type="hidden" name="starcastHiddensData" id="starcastHiddensData" value="<?=$aContent['starcastNameStr']?>" />
									<div class="field-content" id="starcastbox"><?=$starcastBox?></div>
			</div>
			<div class="input" style="float:left;  width:50%;">
				<label for="input1">Director : <span class='mandatory hide'>*</span></label>
	
									<input type="text" name="directorsrch" id="directorsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
									<a title="Search Director" href="javascript:void();" onclick="if(document.getElementById('directorsrch').value != 'Search') {cms.srchartist(document.getElementById('directorsrch'), 'director', 'Director'); document.getElementById('directorsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Director</a>
									Note : Double click to add Director
			
									<select  name="director[]" id="director" ondblclick="cms.getDetails(this,'directorHidden','directorbox','director');" style="width:250px; height:100px;"  size="10" multiple="multiple">
									<?php
										$directorBox="";
										$directorHidden="";
										if($aContent['directorId']){
											$directorHidden=$aContent['directorId'].",";
											if($aContent['directorNameArr']){
												foreach($aContent['directorNameArr'] as $kDir=>$vDir){
											$directorBox .= "<span id='director_".$kDir."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kDir."','directorHidden','director')\" title='Double Click to Remove' >".$vDir."</a><br></span>";
									?>
									<option value="<?=$kDir;?>" selected="selected"><?=$vDir;?></option>
									<?php
											}
										}
									}	
									?>
									</select>								
									<input type="hidden" name="directorHidden" id="directorHidden" value=",<?=$directorHidden?>" />
									<input type="hidden" name="directorHiddensData" id="directorHiddensData" value="<?=$aContent['directorNameStr']?>" />
									<div class="field-content" id="directorbox"><?=$directorBox?></div>
			</div>
		</div>
		<div class="clearfix">
			<div class="input" style="float:left;width:50%;">
				<label for="input1">Producer : <span class='mandatory hide'>*</span></label>
	
									<input type="text" name="producersrch" id="producersrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
									<a title="Search Producer" href="javascript:void();" onclick="if(document.getElementById('producersrch').value != 'Search') {cms.srchartist(document.getElementById('producersrch'), 'producer', 'Producer'); document.getElementById('producersrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Producer</a>
									Note : Double click to add Producer
			
									<select  name="producer[]" id="producer" ondblclick="cms.getDetails(this,'producerHidden','producerbox','producer');" style="width:250px; height:100px;"  size="10" multiple="multiple">
									<?php
										$producerBox="";
										$producerHidden="";
										if($aContent['producerId']){
											$producerHidden=$aContent['producerId'].",";
											if($aContent['producerNameArr']){
												foreach($aContent['producerNameArr'] as $kProd=>$vProd){
														$producerBox .= "<span id='producer_".$kProd."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kProd."','producerHidden','producer')\" title='Double Click to Remove' >".$vProd."</a><br></span>";
												?>
												<option value="<?=$kProd;?>" selected="selected"><?=$vProd;?></option>
									<?php
											}
										}
									}	
									?>
									</select>								
									<input type="hidden" name="producerHidden" id="producerHidden" value=",<?=$producerHidden?>" />
									<input type="hidden" name="producerHiddensData" id="producerHiddensData" value="<?=$aContent['producerNameStr']?>" />
									<div class="field-content" id="producerbox"><?=$producerBox?></div>
			</div>
			<div class="input" style="float:left;width:50%;">
				<label for="input1">Writer : </label>
	
									<input type="text" name="writersrch" id="writersrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " /> 
									<a title="Search Writer" href="javascript:void();" onclick="if(document.getElementById('writersrch').value != 'Search') {cms.srchartist(document.getElementById('writersrch'), 'writer', 'Writer'); document.getElementById('writersrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search Writer</a>
									Note : Double click to add Writer
			
									<select  name="writer[]" id="writer" ondblclick="cms.getDetails(this,'writerHidden','writerbox','writer');" style="width:250px; height:100px;"  size="10" multiple="multiple">
								<?php
										$writerBox="";
										$writerHidden="";
										if($aContent['writerId']){
											$writerHidden=$aContent['writerId'].",";
											if($aContent['writerNameArr']){
												foreach($aContent['writerNameArr'] as $kWrite=>$vWrite){
														$writerBox .= "<span id='writer_".$kWrite."'><a href='javascript:void(0);' ondblclick=\"cms.removeData('".$kWrite."','writerHidden','writer')\" title='Double Click to Remove' >".$vWrite."</a><br></span>";
												?>
												<option value="<?=$kWrite;?>" selected="selected"><?=$vWrite;?></option>
									<?php
											}
										}
									}	
								?>
									</select>								
									<input type="hidden" name="writerHidden" id="writerHidden" value=",<?=$writerHidden?>" />
									<input type="hidden" name="writerHiddensData" id="writerHiddensData" value="<?=$aContent['writerNameStr']?>" />
									<div class="field-content" id="writerbox"><?=$writerBox?></div>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50" style="float:left;width:50%;">
            <label for="input1">Music Director :</label>
            <input type="text" name="mdirectorsrch" id="mdirectorsrch" class="full-width autosuggestDir" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
            <a title="Search Music Director" href="javascript:void();" onclick="if(document.getElementById('mdirectorsrch').value != 'Search') {cms.srchartist(document.getElementById('mdirectorsrch'), 'mdirector', 'Music Director'); document.getElementById('mdirectorsrch').value='Search'; } return false;" class="button"  style="float: left; margin-left: 275px; margin-top: -32px;" >Search M Director</a> Note : Double click to add Music Director
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
			<div class="input FL50" style="float:left;width:50%;">
            <label for="input1">Lyricist :</label>
            <input type="text" name="lyricistsrch" id="lyricistsrch" class="full-width autosuggestStar" value="Search" onfocus="if(this.value=='Search') { this.value=''; } " />
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
		</div>	
		<div style="clear:both"></div>		
		<div class="input textarea">
            <label for="textarea2">Album Description <span class='mandatory'>*</span></label>
            <textarea name="albumDescription" id="albumDescription" rows="7" cols="4" class="validate[required]" data-prompt-position="topLeft:130" ><?=$aContent['albumDescription']?></textarea>
        </div>
		<div class="input textarea">
            <label for="textarea2">Album Excerpt </label>
            <textarea name="albumExcerpt" id="albumExcerpt" rows="7" cols="4" maxlength="140"  data-prompt-position="topLeft:130"><?=$aContent['albumExcerpt']?></textarea>
        </div>
		<div class="input long">
            <label for="input1">Coupling Ids </label>
            <input type="text" id="couplingIds" name="couplingIds" value="<?=$aContent['couplingIds']?>"  data-prompt-position="topLeft:130"/>
			seperated by comma ","
        </div>
		<div class="clearfix">
		<div class="input FL50">
            <label for="select">Tv Channel</label>
 			<select name="tvchannelIds[]" id="tvchannelIds"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
					foreach($tvchannelList as $kTV=>$vTV){
						if($aContent['tvchannelIds']){
							if(in_array($vTV->tag_id,$aContent['tvchannelIds'])){
								echo '<option value="'.$vTV->tag_id.'" selected="selected" >'.ucwords($vTV->tag_name).'</option>';
							}
						}
					}
					foreach($tvchannelList as $kTV=>$vTV){
							if(!in_array($vTV->tag_id,$aContent['tvchannelIds'])){
								echo '<option value="'.$vTV->tag_id.'" >'.ucwords($vTV->tag_name).'</option>';
							}
					}
				?>
            </select>
        </div>
		<div class="input FL50">
            <label for="select">Radio Station</label>
 			<select name="radioIds[]" id="radioIds"  multiple="multiple" size="10" style="width:250px; height:100px;">
				<?php 
					foreach($radioList as $kRd=>$vRd){
						if($aContent['radioIds']){
							if(in_array($vRd->tag_id,$aContent['radioIds'])){
								echo '<option value="'.$vRd->tag_id.'" selected="selected" >'.ucwords($vRd->tag_name).'</option>';
							}
						}
					}
					foreach($radioList as $kRd=>$vRd){
							if(!in_array($vRd->tag_id,$aContent['radioIds'])){
								echo '<option value="'.$vRd->tag_id.'"  >'.ucwords($vRd->tag_name).'</option>';
							}
					}
				?>
            </select>
        </div>
		</div>
		<div class="clearfix">
		<div class="input FL50">
            <label for="input1">Name of Show</label>
            <input type="text" id="showName" name="showName" value="<?=$aContent['showName']?>" />
        </div>
		<div class="input Fl50">
            <label for="input1">Year of Broadcast (YYYY)</label>
            <input type="text" id="broadCastYear" name="broadCastYear" value="<?=$aContent['broadCastYear']?>" />
        </div>
		</div>
		<div class="clearfix">
		<div class="input FL50">
            <label for="input1">Film Rating</label>
			<select name='filmRating'>
				<option value="">Select Film Rating</option>
				<?php
					foreach($aConfig['film_rating'] as $kkk=>$vvv ){
							$selectstr = '';
							if( $aContent['filmRating']==$vvv ){ $selectstr='selected'; }
						echo "<option value='".$vvv."' ".$selectstr.">".$vvv."</option>";
					}
				?>
			</select>
			<br /><br />
			(A+, A, B, C etc. Completely based on  Production Quality and Potential Revenue.)
        </div>
		<div class="input FL50">
            <label for="input2"> Subtitle (Y/N) :</label>
			<?php 	
				  	$isSub = ($aContent['isSubtitle']==1)?"checked":"";
			?>
			<input type="checkbox" name='isSubtitle' value=1 <?php echo ($isSub)?> />
			(Captures If the Subtitle is present on Video or Not.)
        </div>
		</div>
		<div class="input">
            <label for="input1">Grade </label>
            <!--<input type="text" id="filmRating" name="filmRating" value="<?=$aContent['filmRating']?>" />-->
			<select name='grade' id="grade">
				<option value="">Select Grade</option>
				<?php
					foreach($aConfig['grade'] as $kkk=>$vvv ){
							$selectstr = '';
							if( $aContent['grade']==$vvv ){ $selectstr='selected'; }
						echo "<option value='".$vvv."' ".$selectstr.">".$vvv."</option>";
					}
				?>
			</select>
        </div>
		
	    <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/album?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>
<script type="text/javascript">
var catalogueOptions, catalogueautocom;
	jQuery(function(){
	  catalogueOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=catalogue', minChars:2, delimiter: /(,|;)\s*/ ,class : "autosuggestcatalogue"};
	  catalogueautocom = $('.autosuggestcatalogue').autocomplete(catalogueOptions);
	});
</script>