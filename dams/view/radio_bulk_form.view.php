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
	
$pName = $_GET['pName'];
?>
 <!-- Search Box start -->
  <div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:818px;">
    <div class="title"> Upload bulk song .csv file <a class="toggle" href="#"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='POST' enctype="multipart/form-data">
	  
	  <!--<div class="clearfix">
			<div class="input">
			  <label for="input1">Radio Program <span class='mandatory'>*</span></label>
			  <select name="programId" id="programId">
			  <option value="" >Select Program </option>
			  <?php
				 /*foreach( $pData as $showData){				 
					 $sel = ($aContent['program_id']==$showData->program_id) ? 'selected="selected"' : '';
						echo "<option value=".$showData->program_id." ".$sel.">".$showData->program_name."</option>";
					}*/
			  ?>
			  </select>
		   
			</div>
	</div>-->
	   <div class="clearfix">
          <div class="input FL50">
            <label for="input">Upload File</label>
            <input type="file" id="csv" name="csv" value="" class="validate[required]"/><br><br>
				Program will generated automatically.
          </div>
		 <!-- <div class="input FL50">
            <label for="input">Download Sample .csv File</label>
            <a href="javascript:top.location='<?=MEDIA_SITEPATH_TEMP?>bulk/album_bulk.csv';" class="button">Download</a>
          </div>-->
        </div>
        <div class="submit" align='right'>
          <input type="submit" value="Submit" name="submitBtn" style='margin:0 auto' />
		  
		 <?php
		 if(isset($pName) && $pName!=''){
		  ?>
<input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>radio_addprogramsong?action=add&id=<?=$_GET['id'];?>&isPlane=1&do=addto&pName=<?=urlencode($_GET['pName']);?>'" />		 
		 <?php
		 }else{
		 ?>
		   <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>radio_addprogram?action=add&id=<?=$_GET['id'];?>&isPlane=1&do=addto&chName=<?=urlencode($_GET['chName']);?>'" />		   
		 <?php
		 }
		 ?>   
        </div>
        <div class="cb"></div>
      </form>
    </div>
  </div>
</div>
<!--            
    CONTENT End 
			-->
