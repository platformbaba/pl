<!--            
    CONTENT 
			--> 
	<script type="text/javascript">

	function check_contents( type ){
	    if( type == 'remove' ){
			var vId   = document.getElementsByName('select_ids[]');
			var chk;
			for(var i=0;i<vId.length;i++){
				if(vId[i].checked==true){
					 chk = 1;
				 }
			}	  
			if(chk!=1){	
				alert("Please select at least one content!");
				return false;
			}else{
			
				var confirmBox = confirm("Are you sure to remove selected Contents!!")
				if (confirmBox==true){
					document.getElementById("postButton").value = 'removeContent';
					document.getElementById("actFrm").submit();
					return true;
				}
				return false;
			} 
		}else if( type == 'rank' ){
			var confirmBox = confirm("Are you sure to update rank.!!")
			if (confirmBox==true){
				document.getElementById("postButton").value = 'orderRank';
				document.getElementById("actFrm").submit();
				return true;
			}
			return false;
		}else if( type == 'add' ){
			var srcSong   = document.getElementById('srcSong').value;
			if( srcSong != '' ){
				var confirmBox = confirm("Are you sure to add this song.!!")
				if (confirmBox==true){
					document.getElementById("addFrm").submit();
					return true;
				}
			}else{
				alert("Please select song.");
			}
			return false;
		}
	}

</script>
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
<div class="bloc" style="margin-top:0px;">
    <?php
		$params = array(
							'cType'=>$cType,
							'relatedCType'=>$relatedCType,
							'id'=>$id,
							'contentCount'=>count($aContent),
						);
		echo TOOLS::displayViewTabsHtml( $params );
	
	if ($this->user->hasPrivilege(strtolower( $aConfig['module'][$cType] )."_edit")){
	if( $showHeadArr['add_song'] ){ ?>
	<div class="fieldsetDiv">
		<fieldset>
			<legend>Add Song</legend>
			<form name="addFrm" id="addFrm" method="POST">
			<input type='hidden' name='cType' value='<?php echo $cType;?>' >
			<input type='hidden' name='relatedCType' value='<?php echo $relatedCType;?>' >
			<input type='hidden' name='id' value='<?php echo $id;?>' >
			<input type="hidden" value="Add" name="addSongBtn">
			<div class="">
				<div class="FL ML10"> Song Title: 
					<input type="text" id="srcSong" name="srcSong" value="" class="autosuggestsong WD250" />
					<input type="hidden" name="autosuggestsong_hddn" id="autosuggestsong_hddn" value=""  />
					<span class='submit'><input type="button" value="Add" name="addSongBtn" style="margin:0 auto" onclick="return check_contents('add');"></span>
				</div>
			</form>                
		</fieldset>
	</div>
	<?php } } ?>
	<div class="content">
	
        <form id='actFrm' name='actFrm' method="POST" >
		<input type='hidden' name='cType' value='<?php echo $cType;?>' >
		<input type='hidden' name='relatedCType' value='<?php echo $relatedCType;?>' >
		<input type='hidden' name='id' value='<?php echo $id;?>' >
		<input type='hidden' name='postButton' id='postButton' value='' >
		<table>
            <thead>
                <tr>
					<?php 
						$coulmnCount = 0;
						echo '<th><input type="checkbox" class="checkall"/></th>';
						$coulmnCount++;
						$imagePosition = 100;
						foreach( $showHeadArr['head']  as $kk => $vv ){
							if( $vv=='Image' ){ $imagePosition = $kk; }
							echo '<th>'.$vv.'</th>';
							$coulmnCount++;
						}
						if( !empty($showHeadArr['extra_head']) ){
						foreach( $showHeadArr['extra_head']  as $kk => $vv ){
							echo '<th>'.$vv.'</th>';
							$coulmnCount++;
						}
						}
						if( $showHeadArr['rank'] ){  echo '<th>Rank</th>'; $coulmnCount++; }
					?>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
											
						$field_id = $showHeadArr['field_id'];
						$content_id = $showData->$field_id;
						echo '<tr>';	
						echo '<td><input type="checkbox" value="'.$content_id.'" name="select_ids[]" /></td>';
						foreach( $showHeadArr['body']  as $kk => $vv ){
							if( $imagePosition == $kk ){
								echo '<td><a class="zoombox" href="'.TOOLS::getImage(array('img'=>$showData->$vv)).'"><img alt="image" src="'.TOOLS::getImage(array('img'=>$showData->$vv)).'" style="max-height:100px; max-width:100px;"></a></td>';
							}else if( $vv == 'insert_date' ){	echo '<td>'.substr($showData->$vv,0,10).'</td>';	}else{
								echo '<td>'.$showData->$vv.'</td>';
							}
						}
						if( !empty($showHeadArr['extra_body']) ){
							foreach( $showHeadArr['extra_body']  as $kk => $vv ){
								
								if( !empty($aExtraContent[$content_id][$vv]) ){
									echo '<td>'.$aExtraContent[$content_id][$vv].'</td>';
								}else{
									echo '<td>--</td>';
								}
							}
						}
						if( $showHeadArr['rank'] ){  echo '<td class="actions"><div class="input"><input type="text" name="contentRank['.$content_id.']" value="'.$aContentRank[$content_id].'"  style="width:25px;" /></div></td>'; }
						echo '</tr>';
				?>
                </tr>
				<?php
					} /* foreach end */
					}else{
						echo '<tr>
								<td colspan="'.$coulmnCount.'">'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
			</tbody>
        </table>
		<?php
		if ($this->user->hasPrivilege(strtolower( $aConfig['module'][$cType] )."_edit")){
		
		if( $showHeadArr['remove_button'] ){
		?>
        <div class="submit left">
			<input type="button" value="Remove this Content" name="removeContent" style='margin:0 auto' onclick="return check_contents('remove');" />
		</div>
		<?php }
		if( $showHeadArr['rank'] ){ ?>
		<div class="submit" align='right'>
			<input type="button" value="Order Rank" name="orderRank" style='margin:0 auto' onclick="return check_contents('rank');" />
		</div>
		<?php } } ?>
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>
</div>
<?php if( $showHeadArr['add_song'] ){ ?>
<script type="text/javascript">
var songOptions, songautocom;
	jQuery(function(){
	  songOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=song', minChars:2, width:230, delimiter: /(,|;)\s*/ ,class : "autosuggestsong"};
	  songautocom = $('.autosuggestsong').autocomplete(songOptions);
	});
</script>
<?php } ?>
<!--  CONTENT End --> 