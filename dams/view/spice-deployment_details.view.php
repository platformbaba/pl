<!--            
    CONTENT 
			-->
<style type="text/css">
#content .bloc .input {
    padding: 0;
}
</style>
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
<form id='srcFrm' name='srcFrm' method='post' enctype="multipart/form-data">
    <?php
		$deploymentFolder=tools::cleaningName($aDeployment[0]->deployment_name)."-".$aDeployment[0]->deployment_id;
		if( !empty($aContent) ){
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
	?>
	<div class="bloc" id="bloc_<?=$showData->id?>">
	<div class="content">
        <div class="clearfix">
   		  <div class="input FL PR5">ISRC :
			<label for="input" style="display: inline-table"><?php echo $showData->isrc; ?></label>
		  </div>
		  <div class="input FL PR5">Song Title :
            <label for="input" style="display: inline-table"><?php echo $showData->title; ?></label>
            
          </div>
		  <div class="input FL PR5">Language :
            <label for="input" style="display: inline-table"><?php echo $showData->language; ?></label>
            
          </div>
		  <div class="input FL PR5">Album :
			<label for="input" style="display: inline-table"><?php echo $showData->album; ?></label>
            
		  </div>
		  <div class="input FL PR5">Artist :
			<label for="input" style="display: inline-table"><?php echo $showData->singer; ?></label>
            
		  </div>
		  <div class="input FL PR5">Music Director :
			<label for="input" style="display: inline-table"><?php echo $showData->music_director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Director :
			<label for="input" style="display: inline-table"><?php echo $showData->director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Year of Release :
			<label for="input" style="display: inline-table"><?php echo $showData->release_year; ?></label>
            
		  </div>
		  <div class="input FL PR5">Genre :
			<label for="input" style="display: inline-table"><?php echo $showData->genre; ?></label>
            
		  </div>
		  <div class="input FL PR5">Filmstar :
			<label for="input" style="display: inline-table"><?php echo $showData->starcast; ?></label>
            
		  </div>
		  <div class="input FL PR5">Lyricist :
			<label for="input" style="display: inline-table"><?php echo $showData->lyricist; ?></label>
            
		  </div>
    	</div>
        <div class="cb"></div>
		</div>
	</div>
  	<?php
			}
		}	
	?>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->