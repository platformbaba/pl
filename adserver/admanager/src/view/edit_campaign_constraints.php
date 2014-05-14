<h1><img src="<?php echo IMG_PATH ;?>icons/posts.png" alt="" />Campaigns</h1>

<?php if(isset($messenger['data'])){
	$cmp_data=null;
	extract($messenger['data']);
	if(isset($messenger['data']['cmp_data'])){
		$cmp_data=$messenger['data']['cmp_data'];
		
	}
}?>
<div class="bloc">
	<form action="<?php echo SITEPATH ;?>campaign" method="post">
	<div class="title">Campaign Constraints</div>
		
		<input value="savec" name="action" type="hidden" id="action" />
		<?php 
			if(isset($con_id))
				echo "<input type='hidden' id='con_id' name='con_id' value=$con_id />";
			if(isset($cmp_data) && isset($cmp_data['cmp_id'])){
				$cmpId =$cmp_data['cmp_id'];
				echo "<input type='hidden' id='cmp_id' name='cmp_id' value=$cmpId />";
			}
		?>
		<div class="content">
			<div class="input">
            	<label class="label">Activate Campaign Constraints</label>
            	<input type="checkbox" id="con_status" name="con_status"
            	<?php if(isset($cmp_data['con_status'])) echo 'checked=true'?>
            	/><label for="con_status" class="inline"></label> <br/>
       		</div>
			
			<div>
				<label>Weekday Constraints</label>
				  <div class="input">
	            	<label class="label">Weekday Include/Exclude</label>
	            	<input type="checkbox" id="inc_exc_week" name="inc_exc_week" 
	            	<?php if(isset($cmp_data['inc_exc_week'])) echo 'checked=true'?>
	            	/><label for="inc_exc_week" class="inline"></label> <br/>
	       		</div>
				<select class="uniform-multiselect" size="5" multiple="multiple" id="week" name="week[]">
				<?php 
					
					if(isset($weekList)){
						foreach ($weekList as $code=>$name){
							if(isset($cmp_data['week']) && in_array($code,$cmp_data['week']))
								echo "<option selected value='$code'>$name</option>";
							else
								echo "<option value='$code'>$name</option>";
						}
					}
				?>     
	            </select>
	           
			</div>
			<div>
				<label> Time Constraints</label>
					<div class="input">
		            	<label class="label">Time Include/Exclude</label>
		            	<input type="checkbox" id="inc_exc_time" name="inc_exc_time" 
		            	<?php if(isset($cmp_data['inc_exc_time'])) echo 'checked=true'?>
		            	/><label for="inc_exc_time" class="inline"></label> <br/>
		       		</div>
					<div class="input">
            			<label for="st_time">From time</label>
			            <select  id="select" name="st_time">
			                
			                <?php 
			                	for($i=0;$i<24;$i++){
									$_i = $i<9?'0'.$i:$i;
			                		for($k=0;$k<60;$k=$k+15){
										$_k = $k<9?'0'.$k:$k;	
										if(isset($cmp_data['st_time']) && $_i.":".$_k.":00"==$cmp_data['st_time'])
			                				echo "<option selected value='$_i".":"."$_k'>$_i".":"."$_k</option>";
										else 
											echo "<option value='$_i".":"."$_k'>$_i".":"."$_k</option>";
			                		}
			                	}
			                ?>
			            </select>
        			</div>
        			<div class="input">
            			<label for="end_time">To Time</label>
			            <select id="select" name=end_time>
			                 <?php 
			                	for($i=0;$i<24;$i++){
									$_i = $i<9?'0'.$i:$i;
			                		for($k=0;$k<60;$k=$k+15){
										$_k = $k<9?'0'.$k:$k;	
										if(isset($cmp_data['end_time']) && $_i.":".$_k.":00"==$cmp_data['end_time'])
			                				echo "<option selected value='$_i".":"."$_k'>$_i".":"."$_k</option>";
										else
											echo "<option value='$_i".":"."$_k'>$_i".":"."$_k</option>";
			                		}
			                	}
			                ?>
			               
			            </select>
        			</div>
			</div>
			
			<div>
				<label>Geo Constraints</label>
						<div class="input">
	            			<label class="label">Geo Include/Exclude</label>
	            			<input type="checkbox" id="inc_exc_geo" name="inc_exc_geo" 
	            			<?php if(isset($cmp_data['inc_exc_geo'])) echo 'checked=true'?>
	            			/><label for="check2" class="inline"></label> <br/>
	       				</div>
						<label>Country</label>
						
						<select class="uniform-multiselect" size="5" multiple="multiple" id="role" name="country[]">
							<?php 
								if(isset($countryList)){
									foreach ($countryList as $code=>$name){
									if(isset($cmp_data['country']) && in_array($code,$cmp_data['country']))
										echo "<option selected value='$code'>$name</option>";
									else
										echo "<option value='$code'>$name</option>";
										
									}
								}
							?>     
		           	 	</select>
	            
	            		
	            		<select class="uniform-multiselect" size="5" multiple="multiple" id="role" name="state[]">
							<?php 
								if(isset($stateList)){
									foreach ($stateList as $code=>$name){
										if(isset($cmp_data['state']) && in_array($code,$cmp_data['state']))
											echo "<option selected value='$code'>$name</option>";
										else
											echo "<option value='$code'>$name</option>";

									}
								}
							?>     
		           	 	</select>
		      
			           <select class="uniform-multiselect" size="5" multiple="multiple" id="role" name="city[]">
							<?php 
								if(isset($cityList)){
									foreach ($cityList as $code=>$name){
										if(isset($cmp_data['city']) && in_array($code,$cmp_data['city']))
											echo "<option selected value='$code'>$name</option>";
										else
											echo "<option value='$code'>$name</option>";
									}
								}
							?>     
		           	 	</select>
	            </div>
	             
			</div>
		
		
			<div class="submit FR">
	            <input type="submit" value="Save Constraints" />
	           <!--  <input type="reset" value="Black button" class="black"/> --> 
	            <input type="reset" value="Reset Constraints" class="white"/>
			</div>
			</form>
</div>

