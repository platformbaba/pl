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
	
#print_r($aContent);
?>
  <div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:818px;">
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Program</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
 		<div class="clearfix">
			<div class="input">
			  <label for="input1">Radio Program <span class='mandatory'>*</span></label>
			 <input type="text" name='radioProgram' value="<?=$_GET['chName'];?>" class="validate[required]"/>	
		   
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
			<div class="clearfix"> 
				<div class="input FL50">
					<label for="input2"> Duration : </label>
					<input type="test" name='duration' value="<?=$aContent['duration']?>"/>
				</div>
	</div>         
        <div class="submit">
		 
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>radio_addprogram?action=add&id=<?=$_GET['id']; ?>&isPlane=1&do=addto&chName=<?=urlencode($_GET['chName']);?>'" /> 
        </div>
      </form>
    </div>
  </div>
</div>