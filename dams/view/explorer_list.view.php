<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<div class="bloc" style="margin-top:0px;">
    <div class="title">
        Browse Directory
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
      		<thead>
            <tr>
              <th>File name</th>
			  <th>Size</th>
			  <th>Last Changed</th>
            </tr>
            </thead>
            <tbody>
                <?php 
				if( !empty($aContent) ){
				?>
				<tr>
					<td colspan="3">
						<a href="?action=view&isPlane=1&ldir=<?=$_GET['ldir']?>&dir=<?php echo $aContent[0]['back'] ?>" title="back"><img src="<?=IMGPATH?>icons/folder.png" />..</a>
					</td>
				</tr>
				<?php	
					foreach( $aContent as $showData){
						if($showData['isFile']==1){
						?>
						<tr>
							<td><a href="<?php echo $showData['file'] ?>" onclick="parent.cms.setRawFile({'rawFile':'<?=$_GET['dir']."/".$showData['dir']?>','rFile':'<?=$showData['dir']?>'})"><img src="<?=IMGPATH?>icons/file.png" /><?=$showData['dir']?></a></td>
							<td><?=tools::humanFilesize(filesize($_GET['dir']."/".$showData['dir']),2);//   round(filesize($_GET['dir']."/".$showData['dir'])/1024)?></td>
							<td><?=date("d/m/Y H:i A.", filemtime($_GET['dir']."/".$showData['dir']))?></td>
						</tr>
						<?php
						}else{
				?>
						<tr>
							<td><img src="<?=IMGPATH?>icons/folder.png" /><a class="button" href="?action=view&isPlane=1&ldir=<?=$_GET['ldir']?>&dir=<?php echo $showData['path'] ?>"><?=$showData['dir']?></a></td>
							<td></td>
							<td><?=date("d/m/Y H:i A.", filemtime($_GET['dir']."/".$showData['dir']))?></td>
						</tr>
				<?php
						}
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
    </div>
</div>

<form id='actionFrm' name='actionFrm' method="POST">
<input type="hidden" id="contentId" name="contentId" value="">
<input type="hidden" id="contentAction" name="contentAction" value="">
<input type="hidden" id="contentModel" name="contentModel" value="">
</form>

</div>
<!--  CONTENT End --> 
