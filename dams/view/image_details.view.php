<!-- CONTENT --> 
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
<div class="bloc" style="margin-top:0px;">
    <?php
	
	
	
		$aParam = array(
							'cType'=>17,
							'relatedCType'=>0,
							'id'=>$aContent['imageId'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
		
	?>
    <div class="content">
	  <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Album</label>
			<?php
				$albumBox="";
				if($aContent['albumId']){
					if($aContent['albumNameArr']){
						foreach($aContent['albumNameArr'] as $kStar=>$vStar){
							$albumBox .= $vStar.',';
						}
					}
				}	
			?>
			<div class='text-field-disabled '>
			  <?=trim($albumBox, ',')?>
			</div>
		</div>
		  
		  <div class="input FL50">
            <label for="input1">Artist</label>
            <?php
			$artistBox="";
			if($aContent['artistId']){
				if($aContent['artistNameArr']){
					foreach($aContent['artistNameArr'] as $kStar=>$vStar){
						$artistBox .= $vStar.',';
					}
				}
			}	
		?>
            <div class='text-field-disabled '>
              <?=trim($artistBox, ',')?>
            </div>
          </div>
        </div>
		
		<div class="clearfix">
          <div class="input FL50">
            <label for="input4">Image Name</label>
			<div class='text-field-disabled '>
            <?=$aContent['imageName']?>
			</div>
          </div>
          <div class="input FL50">
            <label for="input1">Image Type </label>
			<?php
				$disStr = '';
				foreach($image_type as $type_name=>$type_id){
					if(($aContent['imageType']&$type_id)==$type_id){
						$disStr .= $type_name.',';
					}
				}
			?>
            <div class='text-field-disabled '>
				<?=trim($disStr, ',')?>
			</div>
			<div class="input FL50">
            <label for="input1">Image Category </label>
			 <div class='text-field-disabled '>
			<?php
				foreach($imageCategory as $tags){
						if($aContent['imageCategory']==$tags->tag_id){
							echo $tags->tag_name;
							break;
						}
					}
			?>
			</div>
         
          </div>
          </div>
		  
        </div>
		<div class="clearfix">	
			<div class="input FL50">
				<label for="input1">Image Desc</label>
				<div class='text-field-disabled '>
				<?=$aContent['imageDesc']?>
				</div>
			</div>
			<div class="input FL50">
			<label for="input1">Song</label>
			<?php
			$songBox="";
			if($aContent['songId']){
				if($aContent['songNameArr']){
					foreach($aContent['songNameArr'] as $kStar=>$vStar){
						$songBox .= $vStar.',';
						}
					}
				}	
			?>
			<div class='text-field-disabled '>
			  <?=trim($songBox, ',')?>
			</div>
		</div>
		</div>
		<div class="input">
            <label for="file">Image</label>
            <?php
				if( !empty($aContent['imageFile']) ){
			?>
				<div style="width:140px;" class="picture MT10"><a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['imageFile']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['imageFile']));?>" style="max-height:100px; max-width:100px;"></a></div>
				
			<?php	
				}
			
			?>
        </div>
	  </div>
</div>
</div>