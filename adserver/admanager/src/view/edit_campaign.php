<h1><img src="<?php echo IMG_PATH ;?>icons/posts.png" alt="" />Campaigns</h1>
<?php if(isset($messenger['data']['cmp_data'])){
			extract($messenger['data']['cmp_data']);
		}
	
?>
<div class="bloc">
    <div class="title">Campaign Edit Form</div>
    <form action="<?php echo SITEPATH ;?>campaign" method="post">
	    <div class="content">
	    	<input value="<?php if(isset($cmp_id)) echo $cmp_id;?>" name="cmp_id" type="hidden" id="cmp_id" />
	    	<input value="save" name="action" type="hidden" id="action" />
	        <div class="input">
	            <label for="cname">Campaign Name</label>
	            <input value="<?php if(isset($cmp_name)) echo $cmp_name;?>" name="cmp_name" type="text" id="cmp_name" />
	        </div>
	        
	        <div class="input">
	            <label for="advertiser_id">Advertiser for Campaign</label>
	             <select name="advertiser_id" id="advertiser_id">
	             		<?php 
	             			if(isset($messenger['data']['advList'])){
	             				foreach ($messenger['data']['advList'] as $adv){
									if($advId==$adv["adv_id"])
	             						echo '<option selected value="'.$adv["adv_id"].'">'.$adv["adv_name"].'</option>';
									else 
										echo '<option value="'.$adv["adv_id"].'">'.$adv["adv_name"].'</option>';
	             				}
	             			}	
			              ?>
			     </select>
	        </div>
	        
	        <div class="input">
	            <label for="cmp_start_date">Campaign Start Date</label>
	            <input value="<?php if(isset($cmp_start_date)) echo date('m/d/Y',strtotime($cmp_start_date));?>" type="text" class="datepicker" id="cmp_start_date" name="cmp_start_date"/>
	        </div>
	        
	        <div class="input">
	            <label for="cmp_end_date">Campaign End Date</label>
	            <input value="<?php if(isset($cmp_end_date)) echo date('m/d/Y',strtotime($cmp_end_date));?>" type="text" class="datepicker" id="cmp_end_date" name="cmp_end_date"/>
	        </div>
	        
	        <div class="input">
	            <label for="cmp_target_imp">Target Impressions</label>
	            <input value="<?php if(isset($cmp_target_imp)) echo $cmp_target_imp;?>" type="text" id="cmp_target_imp" name="cmp_target_imp" />
	            Some informations on how to use this field
	        </div>
	        
	        <div class="input">
	            <label for="cmp_target_click">Target Clicks</label>
	            <input value="<?php if(isset($cmp_target_click)) echo $cmp_target_click;?>" type="text" id="cmp_target_click" name="cmp_target_click" />
	            Some informations on how to use this field
	        </div>
	        
	        <div class="input">
	            <label for="cmp_priority">Priority</label>
	            <input value="<?php if(isset($cmp_priority)) echo $cmp_priority;?>" type="text" id="cmp_priority" name="cmp_priority" />
	            Some informations on how to use this field
	        </div>
	        
	        <div class="input">
	            <label for="cmp_status">Activate</label>
	            <input type="checkbox" id="cmp_status" name="cmp_status"  <?php if(isset($cmp_status) && $cmp_status==1) echo "checked='checked'";?> /> <br/>
	        </div>
	       
	    <!--     
	        <div class="input medium error">
	            <label for="input2">Medium input with error</label>
	            <input type="text" id="input2" />
	            <span class="error-message">This field can't be empty !</span>
	        </div>
	        
	        
	        <div class="input long">
	            <label for="input3">Loooooooooong input</label>
	            <input type="text" id="input3" />
	        </div>
	        <div class="input">
	            <label for="file">Upload a file</label>
	            <input type="file" id="file" />
	        </div>
	
	        <div class="input">
	            <label class="label">Checkboxes</label>
	            <input type="checkbox" id="check1" checked="checked"/><label for="check1" class="inline">This is a checkbox</label> <br/>
	            <input type="checkbox" id="check2" /><label for="check2" class="inline">Another one !</label> <br/>
	        </div>
	        <div class="input">
	            <label class="label">Radio</label>
	            <input type="radio" id="radio1" name="radiobutton"  checked="checked"/><label for="radio1" class="inline">This is a radio input</label> <br/>
	            <input type="radio" id="radio2"  name="radiobutton"/><label for="radio2" class="inline">And this is another radio input</label>
	        </div>
	        <div class="input">
	            <label for="select">This is a "select" input</label>
	            <select name="select" id="select">
	                <option value="1">First value</option>
	                <option value="2">Second value</option>
	                <option value="3">Third value</option>
	            </select>
	        </div>
	        <div class="input textarea">
	            <label for="textarea1">Textarea</label>
	            <textarea name="text" id="textarea1" rows="7" cols="4"></textarea>
	        </div> -->
	       <!--  <div class="submit">
	            <input type="submit" value="Submit" />
	            <input type="reset" value="Black button" class="black"/> 
	            <input type="reset" value="Reset" class="white"/>
	        </div> -->
	        <div class="submit FR">
	            <input type="submit" value="Save Details" />
	           <!--  <input type="reset" value="Black button" class="black"/> --> 
	            <input type="reset" value="Reset Details" class="white"/>
			</div>
		</form>
    </div>




















