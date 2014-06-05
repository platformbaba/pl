<!-- CONTENT -->

<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>19,
							'relatedCType'=>0,
							'id'=>$aContent['textId'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
        <div class="input">
          <label for="input1">Text Title</label>
          <div class='text-field-disabled'>
		  <?=$aContent['textName']?>
		  </div>
        </div>
	  <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Text Desc</label>
            <div class='text-field-disabled'>
			<?=$aContent['textDesc']?>
			</div>
          </div>
	</div>	
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
        
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Text Type</label>
            <div class='text-field-disabled'>
			<?=array_search($aContent['textType'], $aConfig['text_type']);?>
			</div>
          </div>
		  <?php if( !empty($aContent['textFile']) ){ ?>
		  <div class="input FL50">
            <label for="input1">Text Doc</label>
            <a href="<?=MEDIA_SITEPATH_DOC.$aContent['textFile']?>" target="_blank"><b>Click to download</b></a>
			<br>(pdf | image | text | doc | docx)
          </div>
		  <?php } ?>
        </div>
 	<div class="input">
          <label for="input1">Album</label>
          <?php
										$albumBox="";
										$albumHidden="";
										if($aContent['albumId']){
											$albumHidden=$aContent['albumId'].",";;
											if($aContent['albumNameArr']){
												foreach($aContent['albumNameArr'] as $kStar=>$vStar){
													$albumBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($albumBox,",")?>
          </div>
        </div>
	<div class="input">
          <label for="input1">Artist</label>
          <?php
										$artistBox="";
										$albumHidden="";
										if($aContent['artistId']){
											$artistHidden=$aContent['artistId'].",";;
											if($aContent['artistNameArr']){
												foreach($aContent['artistNameArr'] as $kStar=>$vStar){
													$artistBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($artistBox,",")?>
          </div>
        </div>	

           </div>
  </div>	
</div>