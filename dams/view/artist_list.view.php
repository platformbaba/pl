<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/mArtist.png" alt=""  height="45px" width="45px" />Manage Artists</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'artist?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
<!-- Search Box start -->
<div class="bloc">
    <div class="title"> Search Filters: <a class="toggle" href="#"></a></div>
    <div class="content">
      <form id='srcFrm' name='srcFrm' method='GET'>
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input">Artist Title :</label>
            <input type="text" id="srcArtist" name="srcArtist" value="<?php echo $aSearch['srcArtist']; ?>" class="autosuggestartist WD150" />
          </div>
          <div class="input FL PR30">
            <label for="input">Status :</label>
            <select name="srcCType" id="srcCType" >
              <option value="">Select</option>
              <?php
						$actionArr = TOOLS::getContentActionTypes( array('type'=>'form','flow'=>'') );
						foreach( $actionArr as $k=>$act ){
							$check = ($aSearch['srcCType']==$act ? 'selected':'');
							echo '<option value="'.$act.'" '.$check.'>'.ucwords($act).'</option>';
						} 
					?>
            </select>
          </div>
		  <div class="input FL PR30">
            <label for="input">Artist Type :</label>
            <select name="srcArType" id="srcArType" >
              <option value="">Select</option>
              <?php
					foreach($aConfig['artist_type'] as $kR=>$vR){
						$selStr = ($aSearch['srcArType']==$vR ? 'selected':'');
						echo '<option value="'.$vR.'" '.$selStr.' >'.ucwords($kR).'</option>';
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
    <div class="title">
        Artists Lists <b class='sCount'>(<?=$iTotalCount?>)</b>
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"artist_id")); ?>" title="sort by Id">Id</a></th>
                    <th>Image</th>
					<th><a href="<?php echo TOOLS::getListSortingUrl(array("field"=>"artist_name")); ?>" title="sort by name">Name</a></th>
					<th>Type</th>
                    <th  align="center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->artist_id, 'status'=>$showData->status, 'model'=>'artist', 'flow'=>'' ) ); ?></td>
					<td><?php echo $showData->artist_id; ?></td>
					<td>
						<a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$showData->artist_image));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$showData->artist_image));?>" style="max-height:100px; max-width:100px;"></a>
					</td>
					<td>
					<a href="<?=SITEPATH?>artist?action=view&id=<?=$showData->artist_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Artist Details"><?php echo $showData->artist_name; ?></a>
					</td>
					<td><?php print_r($aRole[$showData->artist_role]); ?></td>
                    <td class="actions" style="width:100px" align="center">
						<a href="<?=SITEPATH?>related?action=view&id=<?=$showData->artist_id?>&isPlane=1&cType=13&relatedCType=17" class="fancybox fancybox.iframe" title="Manage Contents"><img src="<?=IMGPATH?>icons/content.png"  alt="Manage Contents"  height="20px" width="20px"/></a>
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->artist_id, 'status'=>$showData->status, 'model'=>'artist', 'flow'=>'' ) ); ?>	
					</td>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan=5>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->artist_id, 'status'=>$showData->status, 'model'=>'artist', 'flow'=>'' ) ); ?>
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
var artistOptions, artistautocom;
	jQuery(function(){
	  artistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=', minChars:2, width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestartist"};
	  artistautocom = $('.autosuggestartist').autocomplete(artistOptions);
	});
</script>			