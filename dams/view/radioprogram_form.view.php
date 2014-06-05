<!-- CONTENT --> 
<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#radioprogramFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
</script>
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/radiostationnew.jpg" alt="Radio Station" height="45px" width="45px" />Radio Program</h1>
<?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
#print_r($aContent);
?>
	<div class="bloc">
		<div class="title"><?=ucfirst($_GET['action'])?> Radio Program <div align="right"><span class='mandatory'>*&nbsp;</span>Mandatory Fields.</div></div>
		<div class="content">
		<form method="post" enctype="multipart/form-data" id="radioprogramFrm" name="radioprogramFrm">		
			<div class="clearfix">
				<div class="input FL50">
					<label for="input2"> Radio Program : <span class='mandatory'>*</span></label>
					<input type="text" name='radioProgram' value="<?=$aContent['radioProgram']?>" class="validate[required]"/>
				</div>
			<div class="input">
			  <label for="input1">Radio Channel <span class='mandatory'>*</span></label>
			  <select name="channelId" id="channelId">
			  <option value="" >Select Program </option>
			  <?php
				 foreach( $chData as $showData){				 
					 $sel = ($aContent['channel_id']==$showData->station_id) ? 'selected="selected"' : '';
						echo "<option value=".$showData->station_id." ".$sel.">".$showData->name."</option>";
					}
			  ?>
			  </select>		   
			</div>					
			</div>
	<div class="clearfix"> 		
		 <div class="input FL50">
            <label for="input4">Program Start Date</label>
            <input type="text" name="startDate" class="datepicker" id="startDate" value="<?=$aContent['startDate']?>"/>
          </div>
		 <div class="input FL50">
            <label for="input4">Program End Date</label>
            <input type="text" name="endDate" class="datepicker" id="endDate" value="<?=$aContent['endDate']?>"/>
          </div>
		  
	</div>	  
	<div class="col3 col3nW clearfix"> 		
		 <div class="input FL50"><p class="titleLab">Program Start Time</p>
            <span class="labcol">HH : <input type="text" name="startTimeH"  id="startTimeH" value="<?=$aContent['startTimeH']?>" style="width:19px;" maxlength="2"/></span><span class="labcol">MM :<input type="text" name="startTimeM"  id="startTimeM" value="<?=$aContent['startTimeM']?>" style="width:19px;" maxlength="2"/></span><span class="labcol">SS :<input type="text" name="startTimeS"  id="startTimeS" value="<?=$aContent['startTimeS']?>" style="width:19px;" maxlength="2"/></span>			
          </div> 
  
<div class="col3 col3nW clearfix"> 		
		 <div class="input FL50"><p class="titleLab">Program End Time</p>
            <span class="labcol">HH : <input type="text" name="endTimeH"  id="endTimeH" value="<?=$aContent['endTimeH']?>" style="width:19px;" maxlength="2"/></span><span class="labcol">MM :<input type="text" name="endTimeM"  id="endTimeM" value="<?=$aContent['endTimeM']?>" style="width:19px;" maxlength="2"/></span><span class="labcol">SS :<input type="text" name="endTimeS"  id="endTimeS" value="<?=$aContent['endTimeS']?>" style="width:19px;" maxlength="2"/></span>			
          </div>
		
	</div>	
	</div>         
			
			<div class="clearfix"> 
				<div class="input FL50">
					<label for="input2"> Duration : </label>
					<input type="test" name='duration' value="<?=$aContent['duration']?>"/>
				</div>
				
			</div>	
	    <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/radioprogram?action=view' " /> 
        </div>
		</form>
		</div>
	</div>
</div>