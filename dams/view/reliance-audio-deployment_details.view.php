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
		  <div class="input FL PR5">Start Date :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['startDate']; ?></label>
            
		  </div>
		  <div class="input FL PR5">End Date :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['endDate']; ?></label>
            
		  </div>
		  <div class="input FL PR5">Album :
			<label for="input" style="display: inline-table"><?php echo $showData->album; ?></label>
            
		  </div>
		  <div class="input FL PR5">Clano :
			<label for="input" style="display: inline-table"><?php echo $providerDetails['clano']; ?></label>
			
		  </div>
		  <div class="input FL PR5">Artist :
			<label for="input" style="display: inline-table"><?php echo $showData->keyartist; ?></label>
			
		  </div>
		  <div class="input FL PR5">Music Director :
			<label for="input" style="display: inline-table"><?php echo $showData->music_director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Search key :
			<label for="input" style="display: inline-table"><?php echo $showData->search_key; ?></label>
            
		  </div>
		  <div class="input FL PR5">Director :
			<label for="input" style="display: inline-table"><?php echo $showData->director; ?></label>
            
		  </div>
		  <div class="input FL PR5">Producer :
			<label for="input" style="display: inline-table"><?php echo $showData->producer; ?></label>
            
		  </div>
		  <div class="input FL PR5">Year of Release :
			<label for="input" style="display: inline-table"><?php echo $showData->release_year; ?></label>
            
		  </div>
		  <div class="input FL PR5">Album Year :
			<label for="input" style="display: inline-table"><?php echo $showData->album_year; ?></label>
            
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
		  <div class="input FL PR5">ISRC Code :
			<label for="input" style="display: inline-table"><?php echo $showData->isrc; ?></label>
		  </div>
    	</div>
        <div class="cb"></div>
		<div class="clearfix">
		  <div class="input FL PR5">Wap Preview amr :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['WapPreviewAmr']?>
			</label>
			<br/>
			<?php
				if($providerDetails['WapPreviewAmr']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewAmr']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewAmr_arr']){
					foreach($providerDetails['file_WapPreviewAmr_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewAmr_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">Wap/Web Preview mp3 :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['WapPreviewMp3']?>
			</label>
			<br/>
			<?php
				if($providerDetails['WapPreviewMp3']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewMp3']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewMp3_arr']){
					foreach($providerDetails['file_WapPreviewMp3_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewMp3_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">Wap Preview gif(50x50) :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['WapPreviewGif5050']?>
			</label>
			<br/>
			<?php
				if($providerDetails['WapPreviewGif5050']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WapPreviewGif5050']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_WapPreviewGif5050_arr']){
					foreach($providerDetails['file_WapPreviewGif5050_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WapPreviewGif5050_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$fVal."?".date("His");?>" style="display:none" />
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">Web Preview gif(101x80) :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['WebPreviewGif10180']?>
			</label>
			<br/>
			<?php
				if($providerDetails['WebPreviewGif10180']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif10180']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_WebPreviewGif10180_arr']){
					foreach($providerDetails['file_WebPreviewGif10180_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WebPreviewGif10180_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none"  />
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">Web Preview gif(96x96) :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['WebPreviewGif9696']?>
			</label>
			<br/>
			<?php
				if($providerDetails['WebPreviewGif9696']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['WebPreviewGif9696']."?".date("His");?>"  style="display:none"/>
			<br/>
			<?php }elseif($providerDetails['file_WebPreviewGif9696_arr']){
					foreach($providerDetails['file_WebPreviewGif9696_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_WebPreviewGif9696_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none" />
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">FLA Object Mp3 :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['FlaObjMp3']?>
			</label>
			<br/>
			<?php
				if($providerDetails['FlaObjMp3']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjMp3']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_FlaObjMp3_arr']){
					foreach($providerDetails['file_FlaObjMp3_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObjMp3_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">FLA Object amr :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['FlaObjAmr']?>
			</label>
			<br/>
			<?php
				if($providerDetails['FlaObjAmr']){
			?>
			<audio id="audiox1_<?=$showData->id?>" style="width: 200px;" src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" controls="controls">
				<source src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" type="audio/wav"/>
				<object data="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" height="50">
					<embed src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObjAmr']."?".date("His");?>" height="50">
						Sorry, your browser does not support.
					</embed>
				</object>
			</audio>
			<br/>
			<?php }elseif($providerDetails['file_FlaObjAmr_arr']){
					foreach($providerDetails['file_FlaObjAmr_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObjAmr_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<audio id="audiox2_<?=$showData->id?>" style="width: 200px; margin-bottom: -9px;" src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" controls="controls">
						<source src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" type="audio/wav"/>
						<object data="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
							<embed src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" height="50">
								Sorry, your browser does not support.
							</embed>
						</object>
					</audio>
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">FLA Object 140x140 jpg :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['FlaObj140140Jpg']?>
			</label>
			<br/>
			<?php
				if($providerDetails['FlaObj140140Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj140140Jpg']."?".date("His");?>" style="display:none"  />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj140140Jpg_arr']){
					foreach($providerDetails['file_FlaObj140140Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj140140Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none"  />
					<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">FLA Object 300x300 jpg :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['FlaObj300300Jpg']?>
			</label>
			<br/>
			<?php
				if($providerDetails['FlaObj300300Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj300300Jpg']."?".date("His");?>" style="display:none" />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj300300Jpg_arr']){
					foreach($providerDetails['file_FlaObj300300Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj300300Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>" style="display:none" />
						<br/>		
			<?php	}
			}?>
		  </div>
		  <div class="input FL PR5">FLA Object 500x500 jpg :
			<label for="input" style="display: inline-table">
			<?=$providerDetails['FlaObj500500Jpg']?>
			</label>
			<br/>
			<?php
				if($providerDetails['FlaObj500500Jpg']){
			?>
			<img src="<?php echo MEDIA_SITEPATH_DEPLOY.$deploymentFolder."/".$providerDetails['FlaObj500500Jpg']."?".date("His");?>" style="display:none"  />
			<br/>
			<?php }elseif($providerDetails['file_FlaObj500500Jpg_arr']){
					foreach($providerDetails['file_FlaObj500500Jpg_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_FlaObj500500Jpg_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
						<img src="<?php echo MEDIA_SITEPATH_SONGEDITS.$fVal."?".date("His");?>"  style="display:none" />
						<br/>		
			<?php	}
			}?>
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