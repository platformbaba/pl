<!--            
    CONTENT 
			-->

<div id="content">
<div>
  <span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/song_icon.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'reliance-audio-deployment?action=add" title="Add New" class="button">Add New</a>'; } ?>
	</span>
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
    <div class="title"> Search Songs Filters: <a class="toggle" href="#"></a></div>
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
            <label for="input">Album :</label>
            <input type="text" id="srcAlbum" name="srcAlbum" value="<?php echo $aSearch['srcAlbum']; ?>" class="autosuggestalbum WD150"/>
			<input type="hidden" name="autosuggestalbum_hddn" id="autosuggestalbum_hddn" value="<?php echo $aSearch['autosuggestalbum_hddn']; ?>"  />
          </div>
		  <div class="input FL PR30">
            <label for="input">Artist :</label>
            <input type="text" id="srcArtist" name="srcArtist" value="<?php echo $aSearch['srcArtist']; ?>" class="autosuggestartist WD150"/>
			<input type="hidden" name="autosuggestartist_hddn" id="autosuggestartist_hddn" value="<?php echo $aSearch['autosuggestartist_hddn']; ?>"  />
          </div>
          <div class="input FL PR30">
			<label for="input">Song Id :</label>
            <input type="text" id="srcSongId" name="srcSongId" value="<?php echo $aSearch['srcSongId']; ?>" class="WD150"/>
		  </div>
		</div>
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=(int)$_GET['id']?>" />
		<input type="hidden" name="do" value="song" />
		   
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
              <th><input type="checkbox" class="checkall"/></th>
              <th>Id</th>
              <th>Song Name</th>
              <th>ISRC</th>
              <!--<th>Actions</th>-->
            </tr>
          </thead>
          <tbody>
            <?php
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
			?>
            <tr>
              <td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->song_id, 'status'=>$showData->status, 'model'=>'song' ) ); ?></td>
              <td><?php echo $showData->song_id; ?></td>
              <td>
				<a href="<?=SITEPATH?>song?action=view&id=<?=$showData->song_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Song Details"><?php echo $showData->song_name; ?></a>
			  </td>
			  <td><?php echo $showData->isrc; ?></td>
              <!--<td class="actions">
			  	<div class="submit" align='right'>
			  		<input type="button" value="Add to Deployment" name="deployBtn" onclick="addToDeployment({'id':'<?=$showData->song_id?>','did':<?=$_GET['id']?>})" style='margin:0 auto' />
				</div>	
              </td>-->
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
		<div class="submit clearfix" align='left'>
			<input type="submit" value="Add Selected to Deployment" name="deployBtn" style='margin:0 auto' />
		</div>
		<input type="hidden" name="deploymentId" value="<?=(int)$_GET['id']?>" />
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