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
?>
  <div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:818px;">
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Program Songs </div>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
 		<div class="clearfix">
			<div class="input FL50">
			  <label for="input1">ISRC<span class='mandatory'>*</span></label>
			   <input type="text" name="isrc"  id="isrc" value="<?=$aContent['isrc']?>" />		 		   
			</div>
		  <!--<div class="input FL50">
            <label for="input">Upload File</label>
           OR&nbsp;&nbsp;&nbsp; <input type="file" id="csv" name="csv" value="" class="validate[required]"/>
		   <br><br>&nbsp;&nbsp;&nbsp;Upload bulk song .csv file
          </div>-->	
		</div>
	<div class="clearfix"> 		
		 <div class="input">
            <label for="input4">File</label>
            <input type="text" name="file"  id="file" value="<?=$aContent['file']?>"/>
          </div>	  
	</div>
	<div class="clearfix"> 
		 <div class="input">
            <label for="input4">Type</label>
			<select name="sType" id="" >
			<option value="" >Select Song Type</option>
			<?php
			 	foreach($aConfig['radioSongType'] as $tKey=>$tVal){
				$sel = (strtolower($aContent['sType']) == strtolower($tVal)) ? 'selected="selected"' : '';
				echo '<option value='.$tVal.' '.$sel.'>'.$tVal.'</option>';				
				}
			?>
			<select>
    </div>
          </div>			         
        <div class="submit">		 
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '<?=SITEPATH?>radio_addprogramsong?action=add&id=<?=$_GET['id']; ?>&isPlane=1&do=addto&pName=<?=urlencode(strtolower($_GET['pName']));?>'" /> 
        </div>
      </form>
    </div>
  </div>
</div>