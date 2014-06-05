<!--            
    CONTENT 
			-->

<div id="content">
<div>
  <span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Deployment Audit Report</h1></span>
  <br class='clear' />	
</div>
  <?php
		/* To show errorr */
		if( !empty($aError) ){
			$aParam = array(
						'type' => 'error',
						'msg' => $aError,
					 );
			TOOLS::showNotification( $aParam );
		}

		/* To show success */
		if( !empty($aSuccess) || ( isset($_GET['msg']) && $_GET['msg'] != '') ){
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ $aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
  <!-- Search Box start -->
  <div class="bloc">
    <div class="title"> Search Filters: <a class="toggle" href="#"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='GET' >
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Song Title :</label>
			<input type="text" id="srcSong" name="srcSong" value="<?php echo $aSearch['srcSong']; ?>" class="autosuggestsong WD150" />
          	<input type="hidden" name="autosuggestsong_hddn" id="autosuggestsong_hddn" value="<?php echo $aSearch['autosuggestsong_hddn']; ?>"  />
          </div>
		  <div class="input FL PR30">
            <label for="input">ISRC :</label>
            <input type="text" id="srcIsrc" name="srcIsrc" value="<?php echo $aSearch['srcIsrc']; ?>" class="WD150" />
          </div>
		  <div class="input FL PR30">
            <label for="input">Start Date :</label>
            <input type="text" id="srcSrtDate" name="srcSrtDate" value="<?php echo $aSearch['srcSrtDate']; ?>" class="datepicker" />
          </div>
		  <div class="input FL PR30">
            <label for="input">End Date :</label>
            <input type="text" id="srcEndDate" name="srcEndDate" value="<?php echo $aSearch['srcEndDate']; ?>" class="datepicker" />
          </div>
          <div class="input FL PR30">
			<label for="input">Deployment :</label>
            <select name="srcDepType" id="select">
				    <?php
					$n=0; 
					$options="";
					foreach($aConfig['deployments'] as $type_id=>$type_name){
						$selStr = ($aSearch['srcDepType']==$type_name)?"selected='selected'":"";
						if ($this->user->hasPrivilege(strtolower($aConfig['module'][$type_id])."_view")){
							$options .= '<option value="'.$type_name.'" '.$selStr.' >'.$aConfig['module'][$type_id].'</option>';
							$n++;
						}
					}
					if($n==sizeof($aConfig['deployments'])){
						echo '<option value="">Select Deployment</option>';
					}
					echo $options;
				?>
            </select>
 		  </div>
		</div>
        <div class="clearfix">
		<div class="input FL PR30">
			<label for="input">Editors:</label>
			<select name="srcUser" id="srcUser" >
				<option value="">Select</option>
				<?php
					foreach( $aEditors as $k=>$edt ){
						$check = ($_GET['srcUser']==$edt->id ? 'selected':'');
						echo '<option value="'.$edt->id.'" '.$check.'>'.$edt->name.'</option>';
					} 
				?>
			</select>
		</div>
		</div>
		<div class="submit" align='right'>
          <input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
        </div>
        <div class="cb"></div>
      </form>
    </div>
  </div>
  <!-- Search Box end -->
  <div class="bloc">
    <div class="title"> Song Lists </div>
    <div class="content">
      <form id='actFrm' name='actFrm' method="POST" onsubmit="return checkCheckbox();">
        <table>
          <thead>
            <tr>
              <th>Song Name</th>
              <th>ISRC</th>
			  <th>Deployment</th>
			  <th>Deployment Name</th>
			  <th>Editor</th>
			  <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
			?>
            <tr>
              <!--<td><?php echo $showData->content_id; ?></td>-->
              <td><?php echo $showData->title; ?></td>
			  <td><?php echo $showData->isrc; ?></td>
			  <td><?php echo $showData->service_provider; ?></td>
			  <td><?php echo $showData->deployment_name; ?></td>
			  <td><?php echo $showData->name; ?></td>
			  <td><?php echo $showData->update_date; ?></td>
            </tr>
            <?php
					} /* foreach end */
				}else{
						echo '<tr>
								<td colspan=6>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
          </tbody>
        </table>
        <br/>
      </form>
      <div class="pagination">
        <?php
			echo $sPaging;
		?>
      </div>
    </div>
  </div>
  <form id='actionFrm' name='actionFrm' method="POST">
    <input type="hidden" id="contentId" name="contentId" value="">
    <input type="hidden" id="contentAction" name="contentAction" value="">
    <input type="hidden" id="contentModel" name="contentModel" value="">
  </form>
</div>
<!--  CONTENT End -->
<script type="text/javascript">
var albumOptions, albumautocom;
	jQuery(function(){
	  albumOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Album', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestalbum"};
	  albumautocom = $('.autosuggestalbum').autocomplete(albumOptions);
	});
var artistOptions, artistautocom;
	jQuery(function(){
	  artistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=', minChars:2, width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestartist"};
	  artistautocom = $('.autosuggestartist').autocomplete(artistOptions);
	});
var songOptions, songautocom;
	jQuery(function(){
	  songOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=song', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestsong"};
	  songautocom = $('.autosuggestsong').autocomplete(songOptions);
	});
function addToDeployment(obj){
	var r=confirm("Are you sure?")
	if (r==true){
	}	
}
function checkCheckbox(){
	var r=confirm("Are you sure?")
	if (r==true){
		var fields = $("input[name='select_ids[]']").serializeArray(); 
		if (fields.length == 0) 
		{ 
			alert('Please select atleast one song!'); 
			// cancel submit
			return false;
		} 
		else 
		{ 
			actFrm.submit(); 
		}
	}
}
/*$("#actFrm").submit(checkCheckbox);*/
</script>		