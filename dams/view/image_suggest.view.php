<!--            
    CONTENT 
			--> 
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
<!-- Search Box start -->
<div class="bloc" style="margin-top:0px;">
    <div class="title">
        Search Images:
    <a class="toggle" href="#"></a></div><a class="button FR" href="<?=SITEPATH?>upload_image?action=view&isPlane=1&cType=<?=$_GET['cType']?>&cId=<?=$_GET['cId']?>&place=oPic" style="margin-top: -30px; margin-right: 30px;">Upload Image</a>
	<span style="clear:both" ></span>
    <div class="content">
		<form id='srcFrm' name='srcFrm'>
		<div class="clearfix">
			<div class="input FL PR30">
				<label for="input">Image Name:</label>
				<input type="text" id="srcImage" name="srcImage" value="<?php echo $aSearch['srcImage']; ?>" />
			</div>
			<!-- div class="input FL PR30">
				<label for="input">Image Type:</label>
				<select name="srcImgType" id="srcImgType" >
					<option value="">Select</option>
					<?php
						
						foreach( $image_type as $v=>$k ){
							$check = ($aSearch['srcImgType']==$k ? 'selected':'');
							echo '<option value="'.$k.'" '.$check.'>'.$v.'</option>';
							if( $k==1 ){ break; }
						} 
					?>
				</select>
			</div -->
		</div>
		<div class="submit" align='right'>
			<input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
			<input type="hidden" value="view" name="action" />
			<input type="hidden" value="1" name="isPlane" />
			<input type="hidden" value="<?=$_GET['cType']?>" name="cType" />
			<input type="hidden" value="<?=$_GET['cId']?>" name="cId" />
			<input type="hidden" value="oPic" name="place" />
			<input type="hidden" value="suggest" name="do" />
		</div>
		
		<div class="cb"></div>
		</form>
    </div>
</div>
<!-- Search Box end -->
<div class="bloc">
    <div class="title">
        Image Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th>Select</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
						$dis_type = TOOLS::display_image_type($showData->image_type);
						//$dis_type = '';
				?>
				<tr>
					<td><input type="radio" name="srcImage" onclick="parent.cms.setImage({'imageVal':'<?=$showData->image_file?>','imagePath':'<?=TOOLS::getImage(array('img'=>$showData->image_file));?>','place':'<?=$_GET['place']?>','imageId':'<?=$showData->image_id;?>'});" /></td>
					<td><a class="zoombox"  href="<?php echo TOOLS::getImage(array('img'=>$showData->image_file)); ?>"><img alt="image" src="<?php echo TOOLS::getImage(array('img'=>$showData->image_file)); ?>" style="max-height:100px; max-width:100px;"></a></td>
					<td><?php echo $showData->image_name; ?></td>
					<td><?php echo $dis_type; ?></td>
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
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>
</div>
<!--            
    CONTENT End 
			--> 