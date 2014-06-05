<!-- CONTENT -->

<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <div class="bloc" style="margin-top:0px;">
    <div class="title"> Event Details</div>
    <div class="content">
        <div class="input FL50">
          <label for="input1">Event Title</label>
          <div class='text-field-disabled'>
		  <?=$aContent['eventName']?>
		  </div>
        </div>
        
	 <div class="input FL50">
		<?php if(!empty($aContent['srcEndDate']) && $aContent['srcEndDate'] != '0000-00-00' ){ ?>        
		<label for="input1">Start date</label>
          <div class='text-field-disabled'>
		  <?=date('d M Y',strtotime($aContent['srcSrtDate']));?>
		  </div>
	  		
       
		       <div class="clearfix">
          <div class="input FL50">
  
          <label for="input1">End date</label>
          <div class='text-field-disabled'>
		  <?=date('d M Y',strtotime($aContent['srcEndDate']));?>
		  </div>
       	</div></div>
		<?php }else{ ?>	
		<label for="input1">Event date</label>
          <div class='text-field-disabled'>
		  <?=date('d M Y',strtotime($aContent['srcSrtDate']));?>
		  </div>
		<?php } ?>  
        </div>
		
		
	
		<div class="input FL50">
            <label for="select">Language</label>
            <div class='text-field-disabled'>
			<?php 
						foreach($languageList as $kL=>$vL){
							if($aContent['languageIds']){
								if($vL->language_id==$aContent['languageIds']){
									echo ucwords($vL->language_name);
								}
							}
						}
					?>
			</div>
          </div>
		  
        <div class="clearfix">
          <div class="input FL50">
            <label for="input1">Event Type</label>
            <div class='text-field-disabled'>
			<?=ucfirst($aConfig['calendar_event'][$aContent['eventType']]);?>
			</div>
          </div>
		 
        </div>	
		<div class="clearfix">
		<div class="input FL50">
          <label for="input1">Artist</label>
          <?php
										$artistBox="";
										$albumHidden="";
										if($aContent['artistId']){
											$artistHidden=$aContent['artistId'].",";;
											if($aContent['artistNameArr']){
												foreach($aContent['artistNameArr'] as $kStar=>$vStar){
													$artistBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($artistBox,",")?>
          </div>
        </div>
		<div class="input FL50">
          <label for="input1">Song Playlist</label>
          <?php
										$playlistBox="";
										$albumHidden="";
										if($aContent['playlistId']){
											$playlistHidden=$aContent['playlistId'].",";;
											if($aContent['playlistNameArr']){
												foreach($aContent['playlistNameArr'] as $kStar=>$vStar){
													$playlistBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($playlistBox,",")?>
          </div>
        </div>
	</div>	
	<div class="clearfix">
		<div class="input FL50">
          <label for="input1">Video Playlist</label>
          <?php
										$videoplaylistBox="";
										$albumHidden="";
										if($aContent['videoplaylistId']){
											$videoplaylistHidden=$aContent['videoplaylistId'].",";;
											if($aContent['videoplaylistNameArr']){
												foreach($aContent['videoplaylistNameArr'] as $kStar=>$vStar){
													$videoplaylistBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($videoplaylistBox,",")?>
          </div>
        </div>
		<div class="input FL50">
          <label for="input1">Image Playlist</label>
          <?php
										$imageplaylistBox="";
										$albumHidden="";
										if($aContent['imageplaylistId']){
											$imageplaylistHidden=$aContent['imageplaylistId'].",";;
											if($aContent['imageplaylistNameArr']){
												foreach($aContent['imageplaylistNameArr'] as $kStar=>$vStar){
													$imageplaylistBox .= $vStar.", ";
											?>
          <?php
												}
											}
										}	
									?>
          <div class='text-field-disabled'>
            <?=rtrim($imageplaylistBox,",")?>
          </div>
        </div>
	</div>
	  <div class="clearfix">
          <div class="input ">
            <label for="input1">Event Desc</label>
            <div class='text-field-disabled'>
			<?=$aContent['eventDesc']?>
			</div>
          </div>
	  </div>	        	
		
           </div>
  </div>	
</div>