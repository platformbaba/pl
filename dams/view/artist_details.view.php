<!-- CONTENT -->
<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <?php
		$aParam = array(
							'cType'=>13,
							'relatedCType'=>0,
							'id'=>$aContent['id'],
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Artist Name</label>
			<div class='text-field-disabled'>
            <?=$aContent['artistName']?>
			</div>
          </div>
          <div class="input FL50">
            <label for="select">Artist Type</label>
			<div class='text-field-disabled'>
            <?php
					foreach($aConfig['artist_type'] as $kR=>$vR){
						if(in_array($vR,$aContent['role'])){
							$aType .= ucwords($kR).",";
						}
					}
					echo trim($aType,",");
				?>
			</div>
          </div>
        </div>
        <div class="clearfix">
          <div class="input FL50">
            <label for="file">Image</label>
            <div style="width:140px;" class="picture"><a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;"></a></div>
          </div>
          <div class="input FL50">
            <label for="input4">Date of birth</label>
			<div class='text-field-disabled'>
            <?=str_replace("00:00:00","",$data['aContent']['dob'])?>
			</div>
          </div>
        </div>
		<div class="clearfix">
          <div class="input FL50">
            <label for="select">Gender</label>
              <div class='text-field-disabled'>
			  <?php
					foreach($aConfig['gender'] as $kG=>$vG){
						if($aContent['gender']==$kG){
							echo ucwords($vG);
						}
					}
				?>
			</div>
          </div>
		  <div class="input FL50">
            <label for="input1">Alias</label>
			<div class='text-field-disabled'>
            <?=$aContent['alias']?>
			</div>
          </div>
		</div>  
		<div class="input textarea">
            <label for="textarea2">Biography</label>
			<?=html_entity_decode($data['aContent']['content'])?>
		</div>
      </form>
    </div>
  </div>
</div>