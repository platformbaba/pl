<!--            
    CONTENT 
			-->
<div id="content">
<div>
  <span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/song_icon.png" alt="" width='40' height='40'/>Manage Song</h1></span>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'song?action=add" title="Add New" class="button">Add New</a>'; } ?>
	</span>
	<span  style="float: left; margin-top: 4%; margin-left: 1%;" >
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){?>
				<a class="button" href="<?=SITEPATH?>song?action=view&do=qclist" title="<?=(int)$qcPendingTotal?>">QC pending(<?=(int)$qcPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){?>	
				<a class="button" href="<?=SITEPATH?>song?action=view&do=legallist" title="<?=(int)$legalPendingTotal?>">LEGAL pending(<?=(int)$legalPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){?>
				<a class="button" href="<?=SITEPATH?>song?action=view&do=publishlist" title="<?=(int)$publishPendingTotal?>">Final Approval pending(<?=(int)$publishPendingTotal?>)</a>
			<?php }?>
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
<?php
	if($_GET['do']!="qclist" && $_GET['do']!="legallist"  &&$_GET['do']!="publishlist" ){
?>		
  <!-- Search Box start -->
  <div class="bloc">
    <div class="title"> Search Filters: <a class="toggle" href="#"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='GET'>
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Song Title :</label>
            <input type="text" id="srcSong" name="srcSong" value="<?php echo $aSearch['srcSong']; ?>" class="autosuggestsong WD150" onblur="cms.clearHiddenField('srcSong','autosuggestsong_hddn')" />
			<input type="hidden" name="autosuggestsong_hddn" id="autosuggestsong_hddn" value="<?php echo $aSearch['autosuggestsong_hddn']; ?>"  />
          </div>
          <div class="input FL PR30">
            <label for="input">Status :</label>
            <select name="srcCType" id="srcCType" >
              <option value="">Select</option>
              <?php
						$actionArr = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'legal') );
						foreach( $actionArr as $k=>$act ){
							$check = ($aSearch['srcCType']==$act ? 'selected':'');
							echo '<option value="'.$act.'" '.$check.'>'.ucwords($act).'</option>';
						} 
					?>
            </select>
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
            <input type="text" id="srcEndDate" name="srcEndDate" value="<?php echo $aSearch['srcEndDate']; ?>" class="datepicker"/>
          </div>
        </div>
		<div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Languge :</label>
            <select name="srcLang" id="srcLang" >
              <option value="">Select</option>
              <?php
						foreach($aSearch['languageList'] as $act ){
							$check = ($aSearch['srcLang']==$act->language_id ? 'selected':'');
							echo '<option value="'.$act->language_id.'" '.$check.'>'.$act->language_name.'</option>';
						} 
					?>
            </select>
          </div>
		  <div class="input FL PR30">
            <label for="input">Album :</label>
            <input type="text" id="srcAlbum" name="srcAlbum" value="<?php echo $aSearch['srcAlbum']; ?>" class="autosuggestalbum WD150" onblur="cms.clearHiddenField('srcAlbum','autosuggestalbum_hddn')" />
			<input type="hidden" name="autosuggestalbum_hddn" id="autosuggestalbum_hddn" value="<?php echo $aSearch['autosuggestalbum_hddn']; ?>"  />
          </div>
		  <div class="input FL PR30">
            <label for="input">Artist :</label>
            <input type="text" id="srcArtist" name="srcArtist" value="<?php echo $aSearch['srcArtist']; ?>" class="autosuggestartist WD150" onblur="cms.clearHiddenField('srcArtist','autosuggestartist_hddn')" />
			<input type="hidden" name="autosuggestartist_hddn" id="autosuggestartist_hddn" value="<?php echo $aSearch['autosuggestartist_hddn']; ?>"  />
          </div>
		  <div class="input FL PR30">
            <label for="input">Tags :</label>
            <select name="srcTag" id="srcTag" onchange="setTagValue(this.value)" >
              <option value="">Select</option>
              <?php
						foreach( $aSearch['tagsList'] as $k=>$act ){
							$check = ($aSearch['srcTag']==$act->tag_id ? 'selected':'');
							echo '<option value="'.$act->tag_id.'" '.$check.'>'.$act->tag_name.'</option>';
						} 
					?>
            </select>
          </div>
		  <div class="input FL PR30">
            <label for="input">Related to tag :</label>
            <input type="text" id="srcRtTag" name="srcRtTag" value="<?php echo $aSearch['srcRtTag']; ?>" class="autosuggesttag WD150" onblur="cms.clearHiddenField('srcRtTag','autosuggesttag_hddn')" />
			<input type="hidden" name="autosuggesttag_hddn" id="autosuggesttag_hddn" value="<?php echo $aSearch['autosuggesttag_hddn']; ?>"  />
          </div>
        </div>
		<div class="clearfix">
          <div class="input FL PR30">
			<label for="input">Song Id :</label>
            <input type="text" id="srcSongId" name="srcSongId" value="<?php echo $aSearch['srcSongId']; ?>" class="WD150"/>
		  </div>
		  <div class="input FL PR30">
            <label for="input">Song Edits Config :</label>
            <select name="srcSongEditId" id="srcSongEditId" >
              <option value="">Select</option>
              <?php
						foreach( $aEditConfig as $k=>$act ){
							$check = ($aSearch['srcSongEditId']==$act['data']->song_edit_id ? 'selected':'');
							echo '<option value="'.$act['data']->song_edit_id.'" '.$check.'>'.$act['str'].'</option>';
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
<?php
}
?>  
  <div class="bloc">
    <div class="title"> Song Lists <b class='sCount'>(<?=$iTotalCount?>)</b></div>
   	<?php if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){?>
		<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>playlist?action=add&song_id=multi&isPlane=1&do=addto&ctype=4" class="fancybox fancybox.iframe button" title="Add to playlist">Add selected songs to playlist</a>
		</div>
	<?php }?>
	<div class="content">
      <form id='actFrm' name='actFrm' method="POST">
        <table>
          <thead>
            <tr>
              <th><input type="checkbox" class="checkall"/></th>
              <!-- th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"song_id")); ?>" title="click to sort">Id</a></th -->
			  <th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"song_name")); ?>" title="click to sort">Song Name</a></th>
              <th>ISRC</th>
			  <th>Album</th>
			  <th>Artist</th>
              <th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"insert_date")); ?>" title="click to sort">Insert Date</a></th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
			?>
            <tr>
              <td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->song_id, 'status'=>$showData->status, 'model'=>'song', 'flow'=>'legal' , 'obj'=>$this) ); ?></td>
              <!-- td><?php echo $showData->song_id; ?></td -->
              <td>
				<a title='Preview Song' href="JavaScript:void('');" onclick="return cms.playSongPreview('<?=TOOLS::getSongPlayUrl( array('isrc'=>$showData->isrc, 'song_id'=>$showData->song_id, 'f_type'=>'mp4' , 'song_file' => $showData->audio_file ) );?>','lhs')"><img src="<?=IMGPATH?>blue_play.png" height="20px" width="20px" alt="Preview Song" /></a>
				<!-- a title='<?php echo $showData->song_name; ?>' href="<?=TOOLS::getSongPlayUrl( array('isrc'=>$showData->isrc, 'song_id'=>$showData->song_id, 'f_type'=>'mp4') );?>" class="htrack"></a -->
				<a href="<?=SITEPATH?>song?action=view&id=<?=$showData->song_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Song Details"><?php echo $showData->song_name; ?></a>
			  </td>
			  <td><?php echo $showData->isrc; ?></td>
			  <td><?php echo ucwords(strtolower($showData->album_name)); ?></td>
              <td><?php echo $showData->artist_name; ?></td>
			  <td><?php echo substr($showData->insert_date,0,10); ?></td>
              <td class="actions" style=" width:150px">
			  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){ ?>
						<a href="<?=SITEPATH?>song?action=view&id=<?=$showData->song_id?>&isPlane=1&do=rights" class="fancybox fancybox.iframe" title="Manage Song Rights"><img src="<?=IMGPATH?>icons/legal_right.png" height="20px" width="20px" alt="Manage Song Rights"  /></a>
			<?php }
				  	if($this->user->hasPrivilege("playlist_add") || $this->user->hasPrivilege("playlist_edit")){
				  ?>		 
				  <a href="<?=SITEPATH?>playlist?action=add&song_id=<?php echo $showData->song_id; ?>&isPlane=1&do=addto&song_name=<?php echo urlencode($showData->song_name); ?>&ctype=4" class="fancybox fancybox.iframe" title="Add to playlist"><img src="<?=IMGPATH?>icons/playlist-add.png" alt="Add to playlist"  /></a>
				  <?php
				  }
				  ?>
				  <a href="<?=SITEPATH?>song?action=view&id=<?php echo $showData->song_id; ?>&isPlane=1&do=lyrics&song_name=<?php echo urlencode($showData->song_name); ?>" class="fancybox fancybox.iframe" title="Manage Song Lyrics"><img src="<?=IMGPATH?>icons/lyrics.png" height="20px" width="20px" alt="Manage Song Lyrics"  /></a>
				  <!-- a href="<?=SITEPATH?>related?action=view&id=<?=$showData->song_id?>&isPlane=1&cType=4&relatedCType=15" class="fancybox fancybox.iframe" title="Manage Contents"><img src="<?=IMGPATH?>icons/content.png"  alt="Manage Contents"  height="20px" width="20px"/></a -->
				  <a href="<?=SITEPATH?>song?action=view&do=showedits&id=<?=$showData->song_id?>&song_name=<?php echo urlencode($showData->song_name); ?>&isPlane=1&isrc=<?=strtoupper($showData->isrc)?>" class="fancybox fancybox.iframe" title="Manage Edits"><img src="<?=IMGPATH?>icons/edits.png" height="20px" width="20px"  alt="Manage Edits"  /></a>
				  <?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->song_id, 'status'=>$showData->status, 'model'=>'song', 'flow'=>'legal' ) ); ?>
              </td>
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
        <?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->song_id, 'status'=>$showData->status, 'model'=>'song', 'flow'=>'legal' ) ); ?>
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
var songOptions, songautocom;
	jQuery(function(){
	  songOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=song', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestsong"};
	  songautocom = $('.autosuggestsong').autocomplete(songOptions);
	});
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
function setTagValue(id){
	var tagOptions, tagautocom;
	tagOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id='+id+'&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggesttag"};
	tagautocom = $('.autosuggesttag').autocomplete(tagOptions);
}			
</script>	
	