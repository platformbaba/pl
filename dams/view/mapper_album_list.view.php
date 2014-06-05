<!--    CONTENT 	--> 
<div id="content">
	<h1><img src="<?php echo IMGPATH; ?>icons/mAlbum.png" alt=""  height="45px" width="45px" />Map Albums </h1>
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
    <div class="title">
        Search Filters:
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='GET'>
		<div class="clearfix">
			<div class="input FL50">
				<label for="input">Content Name:</label>
				<input type="text" id="srcAlbum" name="srcAlbum" value="<?php echo $aSearch['srcAlbum']; ?>" />
			</div>
			<div class="input FR50">
				<label for="input">Content Type:</label>
				<select name="srcCType" id="srcCType" >
					<option value="1" <?=($aSearch['srcCType']==1)?"selected='selected'":""?>>Album</option>
					<option value="2" <?=($aSearch['srcCType']==2)?"selected='selected'":""?>>Artist</option>
				</select>
			</div>
		</div>
		<div class="submit" align='right'>
			<input type="submit" value="Search" name="submitBtn" class="black" style='margin:0 auto' />
		</div>
		<div class="cb"></div>
		</form>
    </div>
</div>
<!-- Search Box end -->
	

<div class="bloc">
    <div class="title">
         Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
                    <th>Album Id</th>
					<th>Name</th>
					<th>Release Date</th>
					<th>Language</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><?php echo $showData->album_id; ?></td>
					<td><?php echo $showData->album_name; ?></td>
					<td><?php echo $showData->music_release_date;#date("jS M Y",strtotime($showData->insert_date)); ?></td>
                    <td><?php echo $aLanguage[$showData->language_id]; ?></td>
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
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>
<div class="bloc">
    <div class="title">
        Map Original Album Id with Duplicate Album Ids 
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='POST' onsubmit="return confirm('Are you sure you want to submit?')">
		<div class="clearfix">
			<div class="input">
				<label for="input">Original Album Id : </label>
				<input type="text" id="oAlbumId" name="oAlbumId" value="<?php echo $aSearch['oAlbumId']; ?>"  />
			</div>
			<div class="input FL50" style="width:20%">
				<label for="input">Mapped Album Id 1: </label>
				<input type="text" id="mAlbumId1" name="mAlbumId[]" value="<?php echo $aSearch['mAlbumId']; ?>" style=" width:60%" />
			</div>
			<div class="input FL50" style="width:20%">
				<label for="input">Mapped Album Id 2: </label>
				<input type="text" id="mAlbumId2" name="mAlbumId[]" value="<?php echo $aSearch['mAlbumId']; ?>"  style=" width:60%"/>
			</div>
			<div class="input FL50" style="width:20%">
				<label for="input">Mapped Album Id 3: </label>
				<input type="text" id="mAlbumId3" name="mAlbumId[]" value="<?php echo $aSearch['mAlbumId']; ?>" style=" width:60%"/>
			</div>
			<div class="input FL50" style="width:20%">
				<label for="input">Mapped Album Id 4: </label>
				<input type="text" id="mAlbumId4" name="mAlbumId[]" value="<?php echo $aSearch['mAlbumId']; ?>"  style=" width:60%"/>
			</div>
			<div class="input FL50" style="width:20%">
				<label for="input">Mapped Album Id 5: </label>
				<input type="text" id="mAlbumId5" name="mAlbumId[]" value="<?php echo $aSearch['mAlbumId']; ?>" style=" width:60%"/>
			</div>
		</div>
		<div class="submit" align='right'>
			<input type="submit" value="Submit To Map" name="submitToMap" class="black" style='margin:0 auto' />
		</div>
		<div class="cb"></div>
		</form>
    </div>
</div>
</div>
<!--            
    CONTENT End 
			--> 