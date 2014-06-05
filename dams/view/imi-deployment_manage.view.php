<!--                CONTENT 			-->
<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#srcFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true,
		});
	});
</script>
<div id="content"> 
<div>
  <span class='FL '><h1><img src="<?php echo IMGPATH; ?>icons/delievery.png" alt="" width='40' height='40'/>Manage <?=$aDeployment[0]->deployment_name?></h1></span>
  <?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_edit")){?>
  	<?php if($aDeployment[0]->is_ready){?>
  	<span class="FL clearfix MT40">&nbsp;&nbsp;&nbsp;<a class="button" title="" href="<?=SITEPATH?>imi-deployment?action=edit&id=<?=$aDeployment[0]->deployment_id?>&do=zip">Generate Zip File</a></span>  
	<?php }?>
  <?php }?>
  <span class='FR MT40'>
		<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'imi-deployment?action=add&id='.(int)$_GET['id'].'&do=song" title="Add New" class="button">Add New Song</a>'; } ?>
	</span>
  <br class='clear' />	
</div>
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
			$s=1;
			foreach( $aContent as $showData){
				$providerDetails=json_decode($showData->providers_details,true);
	?>
	<div class="bloc" style="width: 450%;" id="bloc_<?=$showData->id?>">
	<div class="content">
        <div class="clearfix">
          <div class="input FL PR5">
            <label for="input">Song Title :</label>
            <input type="text" id="songTitle_<?=$showData->id?>" name="songTitle[<?=$showData->id?>]" value="<?php echo $showData->title; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
            <label for="input">Language :</label>
            <input type="text" id="language_<?=$showData->id?>" name="language[<?=$showData->id?>]" value="<?php echo $showData->language; ?>" class="WD150 validate[required]" />
          </div>
		  <div class="input FL PR5">
            <label for="input">Category :</label>
            <input type="text" id="category_<?=$showData->id?>" name="category[<?=$showData->id?>]" value="<?php echo $providerDetails['category']; ?>" class="WD150 catCls validate[required]" 
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"catCls\",\"val\":this.value})'":""?> />
          </div>
		  <div class="input FL PR5">
            <label for="input">Sub Category :</label>
            <input type="text" id="subCategory_<?=$showData->id?>" name="subCategory[<?=$showData->id?>]" value="<?php echo $providerDetails['subCategory']; ?>" class="WD150 subCatCls validate[required]"
			<?=($s==1)?"onkeyup='applySame({\"cls\":\"subCatCls\",\"val\":this.value})'":""?> />
          </div>
		  <!--<div class="input FL PR5">
            <label for="input">Coid :</label>
            <input type="text" id="coid" name="coid[<?=$showData->id?>]" value="<?php echo $providerDetails['coid']; ?>" class="WD150"/>
          </div>-->
          <!--<div class="input FL PR5">
			<label for="input">Cpid :</label>
            <input type="text" id="cpid" name="cpid[<?=$showData->id?>]" value="<?php echo $providerDetails['cpid']; ?>" class="WD150"/>
		  </div>-->
		  <!--<div class="input FL PR5">
			<label for="input">Clid :</label>
            <input type="text" id="clid" name="clid[<?=$showData->id?>]" value="<?php echo $providerDetails['clid']; ?>" class="WD150"/>
		  </div>-->
		  <div class="input FL PR5">
			<label for="input">Start Date :</label>
            <input type="text" id="startDate_<?=$showData->id?>" name="startDate[<?=$showData->id?>]" value="<?php echo $providerDetails['startDate']; ?>" class="datepicker stdCls validate[required]"		            <?=($s==1)?"onkeyup='applySame({\"cls\":\"stdCls\",\"val\":this.value})'":""?>/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">End Date :</label>
            <input type="text" id="endDate_<?=$showData->id?>" name="endDate[<?=$showData->id?>]" value="<?php echo $providerDetails['endDate']; ?>" class="datepicker validate[required]"/>
		  </div>
		  <!--<div class="input FL PR5">
			<label for="input">Exclusive :</label>
            <input type="text" id="exclusive" name="exclusive[<?=$showData->id?>]" value="<?php echo $providerDetails['exclusive']; ?>" class="WD150"/>
		  </div>-->
		  <div class="input FL PR5">
			<label for="input">Album :</label>
            <input type="text" id="album_<?=$showData->id?>" name="album[<?=$showData->id?>]" value="<?php echo $showData->album; ?>" class="WD150 validate[required]"/>
		  </div>
		  <!--<div class="input FL PR5">
			<label for="input">Clano :</label>
            <input type="text" id="clano" name="clano[<?=$showData->id?>]" value="<?php echo $providerDetails['clano']; ?>" class="WD150"/>
		  </div>-->
		  <div class="input FL PR5">
			<label for="input">Key Artist :</label>
            <input type="text" id="keyArtist_<?=$showData->id?>" name="keyArtist[<?=$showData->id?>]" value="<?php echo $showData->keyartist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Key Music Director :</label>
            <input type="text" id="musicDirector_<?=$showData->id?>" name="musicDirector[<?=$showData->id?>]" value="<?php echo $showData->music_director; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Search key :</label>
            <input type="text" id="searchKey_<?=$showData->id?>" name="searchKey[<?=$showData->id?>]" value="<?php echo $showData->search_key; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Key Director :</label>
            <input type="text" id="keyDirector_<?=$showData->id?>" name="keyDirector[<?=$showData->id?>]" value="<?php echo $showData->director; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Key Producer :</label>
            <input type="text" id="keyProducer_<?=$showData->id?>"  name="keyProducer[<?=$showData->id?>]" value="<?php echo $showData->producer; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Year of Release :</label>
            <input type="text" id="releaseYear_<?=$showData->id?>" name="releaseYear[<?=$showData->id?>]" value="<?php echo $showData->release_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Album Year :</label>
            <input type="text" id="albumYear_<?=$showData->id?>" name="albumYear[<?=$showData->id?>]" value="<?php echo $showData->album_year; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Genre :</label>
            <input type="text" id="genre_<?=$showData->id?>" name="genre[<?=$showData->id?>]" value="<?php echo $showData->genre; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Starcast :</label>
            <input type="text" id="starcast_<?=$showData->id?>" name="starcast[<?=$showData->id?>]" value="<?php echo $showData->starcast; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Lyricist :</label>
            <input type="text" id="lyricist_<?=$showData->id?>" name="lyricist[<?=$showData->id?>]" value="<?php echo $showData->lyricist; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Singer :</label>
            <input type="text" id="singer_<?=$showData->id?>" name="singer[<?=$showData->id?>]" value="<?php echo $showData->singer; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input">Origial Code :</label>
            <input type="text" id="isrc_<?=$showData->id?>" name="isrc[<?=$showData->id?>]" value="<?php echo $showData->isrc; ?>" class="WD150 validate[required]"/>
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">0808m :</label>
			<?=$providerDetails['0808m']?><br/>
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
			<br/>
			<?php }elseif($providerDetails['file_0808m_arr']){
					foreach($providerDetails['file_0808m_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_0808m_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
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
			<input type="file" name="file_0808m[<?=$showData->id?>]" accept="audio/wav"  />
			<input type="hidden" name="hidden_file_0808m[<?=$showData->id?>]" value="<?=$providerDetails['0808m']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">0808m40s :</label>
		  	<?=$providerDetails['0808m40S']?><br/>
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
			<br/>
			<?php }elseif($providerDetails['file_0808m40S_arr']){
					foreach($providerDetails['file_0808m40S_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_0808m40S_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
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
			<input type="file" name="file_0808m40s[<?=$showData->id?>]" accept="audio/wav" style="float:left"  />
			<input type="hidden" name="hidden_file_0808m40s[<?=$showData->id?>]" value="<?=$providerDetails['0808m40S']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">1616m :</label>
		  	<?=$providerDetails['1616m']?><br/>
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
			<br/>
			<?php }elseif($providerDetails['file_1616m_arr']){
					foreach($providerDetails['file_1616m_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_1616m_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
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
			} ?>
			<input type="file" name="file_1616m[<?=$showData->id?>]" accept="audio/wav" />
			<input type="hidden" name="hidden_file_1616m[<?=$showData->id?>]" value="<?=$providerDetails['1616m']?>" />
		  </div>
		  <div class="input FL PR5">
			<label for="input" style="display: inline-table">0808mfull :</label>
		 	<?=$providerDetails['0808mFull']?><br/>
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
			<br/>
			<?php }elseif($providerDetails['file_0808mFull_arr']){
					foreach($providerDetails['file_0808mFull_arr'] as $fKey=>$fVal){?>
						<input type="radio" name="file_0808mFull_rad_<?=$showData->id?>" value="<?=$fVal?>"  />
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
			} ?>
			<input type="file" name="file_0808mfull[<?=$showData->id?>]" accept="audio/wav" />
			<input type="hidden" name="hidden_file_0808mfull[<?=$showData->id?>]" value="<?=$providerDetails['0808mFull']?>" />
		  </div>
		  <div class="input FL PR5">
			<a class="button" title="Rmove this song from deployment" onclick="removeSongFromImi({'id':'<?=$showData->id?>','afile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808mFull']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['1616m']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m40S']?>,<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$providerDetails['0808m']?>','xfile':'<?php echo MEDIA_SEVERPATH_DEPLOY.$deploymentFolder."/".$showData->isrc?>.xml'})" href="javascript:void(0);">Remove This Song</a>
		  </div>
		</div>
		<input type="hidden" name="providerCode[<?=$showData->id?>]" value="<?=$providerDetails['providerCode']?>" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="deploymentId" value="<?=(int)$_GET['id']?>" />
		<input type="hidden" name="do" value="manage" />
		<input type="hidden" name="contentId[<?=$showData->id?>]" value="<?=$showData->content_id?>" />
		<input type="hidden" name="primaryId[]" value="<?=$showData->id?>" />
        <div class="cb"></div>
    	</div>
	</div>
  	<?php
			$s++;
			}
		}	
	?>
	<br/>
	<div class="submit" align='left' >
          <input type="submit" value="Save" name="submitBtn" style='margin:0 auto' />
    </div>
</form>  
<!-- Search Box end -->
</div>
<!--  CONTENT End -->
<script type="text/javascript">
function applySame(obj){
	var className=obj.cls;
	var classValue=obj.val;
	$("."+className).val(classValue);	
}
function removeSongFromImi(obj){
	var r=confirm("Are you sure?");
	if (r==true){
		var id=obj.id;
		var afile=obj.afile;
		var xfile=obj.xfile;
		$.post( "<?=SITEPATH?>ajax?action=view&type=rmimisong",{ id: id, afile: afile, xfile:xfile }, function( data ) {
			if(data=="1"){
				$("#bloc_"+id).hide();		
			}
		});
	}
}
</script>