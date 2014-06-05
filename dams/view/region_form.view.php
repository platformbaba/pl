<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Region</h1>
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
<div class="bloc">
    <div class="title"><?=ucfirst($_GET['action'])?> Region</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Region Name <span class='mandatory'>*</span></label>
            <input type="text" id="regionName" name="regionName" value="<?=$aContent['regionName']?>" />
        </div>
        		
       <div class="input">
            <label for="select">Languages </label>
            <select name="languageId[]" id="select" multiple="multiple" size="5" style=" width:165px;">
				<?php
					foreach($data['languageList'] as $rKey=>$rValue){
				?>
		                <option value="<?=$rValue->language_id?>" <?=in_array($rValue->language_id,(array)$data['aContent']['languageId'])?"selected='selected'":""?>><?php echo ucfirst($rValue->language_name);?></option>
				<?php
					}
				?>		
            </select>
        </div>
	    <div class="submit">
            <input type="submit" value="Submit" name="submitBtn" />
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/region?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>