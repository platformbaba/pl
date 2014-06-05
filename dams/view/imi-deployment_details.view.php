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
          <div class="input FL PR5">Song Title :
            <label for="input" style="display: inline-table"><?php echo $showData->title; ?></label>
            
          </div>
		  <div class="input FL PR5">Language :
            <label for="input" style="display: inline-table"><?php echo $showData->language; ?></label>
            
          </div>
		  <div class="input FL PR5">Category :
            <label for="input" style="display: inline-table"><?php echo $providerDetails['category']; ?></label>
            
          </div>
		  <div class="input FL PR5">Sub Category :
            <label for="input" style="display: inline-table"><?php echo $providerDetails['subCategory']; ?></label>
            
          </div>
		  <div class="input FL PR5">Coid :
            <label for="input" style="display: inline-table"><?php echo $providerDetails['coid']; ?></label>
			
          </div>
          <div class="input FL PR5">Cpid :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['cpid']; ?></label>
            
		  </div>
		  <div class="input FL PR5">Clid :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['clid']; ?></label>
            
		  </div>
		  <div class="input FL PR5">Start Date :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['startDate']; ?></label>
            
		  </div>
		  <div class="input FL PR5">End Date :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['endDate']; ?></label>
            
		  </div>
		  <div class="input FL PR5">Exclusive :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['exclusive']; ?></label>
			
		  </div>
		  <div class="input FL PR5">Album :
			<label for="input" style="display: inline-table"><?php echo $showData->album; ?></label>
            
		  </div>
		  <div class="input FL PR5">Clano :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['clano']; ?></label>
			
		  </div>
		  <div class="input FL PR5">Key Artist :
			<label for="input" style="display: inline-table"><?php echo $showData->keyartist; ?></label>
			
		  </div>
		  <div class="input FL PR5">Key Music Director :
			<label for="input" style="display: inline-table"><?php echo $showData->music_director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Search key :
			<label for="input" style="display: inline-table"><?php echo $showData->search_key; ?></label>
            
		  </div>
		  <div class="input FL PR5">Key Director :
			<label for="input" style="display: inline-table"><?php echo $showData->director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Key Producer :
			<label for="input" style="display: inline-table"><?php echo $showData->producer; ?></label>
            
		  </div>
		  <div class="input FL PR5">Year of Release :
			<label for="input" style="display: inline-table"><?php echo $showData->release_year; ?></label>
            
		  </div>
		  <div class="input FL PR5">Album Year :
			<label for="input" style="display: inline-table"><?php echo $showData->album_year; ?></label>
            
		  </div>
		  <div class="input FL PR5">Genre :
			<label for="input" style="display: inline-table"><?php echo $showData->genre; ?></label>
            
		  </div>
		  <div class="input FL PR5">Starcast :
			<label for="input" style="display: inline-table"><?php echo $showData->starcast; ?></label>
            
		  </div>
		  <div class="input FL PR5">Lyricist :
			<label for="input" style="display: inline-table"><?php echo $showData->lyricist; ?></label>
            
		  </div>
		  <div class="input FL PR5">Singer :
			<label for="input" style="display: inline-table"><?php echo $showData->singer; ?></label>
            
		  </div>
		  <div class="input FL PR5">Origial Code :
			<label for="input" style="display: inline-table"><?php echo $showData->isrc; ?></label>
		  </div>
    	</div>
        <div class="cb"></div>
		<div class="clearfix">
		  <div class="input FL PR5">0808m :
			<label for="input" style="display: inline-table" style="display: inline-table"><?=$providerDetails['0808m']?></label>
			<br/>
			<?php
				if($providerDetails['0808m']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }?>
		  </div>
		  <div class="input FL PR5">0808m40s :
			<label for="input" style="display: inline-table"><?=$providerDetails['0808m40S']?></label>
		  	<br/>
			<?php
				if($providerDetails['0808m40S']){
			?>
			<audio id="audiox2_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }?>
		  </div>
		  <div class="input FL PR5">1616m :
			<label for="input" style="display: inline-table"><?=$providerDetails['1616m']?></label>
		  	<br/>
			<?php
				if($providerDetails['1616m']){
			?>
			<audio id="audiox3_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }?>
		  </div>
		  <div class="input FL PR5">0808mfull :
			<label for="input" style="display: inline-table"><?=$providerDetails['0808mFull']?></label>
		 	<br/>
			<?php
				if($providerDetails['0808mFull']){
			?>
			<audio id="audiox4_<?=$showData->id?>" style="width: 200px;"  src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<?php }?>
		  </div>
		</div>
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