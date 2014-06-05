<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/mAlbum.png" alt=""  height="45px" width="45px" />Manage Albums</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'album?action=add" title="Add New" class="button">Add New</a>'; } ?>
		</span>
		<span  style="float: left; margin-top: 4%; margin-left: 1%;" >
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_qc")){?>
				<a class="button" href="<?=SITEPATH?>album?action=view&do=qclist" title="<?=(int)$qcPendingTotal?>">QC pending(<?=(int)$qcPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_legal")){?>	
				<a class="button" href="<?=SITEPATH?>album?action=view&do=legallist" title="<?=(int)$legalPendingTotal?>">LEGAL pending(<?=(int)$legalPendingTotal?>)</a>
			<?php }?>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_publish")){?>
				<a class="button" href="<?=SITEPATH?>album?action=view&do=publishlist" title="<?=(int)$publishPendingTotal?>">Final Approval pending(<?=(int)$publishPendingTotal?>)</a>
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
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ 
			$aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
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
            <label for="input">Album Title :</label>
            <input type="text" id="srcAlbum" name="srcAlbum" value="<?php echo $aSearch['srcAlbum']; ?>" class="autosuggestalbum WD150" onblur="cms.clearHiddenField('srcAlbum','autosuggestalbum_hddn')" />
			<input type="hidden" name="autosuggestalbum_hddn" id="autosuggestalbum_hddn" value="<?php echo $aSearch['autosuggestalbum_hddn']; ?>"  />
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
            <label for="input">Catalogue :</label>
            <select name="srcClgue" id="srcClgue" >
              <option value="">Select</option>
              <?php
						foreach($aSearch['catalogueList'] as $act ){
							$check = ($aSearch['srcClgue']==$act->catalogue_id ? 'selected':'');
							echo '<option value="'.$act->catalogue_id.'" '.$check.'>'.$act->catalogue_name.'</option>';
						} 
					?>
            </select>
          </div>
		  
		  <div class="input FL PR30">
			<label for="input">Album Id :</label>
            <input type="text" id="srcAlbumId" name="srcAlbumId" value="<?php echo $aSearch['srcAlbumId']; ?>" class="WD150"/>
		  </div>
        </div>
		<div class="clearfix">
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
		  
		  <div class="input FL PR30">
            <label for="input">Label :</label>
            <select name="srcLbl" id="srcLbl" >
              <option value="">Select</option>
              <?php
						foreach($aSearch['labelList'] as $act ){
							$check = ($aSearch['srcLbl']==$act->label_id ? 'selected':'');
							echo '<option value="'.$act->label_id.'" '.$check.'>'.$act->label_name.'</option>';
						} 
					?>
            </select>
          </div>
<div class="input FL PR30">

            <label for="input">Content Types :</label>
            <select name="album_content_type" >
              <option value="">Select</option>
             <?php
					foreach($aConfig['album_content_type'] as $kkk=>$vvv ){
							$selectstr = '';
							if( ($aSearch['album_content_type']&$kkk)==$kkk ){ $selectstr='selected'; }
							
						echo "<option value='".$kkk."' ".$selectstr.">".$vvv."</option>";
					}
				?>
            </select>
          </div>		  
        </div>
		<div class="clearfix">
			<div class="input FL PR30">
				<label for="input">Film :</label> <input type="radio" name='srcFilm' id="film" value=1 <?php echo $aSearch['srcFilm'];?> />
			</div>
			<div class="input FL PR30">
				<label for="input">Non Film :</label> <input type="radio" name='srcFilm' id="nonfilm" value="-1" <?php echo $aSearch['srcNonFilm'];?> />
			</div>
			<div class="input FL PR30">
				<label for="input">Original :</label> <input type="radio" name='srcOriginal' value="2" <?php echo $aSearch['srcOriginal'];?> />
			</div>
			<div class="input FL PR30">
				<label for="input">Compilation :</label> <input type="radio" name='srcOriginal' value="-2" <?php echo $aSearch['srcNonOriginal'];?> />
			</div>
			<div class="input FL PR30">
				<!--<label for="input">Digital :</label> <input type="hidden" name='srcDigital' value="4" />-->
			</div>
			<!-- div class="input FL PR30">
				<label for="input">Non Digital :</label> <input type="radio" name='srcDigital' value="-4" <?php echo $aSearch['srcNonDigital'];?> />
			</div -->
			
			<div class="input FL PR30">
				<label for="input">Start Date :</label>
				<input type="text" id="srcSrtDate" name="srcSrtDate" value="<?php echo $aSearch['srcSrtDate']; ?>" class="datepicker" />
			</div>
			<div class="input FL PR30">
				<label for="input">End Date :</label>
				<input type="text" id="srcEndDate" name="srcEndDate" value="<?php echo $aSearch['srcEndDate']; ?>" class="datepicker"/>
			</div>
		<div class="input FL PR30">
				<label for="input">Search Limit :</label>
				<div class="input FL PR30"><input type="text" id="" name="srcEnd" value="<?php echo $aSearch['srcEnd']; ?>" style="width: 40px !important;"/>
				<br>Max limit is 1000</div>
				
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


$setLimit = ($aSearch['srcEnd']=='') ? $iTotalCount : $aSearch['srcEnd'];
//echo "SATA=".$exl;
?>

<div class="bloc">

    <div class="title">
        Albums Lists  <b class='sCount'>(<?=$iTotalCount?>)</b> <div style="float: right; margin-top: -7px; margin-right: 35px;">
		
</div>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		
		<div align="right"><a  href="<?=SITEPATH?>album?action=view&isPlane=1&do=export&srcEnd=<?=$setLimit?>&<?=$QUERY_STRINGS;?>" class="button" title="Export Album Data">Export Album Data</a></div>
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"album_id")); ?>" title="sort by Id">Id</a></th>
                    <th>Image</th>
					<th width="275px"><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"album_name")); ?>" title="sort by Name">Name</a></th>
					<th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"title_release_date")); ?>" title="sort by Release Date">Release Date</a></th>
					<!--<th>Manage Contents</th>-->
					<!-- th>Manage Rights</th -->
					<th>Film / Non-Film</th>
					<th>Original / Compilation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
		
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
						$albumType=(int)$showData->album_type;
				?>
				<tr>
					<td>
						<?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->album_id, 'status'=>$showData->status, 'model'=>'album', 'flow'=>'legal', 'obj'=>$this ) ); ?>	
					</td>
					<td><?php echo $showData->album_id; ?></td>
					<td>
						<a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$showData->album_image));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$showData->album_image));?>" style="max-height:100px; max-width:100px;" ></a>
					</td>
					<td>
						<a href="<?=SITEPATH?>album?action=view&id=<?=$showData->album_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Album Details"><?php echo $showData->album_name; ?></a>
					</td>
					<td><?php echo $showData->title_release_date;#date("jS M Y",strtotime($showData->insert_date)); ?></td>
                    <!--<td><a href="<?=SITEPATH?>related?action=view&id=<?=$showData->album_id?>&isPlane=1" class="fancybox fancybox.iframe" title="Manage Contents">Contents</a></td>-->
					<?php
						/*
						if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){
					?>
					<td><a href="<?=SITEPATH?>album?action=edit&id=<?=$showData->album_id?>&isPlane=1&do=rights" class="fancybox fancybox.iframe" title="Manage Album Rights">Rights</a></td>
					<?php } */ ?> 
					<td><?php
							echo ((1&$albumType)==1)?"Film":"Non-Film";
					?></td>
					<td><?php
							echo ((2&$albumType)==2)?"Original":"Compilation";
					
					?></td>
					<td class="actions" style=" width:100px">
						<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_view")){ ?>
						<a href="<?=SITEPATH?>album?action=view&id=<?=$showData->album_id?>&isPlane=1&do=rights&album_name=<?=urlencode($showData->album_name);?>" class="fancybox fancybox.iframe" title="Manage Album Rights"><img src="<?=IMGPATH?>icons/legal_right.png" height="20px" width="20px" alt="Manage Album Rights"  /></a>
						<?php } ?>
						<!-- a href="<?=SITEPATH?>related?action=view&id=<?=$showData->album_id?>&isPlane=1" class="fancybox fancybox.iframe" title="Manage Contents"><img src="<?=IMGPATH?>icons/content.png"  alt="Manage Contents"  height="20px" width="20px"/></a -->
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->album_id, 'status'=>$showData->status, 'model'=>'album', 'flow'=>'legal' ) ); ?>						
					</td>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=4>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->album_id, 'status'=>$showData->status, 'model'=>'album', 'flow'=>'legal' ) ); ?>
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
<!--            
    CONTENT End 
			--> 
<script type="text/javascript">
var albumOptions, albumautocom;
	jQuery(function(){
	  albumOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=Album', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestalbum"};
	  albumautocom = $('.autosuggestalbum').autocomplete(albumOptions);
	});
var artistOptions, artistautocom;
	jQuery(function(){
	  artistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=', minChars:2,width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestartist"};
	  artistautocom = $('.autosuggestartist').autocomplete(artistOptions);
	});
function setTagValue(id){
	var tagOptions, tagautocom;
	tagOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&id='+id+'&type=tag', minChars:2,  delimiter: /(,|;)\s*/ ,class : "autosuggesttag"};
	tagautocom = $('.autosuggesttag').autocomplete(tagOptions);
}			
</script>				