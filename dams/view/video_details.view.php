<!-- CONTENT -->
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>15,
							'relatedCType'=>0,
							'id'=>$aContent['videoId'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="input">
          <label for="input1">Video Title</label>
          <div class='text-field-disabled'>
		  <?=$aContent['videoName']?>
		  </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Language</label>
            <div class='text-field-disabled'>
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
            <label for="input4">Release Date</label>
            <div class='text-field-disabled'>
			<?=$aContent['releaseDate']?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <!--<div class="input FL50">
            <label for="input1">Video Tempo</label>
            <div class='text-field-disabled'>
			<?=$aContent['videoTempo']?>
			</div>
          </div>-->
          <div class="input FL50">
            <label for="input1">Video Duration (in sec)</label>
            <div class='text-field-disabled'>
			<?=$aContent['videoDuration']?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Image</label>
            <div style="width:140px; padding-top:2px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
          </div>
          <div class="input FL50">
            <label for="input1">Subject of Parody</label>
            <div class='text-field-disabled'>
			<?=$aContent['subjectParody']?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input4">Video File Path</label>
            <div class='text-field-disabled'>
			<?=$aContent['videoFilePath']?>
			</div>
          </div>
        </div>
		<div class="clearfix">
        <div class="input FL50">
          <label for="input1">Album</label>
          <?php
										$albumBox="";
										$albumHidden="";
										if($aContent['albumId']){
											$albumHidden=$aContent['albumId'].",";;
											if($aContent['albumNameArr']){
												foreach($aContent['albumNameArr'] as $kStar=>$vStar){
													$albumBox .= $vStar.",";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=trim($albumBox,",")?>
          </div>
        </div>
		<div class="input FL50">
          <label for="input1">Song/Scenes</label>
          <?php
										$songBox="";
										$songHidden="";
										if($aContent['songId']){
											$songHidden=$aContent['songId'].",";;
											if($aContent['songNameArr']){
												foreach($aContent['songNameArr'] as $kStar=>$vStar){
													$songBox .= $vStar.",";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=trim($songBox,",")?>
          </div>
        </div>
		</div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Singer</label>
            <?php
										$singerBox="";
										if($aContent['singerId']){
											if($aContent['singerNameArr']){
												foreach($aContent['singerNameArr'] as $kStar=>$vStar){
													$singerBox .= $vStar.",";
											?>
            <?php
												}
											}
										}	
									?>
            <div class='text-field-disabled'>
              <?=trim($singerBox,",")?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input1">Director</label>
            <?php
										$directorBox="";
										if($aContent['directorId']){
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
              <?=trim($directorBox,",")?>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
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
          <!--<div class="input FL50">
            <label for="input1">Poet</label>
            <?php
									/*$poetBox="";
									if($aContent['poetId']){
										if($aContent['poetNameArr']){
											foreach($aContent['poetNameArr'] as $kPoet=>$vPoet){
													$poetBox .= $vPoet.",";
											
										}
									}
								}	*/
							?>
            <div class='text-field-disabled'>
              <?=trim($poetBox,",")?>
            </div>
          </div>-->
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Starcast</label>
            <?php
										$starcastBox="";
										if($aContent['starcastId']){
											if($aContent['starcastNameArr']){
												foreach($aContent['starcastNameArr'] as $kStar=>$vStar){
													$starcastBox .= $vStar.",";
											
												}
											}
										}	
									?>
            <div class='text-field-disabled'>
              <?=trim($starcastBox,",")?>
            </div>
          </div>
          <div class="input FL50">
            <label for="input1">Mimicked Star</label>
            <?php
										$mstarcastBox="";
										if($aContent['mstarcastId']){
											if($aContent['mstarcastNameArr']){
												foreach($aContent['mstarcastNameArr'] as $kStar=>$vStar){
														$mstarcastBox .= $vStar.",";
												
											}
										}
									}	
								?>
            <div class='text-field-disabled'>
              <?=trim($mstarcastBox,",")?>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Version</label>
            <div class='text-field-disabled'>
			<?php 	
					$versionStr="";
						foreach($versionList as $kVer=>$vVer){
							if($aContent['version']){
								if(in_array($vVer->tag_id,$aContent['version'])){
									$versionStr .=	ucwords($vVer->tag_name).",";
								}
							}
						}
					echo trim($versionStr,",");
					?>
				</div>
          </div>
          <div class="input FL50">
            <label for="select">Genre</label>
            <div class='text-field-disabled'>
			<?php 
					$genreStr="";
						foreach($genreList as $kGenre=>$vGenre){
							if($aContent['genre']){
								if(in_array($vGenre->tag_id,$aContent['genre'])){
									$genreStr .=	ucwords($vGenre->tag_name).",";
								}
							}
						}
					echo trim($genreStr,",");	
					?>
				</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Mood</label>
			<div class='text-field-disabled'>
            <?php 
				$selMood="";
						foreach($moodList as $kMood=>$vMood){
							if($aContent['mood']){
								if(in_array($vMood->tag_id,$aContent['mood'])){
									$selMood .= ucwords($vMood->tag_name).",";
								}
							}
						}
					echo trim($selMood,",");						
			   ?>
			   </div>
          </div>
          <div class="input FL50">
            <label for="select">Relationship</label>
			<div class='text-field-disabled'>
              <?php 
			  	$selRelationship="";
						foreach($relationshipList as $kRelationship=>$vRelationship){
							if($aContent['relationship']){
								if(in_array($vRelationship->tag_id,$aContent['relationship'])){
									$selRelationship .= ucwords($vRelationship->tag_name).",";
								}
							}
						}
						echo trim($selRelationship,",");
					?>
				</div>
          </div>
        </div>
        <div class="clearfix">
          <!--<div class="input FL50">
            <label for="select">Raag</label>
			<div class='text-field-disabled'>
              <?php 
			  	/*$selRaag="";
						foreach($raagList as $kRaag=>$vRaag){
							if($aContent['raag']){
								if(in_array($vRaag->tag_id,$aContent['raag'])){
									$selRaag .= ucwords($vRaag->tag_name).","; 								
								}
							}
						}
						echo trim($selRaag,",");*/
					?>
				</div>
          </div>-->
          <!--<div class="input FL50">
            <label for="select">Taal</label>
              <div class='text-field-disabled'>
			  <?php 
			  	/*$selTaal="";
						foreach($taalList as $kTaal=>$vTaal){
							if($aContent['taal']){
								if(in_array($vTaal->tag_id,$aContent['taal'])){
									$selTaal .= ucwords($vTaal->tag_name).",";
								}
							}
						}
						echo trim($selTaal,",");*/
					?>
				</div>
          </div>-->
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Time of Day</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selTimeofday="";
						foreach($timeofdayList as $kTimeofday=>$vTimeofday){
							if($aContent['timeofday']){
								if(in_array($vTimeofday->tag_id,$aContent['timeofday'])){
									$selTimeofday .= ucwords($vTimeofday->tag_name).",";
								}
							}
						}
						echo trim($selTimeofday,",");
					?>
				</div>
          </div>
          <div class="input FL50">
            <label for="select">Religion</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selReligion="";
						foreach($religionList as $kReligion=>$vReligion){
							if($aContent['religion']){
								if(in_array($vReligion->tag_id,$aContent['religion'])){
									$selReligion .= ucwords($vReligion->tag_name).",";
								}
							}
						}
						echo trim($selReligion,",");
					?>
				</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Deity or Saint</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selSaint="";
						foreach($saintList as $kSaint=>$vSaint){
							if($aContent['saint']){
								if(in_array($vSaint->tag_id,$aContent['saint'])){
									$selSaint .=  ucwords($vSaint->tag_name).",";
								}
							}
						}
						echo trim($selSaint,",");
					?>
				</div>
          </div>
          <div class="input FL50">
            <label for="select">Instrument</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selInstrument="";
						foreach($instrumentList as $kInstrument=>$vInstrument){
							if($aContent['instrument']){
								if(in_array($vInstrument->tag_id,$aContent['instrument'])){
									$selInstrument .= ucwords($vInstrument->tag_name).","; 								
								}
							}
						}
						echo trim($selInstrument,",");
					?>
				</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Festival</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selFestival="";
						foreach($festivalList as $kFestival=>$vFestival){
							if($aContent['festival']){
								if(in_array($vFestival->tag_id,$aContent['festival'])){
									$selFestival .= ucwords($vFestival->tag_name).",";
								}
							}
						}
						echo trim($selFestival,",");
					?>
				</div>
          </div>
          <div class="input FL50">
            <label for="select">Occasion</label>
              <div class='text-field-disabled'>
			  <?php 
			  	$selOccasion="";
						foreach($occasionList as $kOccasion=>$vOccasion){
							if($aContent['occasion']){
								if(in_array($vOccasion->tag_id,$aContent['occasion'])){
									$selOccasion .= ucwords($vOccasion->tag_name).",";
								}
							}
						}
						echo trim($selOccasion,",");
					?>
				</div>
          </div>
        </div>
        <div class="input">
          <label for="select">Region</label>
            <div class='text-field-disabled'>
			<?php 
				$selRegion="";
					foreach($regionList as $kRegion=>$vRegion){
						if($aContent['region']){
							if($vRegion->region_id==$aContent['region']){
								$selRegion .=  ucwords($vRegion->region_name).",";
							}
						}
					}
					echo trim($selRegion,",");
				?>
			</div>
        </div>
      </form>
    </div>
  </div>
</div>