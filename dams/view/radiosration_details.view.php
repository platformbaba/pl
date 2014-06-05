<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>39,
							'relatedCType'=>0,
							'id'=>$aContent['stationId'],
							
						);
	echo TOOLS::displayViewTabsHtml( $aParam );
//	print_r($aContent);	
	?>
<div class="content">
			<div class="clearfix">
				<div class="input FL50">
					<label for="input2"> Radio Station Title :</label>
					<div class='text-field-disabled '><?=$aContent['radioName']?></div>
				</div>
				<div class="input FL50">
				<label for="select">Language :</label>
				<div class='text-field-disabled '>
					<?php 
						foreach($languageList as $kL=>$vL){
							if($aContent['languageIds']==$vL->language_id){
							echo ucwords($vL->language_name);	
								break;							
								
							}	
						
						}
					?>
			</div>
			</div>
			</div>
			<div class="clearfix">
			<div class="input FL50">
				<label for="input1">Artist :  </label>
				<div class='text-field-disabled '><?=$aContent['artistName'];?></div>	
			  </div>
				<div class="input FL50">
				<label for="input1">Station Type : </label>	
				<div class='text-field-disabled '><?=$legal = ($aContent['RadioType']=='A') ? 'Artist station' : 'Standard station' ; ?></div>			
											
				</div>				
			 </div> 
			<div class="clearfix"> 
				<div class="input FL50">
					<label for="input2"> Preview Url : </label>
					<div class='text-field-disabled '><?=$aContent['previewUrl']?></div>
				</div>
				<div class="input FL50">
					<label for="input2"> Content Url : </label>
					<div class='text-field-disabled '><?=$aContent['contentUrl']?></div>
				</div>
			</div>	

<div class="input">
			
				<div style="width:140px; padding-top:20px;" class="picture"><a class="zoombox" id="oPicZoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;" id="oPicImg"></a></div>
</div>			
				<div class="input textarea">
					<label for="textarea2">Description : </label>
					<div class='text-field-disabled '><?=$aContent['description']?></div>
				</div>
		</div>
    
</div>
</div>