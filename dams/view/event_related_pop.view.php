<!--             CONTENT 		--> 
<script type="text/javascript">
	function check_contents( type ){
	    
	    if( type == 'save' ){
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
			
				var confirmBox = confirm("Are you sure to save selected Contents!!")
				if (confirmBox==true){
					document.getElementById("postButton").value = 'saveContent';
					document.getElementById("actFrm").submit();
					return true;
				}
				return false;
			} 
		}
		else if( type == 'remove' ){
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
		}else if(type== 'searchSong'){
				document.getElementById("postButton").value = 'searchSong';
				document.getElementById("srcFrm").submit();
				return true;
		
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


	$type = $_GET['type']; // all or save
 
	if($type=='all'){
		$type_cls = ($type=='all') ? "" : "white";
		$type_cls1 = ($type=='all') ? "white" : "";
	}
	if($type=='save'){
		$type_cls = ($type=='save') ? "white" : "";
		$type_cls1 = ($type=='save') ? "" : "white";
	}

	?>
<div>	
<a class='button MR30 <?=$type_cls;?>' href='/cms/event_related?action=view&isPlane=1&cType=<?=$cType;?>&relatedCType=<?=$relatedCType?>&id=<?=$id;?>&type=all'>All Content</a>
<?php
	if($playlistData){
		foreach($playlistData as $vPlay){
		?>
			<a class='button MR30 <?=$type_cls1;?>' href='/cms/playlist?action=view&id=<?=$vPlay->playlist_id?>&isPlane=1&do=details&back=1'><?=$vPlay->playlist_name?></a>
		<?php	
		}
	}
?>
<?php
	if($videoplaylistData){
		foreach($videoplaylistData as $vPlay){
		?>
			<a class='button MR30 <?=$type_cls1;?>' href='/cms/playlist?action=view&id=<?=$vPlay->playlist_id?>&isPlane=1&do=details&back=1'><?=$vPlay->playlist_name?></a>
		<?php	
		}
	}
?>
<?php
	if($imageplaylistData){
		foreach($imageplaylistData as $vPlay){
		?>
			<a class='button MR30 <?=$type_cls1;?>' href='/cms/playlist?action=view&id=<?=$vPlay->playlist_id?>&isPlane=1&do=details&back=1'><?=$vPlay->playlist_name?></a>
		<?php	
		}
	}
?>
</div>

<div class="bloc" style="margin-top:0px;">
    <div class='title'>
		<span class='FL'><?php echo ucfirst( $aConfig['module'][$relatedCType] ); ?> Lists ( <?=$aConfig['calendar_event'][$contentType];?> )</span>
		<span class='FR'>
		<?php 
			foreach( $aConfig['related-contents'][$cType] as $kk => $vv ){
				$buttonColor = 'white';
				if( $vv == $relatedCType ){ $buttonColor=''; }
				echo "<a class='button MR30 ".$buttonColor."' href='".SITEPATH."event_related?action=view&isPlane=1&cType=".$cType."&relatedCType=".$vv."&id=".$id."&type=".$type."' title='".ucfirst($aConfig['module'][$vv])."'>".ucfirst($aConfig['module'][$vv])."</a>";
				
			}
		?>
		</span>
		<br class='clear' />
	</div>
	
	<div class="content">
	<?php /*if($type=='all'){//$relatedCType=4(Songs)/15 video/17 image?>
		<!--<form id='srcFrm' name='srcFrm' method='POST'>
        <div class="clearfix">
          <div class="input FL PR30">
            <label for="input"><?=ucfirst($aConfig['module'][$relatedCType]);?> Search :</label>
            <input type="text" id="srcData" name="srcData" value="<?php echo $aSearch['srcData']; ?>" class="WD150" size="100" />
          </div>
		  <div class="submit" align='right'><input type="button" value="Search" onclick="return check_contents('searchSong');" name="searchSong" style="float: left; margin-left: -24px; margin-top:28px;"/></div>
	  	</div>
		</form>-->
	<?php }*/ ?>
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
						//echo '<th><input type="checkbox" class="checkall"/></th>';
						$coulmnCount++;
						$imagePosition = 100;
						foreach( $showHeadArr['head']  as $kk => $vv ){
							if( $vv=='Image' ){ $imagePosition = $kk; }
							echo '<th>'.$vv.'</th>';
							$coulmnCount++;
						}
						#if( $showHeadArr['rank'] && $type=='save' ){  echo '<th>Rank</th>'; $coulmnCount++; }
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
						//echo '<td><input type="checkbox" value="'.$content_id.'" name="select_ids[]" /></td>';
						foreach( $showHeadArr['body']  as $kk => $vv ){
							if( $imagePosition == $kk ){
								echo '<td><a class="zoombox" href="'.TOOLS::getImage(array('img'=>$showData->$vv)).'"><img alt="image" src="'.TOOLS::getImage(array('img'=>$showData->$vv)).'" style="max-height:100px; max-width:100px;"></a></td>';
							}else {		echo '<td>'.$showData->$vv.'</td>'; }
						}
						
						#if( $showHeadArr['rank'] && $type=='save'){  echo '<td class="actions"><div class="input"><input type="text" name="contentRank['.$content_id.']" value="'.$aContentRank[$content_id].'"  style="width:25px;" /></div></td>'; }
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
		/*if ($this->user->hasPrivilege(strtolower( $aConfig['module'][$cType] )."_edit")  && $type=='all'){ 
		?>
        <div class="submit left">
			<input type="button" value="Save this Content" name="saveContent" style='margin:0 auto' onclick="return check_contents('save');" />
		</div>
		<?php
		
		 }elseif($this->user->hasPrivilege(strtolower( $aConfig['module'][$cType] )."_edit") && $type=='save'){
			?>		 
         <div class="submit left">
		<input type="button" value="Remove this Content" name="removeContent" style='margin:0 auto' onclick="return check_contents('remove');" />
		</div>
		<?php if( $showHeadArr['rank'] ){ ?>
		<div class="submit" align='right'>
			<input type="button" value="Order Rank" name="orderRank" style='margin:0 auto' onclick="return check_contents('rank');" />
		</div>

	<?php } }*/
		 
		?>
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>
</div>
<!--  CONTENT End --> 