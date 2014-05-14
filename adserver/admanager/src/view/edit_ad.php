<h1><img src="<?php echo IMG_PATH ;?>icons/posts.png" alt="" />Ads</h1>
<?php if(isset($messenger['data'])){
			extract($messenger['data']);
		}
	
?>
<div class="bloc">
    <div class="title">Ad Edit Form</div>
    <form action="<?php echo SITEPATH ;?>ad" method="post">
	    <div class="content">
	    	<input value="<?php if(isset($ad_data['ad_id'])) echo $ad_data['ad_id'];?>" name="ad_id" type="hidden" id="ad_id" />
	    	<input value="save" name="action" type="hidden" id="action" />
	        <div class="input">
	            <label for="cname">Ad Name</label>
	            <input value="<?php if(isset($ad_data['ad_name'])) echo $ad_data['ad_name'];?>" name="ad_name" type="text" id="ad_name" />
	        </div>
	        
	        <div class="input">
	            <label for="ad_type">Ad Type</label>
	             <select name="ad_type" id="ad_type">
	             		<?php 
	             			if(isset($adType)){
	             				foreach ($adType as $k=>$v){
										echo '<option value="'.$k.'">'.$v.'</option>';
	             				}
	             			}	
			              ?>
			     </select>
	        </div>
	        
	        <div class="input">
	            <label for="dimension_id">Dimensions</label>
	             <select name="dimension_id" id="dimension_id">
	             		<?php 
	             			if(isset($dimensionList)){
	             				foreach ($dimensionList as $dim){
										echo '<option value="'.$dim['dim_id'].'">'.$dim['dim_name'].'</option>';
	             				}
	             			}	
			              ?>
			     </select>
	        </div>
	        
	        <div class="input">
	            <label for="campaign_id">Campaign</label>
	             <select name="campaign_id" id="campaign_id">
	             		<?php 
	             			if(isset($campaignList)){
	             				foreach ($campaignList as $cmp){
										echo '<option value="'.$cmp['cmp_id'].'">'.$cmp['cmp_name'].'</option>';
	             				}
	             			}	
			              ?>
			     </select>
	        </div>
	        
	        <div class="input">
	            <label for="ad_content">Ad Content</label>
	            <input style="width: 80%;" resize="true"  value="<?php if(isset($ad_data['ad_content'])) echo $ad_data['ad_content'];?>" type="textarea" id="ad_content" name="ad_content" />
	            Ad content here
	        </div>
	        
	        <div class="input">
	            <label for="clickurl">On click url</label>
	            <input value="<?php if(isset($ad_data['clickurl'])) echo $ad_data['clickurl'];?>" type="text" id="clickurl" name="clickurl"/>
	        </div>
	        
	           <div class="input">
	            <label for="start_date">Ad Start Date</label>
	            <input value="<?php if(isset($ad_data['start_date'])) echo date('m/d/Y',strtotime($ad_data['start_date']));?>" type="text" class="datepicker" id="start_date" name="start_date"/>
	        </div>
	        
	        <div class="input">
	            <label for="end_date">Ad End Date</label>
	            <input value="<?php if(isset($ad_data['end_date'])) echo date('m/d/Y',strtotime($ad_data['end_date']));?>" type="text" class="datepicker" id="end_date" name="end_date"/>
	        </div>
	        
	        <div class="input">
	            <label for="target_imp">Target Impressions</label>
	            <input value="<?php if(isset($ad_data['target_imp'])) echo $ad_data['target_imp'];?>" type="text" id="target_imp" name="target_imp" />
	            Some informations on how to use this field
	        </div>
	        
	        <div class="input">
	            <label for="target_click">Target Clicks</label>
	            <input value="<?php if(isset($ad_data['target_click'])) echo $ad_data['target_click'];?>" type="text" id="target_click" name="target_click" />
	            Some informations on how to use this field
	        </div>
	
	        
	        <div class="input">
	            <label for="ad_status">Activate</label>
	            <input type="checkbox" id="ad_status" name="ad_status"  <?php if(isset($ad_data['ad_status']) && $ad_data['ad_status']=="on") echo "checked='checked'";?> /> <br/>
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




















