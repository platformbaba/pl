<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>40,
							'relatedCType'=>0,
							'id'=>$aContent['stationId'],
							
						);
	echo TOOLS::displayViewTabsHtml( $aParam );
	//print_r($aContent);	
	?>
<div class="content">
			<div class="clearfix">
				<div class="input FL50">
					<label for="input2"> Radio Program :</label>
					<div class='text-field-disabled '><?=$aContent['radioProgram']?></div>
				</div>
				<div class="input FL50">
					<label for="input2"> Radio Channel :</label>
					<div class='text-field-disabled '>
					<?php
					foreach( $chData as $showData){				 
					 if($aContent['channelId']==$showData->station_id){ 
						echo $showData->name;
						break;
						}	
					}?></div>
				</div>
				</div>
			 
			<div class="clearfix"> 
				<div class="input FL50">
					<label for="input2"> Duration : </label>
					<div class='text-field-disabled '><?=$aContent['duration']?></div>
				</div>				
		</div>
    
</div>
</div>