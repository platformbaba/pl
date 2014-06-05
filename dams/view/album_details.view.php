<!-- CONTENT -->

<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>14,
							'relatedCType'=>0,
							'id'=>$aContent['albumId'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="input">
          <label for="input1">Album/Movie Name</label>
          <div class='text-field-disabled '><?=$aContent['albumName']?></div>
        </div>
		<div style="clear:both"></div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input2"> Album Type:</label>
	
		<?php
			$albumTypeFilm = (in_array(1,$aContent['albumType'])) ? "Film" : "Non Film" ;
			$albumTypeCO = (in_array(2,$aContent['albumType'])) ? "Orignal" : "Compile" ;
		?>	
			<?=$albumTypeFilm;?> :<input type="radio" name="albumTypeF" disabled checked="checked" />
			<?=$albumTypeCO;?> :<input type="radio" name="albumTypeO" disabled checked="checked"  />			
		
         </div>
          <div class="input FL50">
			<a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>" style="max-height:100px; max-width:100px;"></a>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Language</label>
            <div class='text-field-disabled '>
			<?php 
					foreach($languageList as $kL=>$vL){
						if($aContent['languageIds']){
							if($vL->language_id==$aContent['languageIds']){
								echo ucwords($vL->language_name);
							}
						}
					}
				?>
			</div>	
          </div>
          <div class="input FL50">
            <label for="select">Label</label>
            <div class='text-field-disabled '>
			<?php
					foreach($labelList as $kL=>$vL){
						if($aContent['labelIds']){
							if($vL->label_id==$aContent['labelIds']){
								echo ucwords($vL->label_name);
							}
						}	
					}
				?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Banner</label>
            <?php
										$bannerBox="";
										if($aContent['bannerId']){
											if($aContent['bannerNameArr']){
												foreach($aContent['bannerNameArr'] as $kBanner=>$vBanner){
													$bannerBox .= $vBanner.",";
											?>
            <?php
												}
											}
										}	
									?>
            <div class='text-field-disabled'>
              <?=trim($bannerBox,",")?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input4">Content Types</label>
            <div class='text-field-disabled'>
			<?=TOOLS::displayAlbumContentTypesStr($aContent['albumContentType'])?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Primary Artist</label>
            <?php
									$artistBox="";
									$artistHidden="";
									if($aContent['artistId']){
										$artistHidden=$aContent['artistId'].",";;
										$artistBox = $aContent['artistNameArr'][$aContent['artistId']];
								?>
            <?php
									}
								?>
            <div class='text-field-disabled'>
              <?=$artistBox?>
            </div>
          </div>
          <div class="input long FL50">
            <label for="input1">Coupling Ids</label>
			<div class='text-field-disabled'>
            <?=$aContent['couplingIds']?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input" style="float:left; width:50%">
            <label for="input1">Starcast</label>
            <?php
										$starcastBox="";
										if($aContent['starcastId']){
											$starcastHidden=$aContent['starcastId'].",";;
											if($aContent['starcastNameArr']){
												foreach($aContent['starcastNameArr'] as $kStar=>$vStar){
													$starcastBox .= $vStar.",";
											?>
            <?php
												}
											}
										}	
									?>
            <div class='text-field-disabled'>
              <?=trim($starcastBox,",")?>
            </div>
          </div>
          <div class="input" style="float:left;  width:50%;">
            <label for="input1">Director</label>
            <?php
										$directorBox="";
										if($aContent['directorId']){
											$directorHidden=$aContent['directorId'].",";
											if($aContent['directorNameArr']){
												foreach($aContent['directorNameArr'] as $kDir=>$vDir){
													$directorBox .= $vDir.",";
									?>
            <?php
											}
										}
									}	
									?>
            <div class='text-field-disabled'>
              <?=trim($directorBox,",");?>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input" style="float:left;width:50%;">
            <label for="input1">Producer</label>
            <?php
										$producerBox="";
										if($aContent['producerId']){
											if($aContent['producerNameArr']){
												foreach($aContent['producerNameArr'] as $kProd=>$vProd){
														$producerBox .= $vProd.",";
												?>
            <?php
											}
										}
									}	
									?>
            </select>
            <div class='text-field-disabled'>
              <?=trim($producerBox,",")?>
            </div>
          </div>
          <div class="input" style="float:left;width:50%;">
            <label for="input1">Writer</label>
            <?php
										$writerBox="";
										$writerHidden="";
										if($aContent['writerId']){
											$writerHidden=$aContent['writerId'].",";
											if($aContent['writerNameArr']){
												foreach($aContent['writerNameArr'] as $kWrite=>$vWrite){
														$writerBox .= $vWrite.",";
												?>
            <?php
											}
										}
									}	
								?>
            <div class='text-field-disabled'>
              <?=trim($writerBox,",")?>
            </div>
          </div>
		  
<div class="input" style="float:left;width:50%;">
            <label for="input1">Music Director</label>
           <?php
										$mdirectorBox="";
										if($aContent['mdirectorId']){
											if($aContent['mdirectorNameArr']){
												foreach($aContent['mdirectorNameArr'] as $kDir=>$vDir){
													$mdirectorBox .= $vDir.",";
									?>
            <?php
											}
										}
									}	
			?>
            <div class='text-field-disabled'>
              <?=trim($mdirectorBox,",")?>
            </div>
          </div>
		  
		  
<div class="input" style="float:left;width:50%;">
            <label for="input1">Lyricist</label>
            <?php
										$lyricistBox="";
										if($aContent['lyricistId']){
											$lyricistHidden=$aContent['lyricistId'].",";
											if($aContent['lyricistNameArr']){
												foreach($aContent['lyricistNameArr'] as $kLyr=>$vLyr){
														$lyricistBox .= $vLyr.",";
												?>
            <?php
											}
										}
									}	
			?>
            <div class='text-field-disabled'>
              <?=trim($lyricistBox,",")?>
            </div>
          </div>		  
		  		  
		  
		  
        </div>
        <div style="clear:both"></div>
        <div class="clearfix">
		  <div class="input FL50">
            <label for="input4">Movie Release Date</label>
			<div class='text-field-disabled'>
            <?=$aContent['titleReleaseDate']?>
			</div>
          </div>
		  <div class="input FL50">
            <label for="input4">Release Date</label>
            <div class='text-field-disabled'>
			<?=$aContent['musicReleaseDate']?>
			</div>
          </div>
		</div>
		
        <div class="input textarea">
          <label for="textarea2">Album Description</label>
          <div class='text-field-disabled'>
		  <?=html_entity_decode($aContent['albumDescription'])?>
		  </div>
        </div>
        <div class="input textarea">
          <label for="textarea2">Album Excerpt</label>
          <div class='text-field-disabled'>
		  <?=html_entity_decode($aContent['albumExcerpt'])?>
		  </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Tv Channel</label>
            <div class='text-field-disabled'>
			<?php 
					$vChannelBox="";
					foreach($tvchannelList as $kTV=>$vTV){
						if($aContent['tvchannelIds']){
							if(in_array($vTV->tag_id,$aContent['tvchannelIds'])){
								$vChannelBox .= ucwords($vTV->tag_name).",";
							}	
						}
					}
					echo trim($vChannelBox,",");
			?>
			</div>
          </div>
          <div class="input FL50">
            <label for="select">Radio Station</label>
            <div class='text-field-disabled'>
			<?php 
					$vRadioBox="";
					foreach($radioList as $kRd=>$vRd){
						if($aContent['radioIds']){
							if(in_array($vRd->tag_id,$aContent['radioIds'])){
								$vRadioBox .= ucwords($vRd->tag_name).",";
							}
						}
					}
					echo trim($vRadioBox,",");					
			?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Name of Show</label>
            <div class='text-field-disabled'>
			<?=$aContent['showName']?>
			</div>
          </div>
          <div class="input FL50">
            <label for="input1">Year of Broadcast (YYYY)</label>
            <div class='text-field-disabled'>
			<?=$aContent['broadCastYear']?>
			</div>
          </div>
        </div>
		<div class="clearfix">
          <div class="input FL50">
            <label for="input1">Grade</label>
            <div class='text-field-disabled'>
			<?=$aContent['grade']?>
			</div>
          </div>
          <div class="input FL50">
            <label for="input1">Subtitle (Y/N) :</label>
            <?php $isSub = ($aContent['isSubtitle']==1)?"checked":"";	?>
			<input type="checkbox" disabled name='isSubtitle' value="1" <?php echo ($isSub)?> />
          </div>
        </div>
        <!-- div style="clear:both"></div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input2"> Subtitle (Y/N) :</label>
            <?php $isSub = ($aContent['isSubtitle']==1)?"checked":"";	?>
            <input type="checkbox" disabled name='isSubtitle' value="1" <?php echo ($isSub)?> />
          </div>
          <div class="input FR50">
            <label for="input1">Grade</label>
            <div class='text-field-disabled'>
			<?=$aContent['grade']?>
			</div>
          </div>
        </div -->
		<div style="clear:both"></div>
		<div class="input">
          <label for="input1">Film Rating</label>
          <div class='text-field-disabled'>
		  <?=$aContent['filmRating']?>
		  </div>
        </div>
      </form>
    </div>
  </div>
</div>