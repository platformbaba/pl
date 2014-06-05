<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>21,
							'relatedCType'=>0,
							'id'=>$aContent['catalogueId'],
							
						);
	echo TOOLS::displayViewTabsHtml( $aParam );
	#print_r($aContent);	
	?>
			<div class="input FL50">
            	<label for="input2"> Owned ( SaReGaMa ) :</label>
				<?php 	
							
				$isCtype = ($aContent['is_owned']==1)?'checked="checked"':'';
							
				?>

				<input type="radio" disabled="disabled" name="Ctype" value="1" <?=$isCtype;?> />
        	</div>
			<div class="input FL50">
            	<label for="input2"> Acquired : </label>
				<?php 	
							
				$isCtype2 = ($aContent['is_owned']==2)?'checked="checked"':'';
							
				?>

				<input type="radio" disabled="disabled" name="Ctype" value="2" <?=$isCtype2;?>  />
        	</div>	
    <div class="content">
	   <div class="clearfix">
			<div class="input FL50">
            	<label for="input2"> Catalogue Title : </label>
				<div class='text-field-disabled'>
				<?=$aContent['catalogueName']?>
				</div>
        	</div>
		</div>
		
		<?php
		if(!empty($aContent['banner_name'])){
		?>
			<div class="clearfix">
				<div class="input FL50">
				<label for="input1">Banner : </label>
				
				<div class='text-field-disabled'>
				<?=$aContent['banner_name'];?>
				</div>							
				
				</div>
			</div>		
		<?php
		 }
		?>	
			
		<div class="clearfix">
			<div class="input FL50">
            	<label for="input2"> Agreement Id : </label>
				<div class='text-field-disabled'>
				<?=$aContent['agreementId']?>
				</div>
        	</div>
			<div class="input FL50">
				<label for="input1">Agreement File : </label>
				<a href="<?=TOOLS::getDoc(array('doc'=>$aContent['agreementFile']))?>" target="_blank"><?=$aContent['agreementFile']?></a>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
            	<label for="input2">Start Date : </label>
				<div class='text-field-disabled'>
				<?=$aContent['start_date']?>
				</div>
        	</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
            	<label for="input2"> End Date : </label>
				<div class='text-field-disabled'>
				<?=$aContent['end_date']?>
				</div>
        	</div>
			</div>
			<div class="clearfix">
			<div class="input FL50">
				<label for="input1">Territory :</label>
				<select  disabled="disabled" id="territory"  multiple="multiple" size="10" style="width:200px; height:200px;">
			<?php 
			
					foreach($aConfig['countries'] as $trrKay=>$trrVal){
					
								if(in_array($trrKay,explode(',',$aContent['territory_in'])))
									echo '<option value="'.$trrKay.'" selected="selected">'.ucwords($trrVal).'</option>';
								else	
									echo '<option value="'.$trrKay.'">'.ucwords($trrVal).'</option>';
						}
				
					
				?>
			  </select>
			  
			</div>
		<div class="input FL50">
				<label for="input1">Exclude : </label>

			<select disabled="disabled" id="territory_ex"  multiple="multiple" size="10" style="width:200px; height:200px;" class="validate[required]">	
				<?php
						
					foreach($aConfig['countries'] as $trrKay=>$trrVal){
						if($trrKay!=0)
						
						if(in_array($trrKay,explode(',',$aContent['territory_ex'])))
							echo '<option value="'.$trrKay.' "selected="selected">'.ucwords($trrVal).'</option>';
						else
							echo '<option value="'.$trrKay.'">'.ucwords($trrVal).'</option>';	
						
						}
	
				?>
			 </select>	
			</div>	
			</div>			
		<div class="clearfix">
			<div class="input textarea">
            	<label for="textarea2">Internal Contact Details : </label>
				<div class='text-field-disabled'>
				<?=htmlentities($aContent['internalContactDetails'])?>
				</div>
        	</div>
		</div>
		<div class="clearfix">
			<div class="input textarea">
            	<label for="textarea2"> Contact Details : </label>
				<div class='text-field-disabled'>
				<?=htmlentities($aContent['contactDetails'])?>
				</div>
        	</div>
		</div>
		
		<div class="clearfix">
			<div class="input FL50">
            	<label for="input2">Exclusive : </label>
				<?php 	
						$isExlclusive = ($aContent['is_exclusive']==1)?"checked":"";
				?>
				<input type="checkbox" disabled = "disabled"  name='isExlclusive' value='1' <?=$isExlclusive;?> />
        	</div>
			<div class="input FL50">
            	<label for="input2">Physical Rights :</label>
				<?php 	
						$isPhysical = ($aContent['physical_rights']==1)?"checked":"";
				?>
				<input type="checkbox" disabled = "disabled" name='isPhysical' value='1' <?=$isPhysical;?> />
        	</div>
		</div>
		<div class="col3 clearfix">	
			<div class="input FL50"><p class="titleLab">Publishing Rights :</p>	
				<?php
				foreach($aConfig['publishing_rights'] as $prKey=>$prVal){
					
						$chk_pubRight = '';	
					 if(($aContent['publishing_rights'])!='' && isset($aContent['publishing_rights'])){
						$chk_pubRight = (in_array($prKey,explode('|',$aContent['publishing_rights']))) ? "checked" : "";
					 }	
					 				
					echo '<span class="labcol"><label for="input2">'.$prVal.' :</label><input type="checkbox" disabled = "disabled" name="pubRight[]" value="'.$prKey.'" '.$chk_pubRight.'/></span>';					
				}
				?>
			</div>		
			<div class="input FL50">&nbsp;</div>		
		</div>
		<div class="col3 clearfix">	
			<div class="input FL50"><p class="titleLab">Digital Rights ( Web ):</p>	
				<?php
					foreach($aConfig['digital_rights']['web'] as $diKeyW=>$diValW){	
					
						$chk_digiRightW = '';
					 if(($aContent['digital_rights'])!='' && isset($aContent['digital_rights'])){
						$chk_digiRightW = (in_array($diKeyW,explode('|',$aContent['digital_rights'])) && isset($aContent['digital_rights'])) ? "checked" : "";
					 }	

									
					echo '<span class="labcol"><label for="input2">'.$diValW.' :</label><input type="checkbox" disabled = "disabled" name="digiRight[]" value="'.$diKeyW.'" '.$chk_digiRightW.'/></span>';					
					}
				?>
			</div>		
			<div class="input FL50">&nbsp;</div>		
		</div>
		<div class="col3 clearfix">	
			<div class="input FL50"><p class="titleLab">Digital Rights ( Mobile ):</p>	
				<?php
				
					foreach($aConfig['digital_rights']['mobile'] as $diKeyM=>$diValM){	
						$chk_digiRightM  ='';
					 if(($aContent['digital_rights'])!='' && isset($aContent['digital_rights'])){
						$chk_digiRightM = (in_array($diKeyM,explode('|',$aContent['digital_rights'])) && isset($aContent['digital_rights'])) ? "checked" : "";
					 }	
									
					echo '<span class="labcol"><label for="input2">'.$diValM.' :</label><input type="checkbox" disabled = "disabled" name="digiRight[]" value="'.$diKeyM.'" '.$chk_digiRightM.'/></span>';					
					}
				?>
			</div>		
			<div class="input FL50">&nbsp;</div>		
		</div>

</div>
</div>
</div>