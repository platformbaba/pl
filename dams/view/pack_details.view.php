<!-- CONTENT -->

<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>41,
							'relatedCType'=>0,
							'id'=>$aContent['packId'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
        <div class="input">
          <label for="input1">Pack Title</label>
          <div class='text-field-disabled'>
		  <?=$aContent['packName']?>
		  </div>
        </div>
		<div class="clearfix">
          <div class="input FL50">
            <label for="input1">Pack Desc</label>
            <div class='text-field-disabled'>
			<?=$aContent['packDescription']?>
			</div>
          </div>
		  <div class="input FL50">
			<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
		  </div>
		</div>	
        <div class="input FL50">
            <label for="select">Category</label>
            <div class='text-field-disabled'>
			<?php 
				echo ucwords($catList[$aContent['catIds']]->tag_name);
			?>
			</div>
         </div>
                
 	<div class="input">
          <label for="input1">Pack Albums</label>
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
          <label for="input1">Featured Artists</label>
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