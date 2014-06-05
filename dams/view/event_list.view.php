<!--            
    CONTENT 
			--> 
<div id="content">
	<div>
		<span class='FL'><h1><img src="<?php echo IMGPATH; ?>icons/cal-event.png" alt="" width='40' height='40'/>Event Calendar</h1></span>
		<span class='FR MT40'>
			<?php if ($this->user->hasPrivilege(strtolower(MODULENAME)."_add")){ echo '<a href="'.SITEPATH.'event?action=add" title="Add New" class="button">Add New</a>'; } ?>
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
<div class="bloc">
    <div class="title">
        Search Filters:
    <a class="toggle" href="#"></a></div>
    <div class="content">
		<form id='srcFrm' name='srcFrm' method='GET'>
		<div class="clearfix">
			<div class="input FL PR30">
				<label for="input">Event Name:</label>
				<input type="text" id="srcText" name="srcText" value="<?php echo $aSearch['srcText']; ?>" class="WD150" />
			</div>
			
			<div class="input FL PR30">
			
				<label for="input">Event Type:</label>
				<select name="srcTxtType" id="srcTxtType" >
					<option value="">Select</option>
					<?php
						
						foreach( $calendar_event as $v=>$k ){
							$check = ($aSearch['srcTxtType']==$v ? 'selected':'');
							echo '<option value="'.$v.'" '.$check.'>'.ucfirst($k).'</option>';
						} 
					?>
				</select>
			</div>
		  <div class="input FL PR30">
            <label for="input">Start Date :</label>
            <input type="text" id="srcSrtDate" name="srcSrtDate" value="<?=$aSearch['srcSrtDate']?>" class="datepicker"/>
          </div>
		  <div class="input FL PR30">
            <label for="input">End Date :</label>
            <input type="text" id="srcEndDate" name="srcEndDate" value="<?=$aSearch['srcEndDate']?>" class="datepicker"/>
          </div>
		
		<div class="input FL PR30">
            <label for="select">Language</label>
            <select name="languageIds" id="select" >
              <option value="0">Select Language</option>
              <?php 
			  
						foreach($languageList as $kL=>$vL){
							if($aSearch['languageIds']){
								$selStr = ($vL->language_id==$aSearch['languageIds'])?"selected='selected'":"";
							}
							echo '<option value="'.$vL->language_id.'" '.$selStr.' >'.ucwords($vL->language_name).'</option>';
						}
					?>
            </select>
          </div>			
		
		</div>
	  <div class="input FL PR30">
            <label for="input">Artist :</label>
            <input type="text" id="srcArtist" name="srcArtist" value="<?php echo $aSearch['srcArtist']; ?>" class="autosuggestartist WD150"/>
			<input type="hidden" name="autosuggestartist_hddn" id="autosuggestartist_hddn" value="<?php echo $aSearch['autosuggestartist_hddn']; ?>"  />
       </div>
		
	<div class="input FL">
				<label for="input">Status:</label>
				<select name="srcCType" id="srcCType" >
					<option value="">Select</option>
					<?php
						$actionArr = TOOLS::getContentActionTypes( array('type'=>'form') );
						foreach( $actionArr as $k=>$act ){
							$check = ($aSearch['srcCType']==$act ? 'selected':'');
							echo '<option value="'.$act.'" '.$check.'>'.ucfirst($act).'</option>';
						} 
					?>
				</select>
			</div>	
		<div class="submit" align='right'>
			<input type="submit" value="Search" name="submitBtn" style='margin:0 auto' />
		</div>
		
		<div class="cb"></div>
		</form>
    </div>
</div>
<!-- Search Box end -->
<div class="bloc">
    <div class="title">
        Events Lists
    </div>
    <div class="content">
			
        <form id='actFrm' name='actFrm' method="POST">
		<table>
            <thead>
                <tr>
					<th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Event Name</th>
					<th>Language</th>
					 <th>Start Date</th>
					 <th>End Date</th>
                    <th>Event Type</th>
					<th>Manage Contents</th>
					<th>Insert Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
			if( !empty($aContent) ){
			
					foreach( $aContent as $showData){
						$dis_type = TOOLS::display_event_type($showData->event_type);
						
				?>
				<tr>
					<td><?php TOOLS::displayCheckBoxList( array( 'id'=>$showData->event_id, 'status'=>$showData->status, 'model'=>'event', 'flow'=>'' ) ); ?>	</td>
					<td><?php echo $showData->event_id; ?></td>
					<td><a href="<?=SITEPATH?>event?action=view&id=<?=$showData->event_id?>&isPlane=1&do=details" class="fancybox fancybox.iframe" title="View Events Details"><?php 					echo $showData->event_name; ?></a></td>
					<td>
					
					<?php  
						
						foreach($languageList as $kL=>$vL){
							
							if($showData->language_id){
								
								if($showData->language_id==$vL->language_id){
									echo  ucwords($vL->language_name);
								}
							}
						}
					
					if($showData->language_id == 0) echo "Not Mention";	
 					?>
					</td>
					<td><?php  echo date('d M Y',strtotime($showData->start_date)); ?></td>
					<td><?php  echo ($showData->end_date!='0000-00-00') ? date('d M Y',strtotime($showData->end_date)): "Not Mention"; ?></td>
					<td><?php  echo ucfirst($dis_type); ?></td>
					<td><a href="<?=SITEPATH?>event_related?action=view&id=<?=$showData->event_id?>&isPlane=1&cType=20&relatedCType=4&type=all" class="fancybox fancybox.iframe" title="Manage Contents">Contents</a></td>
					<td><?php  echo date('d M Y',strtotime($showData->insert_date)); ?></td>
                    <td class="actions">
						<?php TOOLS::displayActionHtml( $this, array( 'id'=>$showData->event_id, 'status'=>$showData->status, 'model'=>'event', 'flow'=>'' ) ); ?>
					</td>
                </tr>
				<?php
					} /* foreach end */
				}else{
					echo '<tr>
							<td colspan=8>'.$aConfig['no-contents'].'</td>
						  </tr>';
				} /* If End */
				?>
			</tbody>
        </table>
			
		<?php TOOLS::displayMultiActionHtml( $this, array( 'id'=>$showData->event_id, 'status'=>$showData->status, 'model'=>'event', 'flow'=>'' ) ); ?>
		</form>
		<div class="pagination">
		<?php
			echo $sPaging;
		?>            
        </div>

    </div>
</div>

<form id='actionFrm' name='actionFrm' method="POST">
<input type="hidden" id="contentId" name="contentId" value="">
<input type="hidden" id="contentAction" name="contentAction" value="">
<input type="hidden" id="contentModel" name="contentModel" value="">
</form>

</div>
<!--  CONTENT End -->
<script type="text/javascript">
var artistOptions, artistautocom;
	jQuery(function(){
	  artistOptions = { serviceUrl:'<?=SITEPATH?>ajax?action=view&type=', minChars:2, width:230,  delimiter: /(,|;)\s*/ ,class : "autosuggestartist"};
	  artistautocom = $('.autosuggestartist').autocomplete(artistOptions);
	});
</script>	
<!--            
    CONTENT End 
			--> 