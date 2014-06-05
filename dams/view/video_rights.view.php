<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
	/* To show errorr */
	if( !empty($aSuccess) ){
		$aParam = array(
					'type' => 'success',
					'msg' => $aSuccess,
				 );
		TOOLS::showNotification( $aParam );
	}


//echo "<pre>";
//print_r($aContent);


$mBanner=new banner();
$bParams = array(
			'limit'	  => 100000,  
			'orderby' => 'ORDER BY banner_name ASC',  
			'start'   => 0,  
			'where'   => " AND status=1",
	   );
	   
  
 $bannerList=$mBanner->getAllBanners($bParams);		

	
if(!empty($aError) || $aContent['is_owned']==2)	
	$val =1;
else
	$val =0;
?>

<script>
$(document).ready(function(){ 

	var chk = document.getElementById('val').value;
	
    $("input[name$='Ctype']").click(function() {
        var chkVal = $(this).val();
         if(chkVal=="2"){
             $("#red").show();
			 $("#banner").prop("disabled", false);
        }else{
			$("#red").hide();
			$("#banner").prop("disabled", true);
		}	    	
    });
	
	if(chk==1){
	 $("#red").show();
	 $("#banner").prop("disabled", false);
	 }else{
 	 $("#red").hide();
	 $("#banner").prop("disabled", true);

	 }
});
</script>

<input type="hidden" id="val" value="<?=$val?>" />

<div class="bloc" style="margin-top:0px;">
    <div class="title"><?=ucfirst($_GET['action'])?> Video Rights<div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
    <div class="content">
	<form method="post" enctype="multipart/form-data" >
        <div class="clearfix">
			<div class="input FL50">
            	<label for="input2"> Owned ( SaReGaMa ) :</label>
				<?php 	
							if($aContent['is_owned']==1 && $aContent['is_owned']!=2)
								$isCtype1 = ($aContent['is_owned']==1)?'checked="checked"':'';
							else	
								$isCtype1 = ($aContent['is_owned']=='' && $aContent['is_owned']!=2)?'checked="checked"':'';
				?>

				<input type="radio" name="Ctype" value="1" <?=$isCtype1;?> />
        	</div>
			<div class="input FL50">
            	<label for="input2"> Acquired : </label>
				<?php 	

						$isCtype2 = ($aContent['is_owned']==2) ? 'checked="checked"':'';
				?> 
				<input type="radio" name="Ctype" value="2" <?=$isCtype2;?>  />
        	</div>
			<div class="clearfix">
				<div class="input FL50">
				<label for="input1">Banner : <span class='mandatory' id="red">*</span></label>
				
				<select  name="banner" id="banner"  >
				<option value='' >--Select Banner Name--</option>
				<?php
				foreach($bannerList as $kBanner){
				    $bSelect = ($aContent['banner_id']==$kBanner->banner_id)?'selected="selected"':'';
					echo '<option value='.$kBanner->banner_id.' '.$bSelect.'>'.$kBanner->banner_name.'</option>';
				
				}	
				?>
				</select>
				<p>(Banner will be disabled for Owned ( Saregama ) )</p>								
				
				</div>
			</div>
		<div class="clearfix">
			<div class="input FL50">
				<label for="input1">Territory : <span class='mandatory'>*</span></label>
				(Defines the Legal Territory Clarence, where this content can be Monetized.)
				<select name="territory[]" id="territory"  multiple="multiple" size="10" style="width:200px; height:200px;" class="validate[required]">
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

			<select name="territory_ex[]" id="territory_ex"  multiple="multiple" size="10" style="width:200px; height:200px;" class="validate[required]">	
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
			<div class="input FL50">
            	<label for="input2"> Start Date : <span class='mandatory'>*</span></label>
				<input type="text" name="StartDate" class="datepicker" id="StartDate" value="<?=$aContent['start_date']?>"/>
        	</div>
			<div class="input FL50 col2">
            	<div class="firstCol">
					<label for="input2"> End Date : </label>
					<input type="text" name="EndDate" class="datepicker" id="EndDate" value="<?=$aContent['end_date']?>"/>
				</div>
				<div class="secondCol">	
				
				<?php
					$chk_pre = ($aContent['end_date']=='0000-00-00' || $aContent['end_date']=='') ? 'checked="checked"' : ''; 
				 ?>
					<label for="input2">Perpetual:</label> <input type="checkbox" name='isCline' value=1 <?=$chk_pre;?>  />
				</div>
			</div>
		</div>
		<div class="clearfix">
			<div class="input FL50">
            	<label for="input2">Exclusive : </label>
				<?php 	
						$isExlclusive = ($aContent['is_exclusive']==1)?"checked":"";
				?>
				<input type="checkbox" name='isExlclusive' value='1' <?=$isExlclusive;?> />
        	</div>
			<div class="input FL50">
            	<label for="input2">Physical Rights :</label>
				<?php 	
						$isPhysical = ($aContent['physical_rights']==1)?"checked":"";
				?>
				<input type="checkbox" name='isPhysical' value='1' <?=$isPhysical;?> />
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
					 				
					echo '<span class="labcol"><label for="input2">'.$prVal.' :</label><input type="checkbox" name="pubRight[]" value="'.$prKey.'" '.$chk_pubRight.'/></span>';					
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

									
					echo '<span class="labcol"><label for="input2">'.$diValW.' :</label><input type="checkbox" name="digiRight[]" value="'.$diKeyW.'" '.$chk_digiRightW.'/></span>';					
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
									
					echo '<span class="labcol"><label for="input2">'.$diValM.' :</label><input type="checkbox" name="digiRight[]" value="'.$diKeyM.'" '.$chk_digiRightM.'/></span>';					
					}
				?>
			</div>		
			<div class="input FL50">&nbsp;</div>		
		</div>
		

	    <?php
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){
		?>
		<div class="submit">
            <input type="submit" value="Submit" name="submitBtn" class="black"/>
			<input type="hidden" name="refferer" value="<?=$_SERVER["HTTP_REFERER"]?>" />
			<input type="hidden" name="videoRightId" value="<?=$aContent['is_owned']?>" />
        </div>
		<?php } ?>
	</form>
    </div>
</div>
</div>