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
<div class="bloc" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px; width:818px;">
    <div class="title">
        Pragram Name ( <?=ucfirst($_GET['pName']);?> )
    </div>
	<div style="float: right; margin-top: -30px; margin-right: 35px;">
		<a href="<?=SITEPATH?>radio_bulk?action=add&do=programpop&programId=<?=$_GET['id']?>&isPlane=1&pName=<?=urlencode($_GET['pName'])?>" class="button" title="Add Program">Bulk Upload</a>
		<a href="<?=SITEPATH?>radio_addprogramsong?action=add&id=<?=$_GET['id']?>&isPlane=1&pName=<?=urlencode($_GET['pName'])?>" class="button" title="Add Program Songs">Add Program Song</a>
	</div>
    <div class="content">
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th>ID</th>
                    <th>ISRC</th>
					<th>File</th>
					<th>Type</th>
                   <th>Insert Date</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
				
				if( !empty($aContent) ){
				
					foreach( $aContent as $showData){
				?>
				<tr>
					
					<td><?=$showData->id;?></td>
					<td><?=$showData->isrc;?></td>
					<td><?=$showData->file;?></td>
					<td><?=$showData->type;?></td>
					<td><?=$showData->insert_date;?></td>
					
					<td><a href="<?=SITEPATH?>radio_addprogramsong?action=edit&id=<?=$_GET['id']?>&eid=<?=$showData->id?>&isPlane=1&pName=<?=urlencode(strtolower($_GET['pName']));?>" title="Edit Program Song"><img src="<?=IMGPATH?>icons/edit.png" alt="Edit Program Song"  /></a>
					<a href="<?=SITEPATH?>radio_addprogramsong?action=add&id=<?=$_GET['id']?>&eid=<?=$showData->id?>&isPlane=1&do=draft&pName=<?=urlencode(strtolower($_GET['pName']));?>" title="Delete Program Song" onclick="return confirm('Are you shure to delete Song?')"><img src="<?=IMGPATH?>icons/draft.gif" alt="Delete Program Song"  /></a></td>
                </tr>
				<?php
					} /* foreach end */
				}else{ 
				 ?>
				
				<td colspan="6" align="center">No Program Songs</td>
				<?php 
				}
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