<!--            
    CONTENT 
			--> 

<script type="text/javascript">

	function ckeck_video(){
	

        var vId   = document.getElementsByName('select_ids[]');
		var chk;
		for(var i=0;i<vId.length;i++){
			if(vId[i].checked==true){
				 chk = 1;
			 }
		}	  
		
			if(chk!=1){	
				alert("Please select at least one video!");
				return false;
			}else{
			
			 	var confirmBox = confirm("Are you sure to remove video!!")
				if (confirmBox==true)
				  {
				 	return true;
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
    <div class="title">
        Video Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST" target="_top" ONSUBMIT="return ckeck_video();">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Video Name</th>
 					<th>Insertdate</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><input type="checkbox" value="<?php echo $showData->video_id; ?>" name="select_ids[]" /></td>
					<td><?php echo $showData->video_id; ?></td>
					<td><?php echo $showData->video_name; ?></td>
					<td><?php echo $showData->insert_date; ?></td>
					
                    <td class="actions">
						<div class="input">
							<input type="text" name="videoRank[<?=$showData->video_id?>]" value="<?=$aVideoRank[$showData->video_id]?>"  style="width:25px;" />
						</div>	
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
		<?php
		if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){
		?>
        <div class="submit left">
			<input type="submit" value="Remove Video From Album" name="removeVideo" style='margin:0 auto' />
		</div>
		<div class="submit" align='right'>
			<input type="submit" value="Order Rank" name="orderRank" style='margin:0 auto' />
		</div>
		<?php } ?>
		<input type="hidden" name="refferer" value="<?=$_SERVER["HTTP_REFERER"]?>" />
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