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
<div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:418px;">
    <div class="title">
        All Playlist
    </div>
	<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>playlist?action=add&song_id=<?=$_GET['song_id']?>&isPlane=1&ctype=<?=$_GET['ctype']?>" class="button" title="create playlist">Create Playlist</a>
	</div>
    <div class="content">
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th>Select</th>
                    <th>Playlist Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if( !empty($aContent) ){
					foreach( $aContent as $showData){
				?>
				<tr>
					<td><input type="radio" name="srcPlaylistId" onclick="parent.cms.addToPlaylist({'playlistId':'<?=$showData->playlist_id?>','songId':'<?=$_GET['song_id']?>','ctype':'<?=$_GET['ctype']?>'});" /></td>
					<td><?php echo $showData->playlist_name; ?></td>
					<td><?php echo $showData->insert_date; ?></td>
                </tr>
				<?php
					} /* foreach end */
					}else{?>
						<tr>
							<td colspan=3>
								<a href="<?=SITEPATH?>playlist?action=add&song_id=<?=$_GET['song_id']?>&isPlane=1&ctype=<?=$_GET['ctype']?>" class="button" title="create playlist">Create Playlist</a>
							</td>
						</tr>
					<?php		  
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
<!--  CONTENT End -->