<style>
.sortable li {
	list-style: none;
	border: 1px solid #CCC;
	background: #F6F6F6;
	color: #1C94C4;
	margin: 5px;
	padding: 5px;
	height: 22px;
}
</style>
<!-- CONTENT -->
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>29,
							'relatedCType'=>0,
							'id'=>$aContent['playlistId'],
							'back'=>$_GET['back']
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="clearfix">
		<div class="input FL50">
          <label for="input1">Playlist Title :</label>
          <div class='text-field-disabled'>
		  <?=$aContent['playlistName']?>
		  </div>
        </div>
		</div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="select">Language :</label>
            <div class='text-field-disabled'>
			<?=$aContent['languageName']?>
			</div>
          </div>
		  <div class="input FL50">
            <label for="input1">Image :</label>
            <div style="width:140px; padding-top:2px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$aContent['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
          </div>
        </div>
		<div class="clearfix">
		<div class="input FL50">
          <label for="input1">Contents :</label>
		  <ul class="sortable list" id="sortable-with-handles">
          <?php
										$songBox="";
										$songHidden="";
										if($aContent['songId']){
											$songHidden=$aContent['songId'].",";;
											if($aContent['songNameArr']){
												$r=1;
												foreach($aContent['songNameArr'] as $kStar=>$vStar){
												?>	
													<li draggable="true" class="" style="display: list-item;" id="li_<?=$r?>">
													<?=$r?> ::
													<?=$vStar;?>
													<a title="Remove this content" href="javascript:void(0)" style="float:right" onclick="removeThis('li_<?=$r?>')"></a>
													<?php
														if($aContent['songImageArr'][$kStar]){
													?>
													<a href="<?=MEDIA_SITEPATH_IMAGE.$aContent['songImageArr'][$kStar]?>" style="float:right" class="zoombox" title="view"><img src="<?=IMGPATH?>icons/eye.png" width="20" height="20"  /></a>
													<?php	}
													?>
													</li>
											<?php
													$r++;
												}
											}
										}	
									?>
		  </ul>							
        </div>
		</div>
      </form>
    </div>
  </div>
</div>