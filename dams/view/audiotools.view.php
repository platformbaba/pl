<!-- AUDIO CONTENT HERE  --> 

<!--
<script type="text/javascript" src="<?php echo JSPATH; ?>audiovideotools.js"></script>
<script type="text/javascript" src="<?php echo JSPATH; ?>jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH; ?>jquery.fancybox-1.3.4.css" media="screen" />-->
 
<style>
.REDBACK{
background-color:#CC3300;
}
</style>
<div id="content">


  
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Audio Tools </h1>

<h1 class="headTitleNew">Song : <?='"'.$data["songName"].'"';?></h1>
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


	<script type="text/javascript">
		alreadyEditedData=[];
	
	</script>	


<div class="bloc">
    <div class="title">Edited Version of Song: <?=$data["songName"];?></div>
    	<div class="content">
				<table>
            <thead>
                <tr>
					<!--<th><input type="checkbox" class="checkall"/></th>-->
                    <th>Song Id</th>
					<th>Song Name</th>
                     <th>Format</th>
					<th>PlatForm</th>                   
					<th>Edit Duration</th>
					<th>Audio Bitrate</th>
					<th>Samplerate</th>
					<th>Create Date</th>
					<th>Status</th>
					<th>Play</th>
                </tr>
            </thead>			
            <tbody>
<?php	
if( !empty($aContent) ){
	$config_id_arr = array();
	foreach( $aContent[(int)$_GET['id']] as $showData){

		$st     = ($showData->Status_Rel == 1) ?  "publish.gif" : "draft.gif";  //Looking for edited song status.
		$duration = ($showData->editDuration=='0--0') ? "Full" : $showData->editDuration;
	    $play = ( $showData->Status_Rel == 1) ? '<td>'."<a class='playpopup' target='_blank' href='source/$showData->path_Rel' _path='$showData->path_Rel' onclick='showPopup(this);' title='play' value='Play'>Play</a>".'</td>' : '<td>&nbsp;</td>' ; // 1=> Play, 0=> Non Play
		 
//		array_push($config_id_arr,$showData->configId);
?>

<?php		
		echo '<tr><td>'.$showData->songId.'</td>
				  <td>'.$showData->song_name.'</td>
				  <td>'.$showData->forMate.'</td>
				  <td>'.$showData->platForm.'</td>
				  <td>'.$duration.'</td>
				  <td>'.$showData->audioBitrate.'</td>
				  <td>'.$showData->sampleRate.'</td>
				  <td>'.$showData->insertDate.'</td>
				  <td>'."<img src=".IMGPATH."icons/".$st." alt=''>".'</td>'			  
				  .$play.'
			  </tr>';
		echo "<script > alreadyEditedData.push('$showData->configId'+'--'+'$showData->editDuration') </script>";	  
		}
	


}
?>
	</tbody>
        </table>
	    </div>		
		<div class="pagination">
		<?=$sPaging;?>            
        </div>		
	</div>	




<!--<div class="adoClass clearfix"><audio id="_audiotool" src="<?=STORAGEPATH."orignal/".$data['songPath'];?>" controls>
  Your user agent does not support the HTML5 Audio element.
</audio></div>-->


	<script type="text/javascript">
	
	function array_exists(arr, val){
		for(var i =0; i<arr.length ; i++){
			if(arr[i]==val){
				return true;
			}
		}
		return false;
	}
	
	var globalData = {};
		var prev = [];
		
		function render(that){
			var splits = $(that).val().toString().split(",");
		
			for(var i in globalData){
				globalData[i]["r"] = 1;
			}
		
			for(var i =0;i<splits.length;i++){
				
				if(!(splits[i] in globalData)){
				//	globalData[splits[i]] = {};
					getConfigsForPlatform(splits[i]);
				}else{
					globalData[splits[i]]["r"] = 0;
					if(globalData[splits[i]]["display"] == 0){
						globalData[splits[i]]["display"] = 1;
						draw(splits[i] , globalData[splits[i]]["data"]);
					}
				}
				
			}	
			
			for(var i in globalData){
				if(globalData[i]["r"] == 1 ){
					globalData[i]["display"] = 0;
				}
				if(globalData[i]["display"] == 0){
					_remove(i);
				}
			}	
		}
		
		function getConfigsForPlatform(platform){
			$.post("<?=SITEPATH?>audiotools?action=view&type=ajax&platform="+platform,function(data){
				 	 var _d = JSON.parse(data);
					 platform = ($.trim(platform)).replace(" ","_");
					 globalData[platform] = {};
					 globalData[platform]["data"] = _d;
					 globalData[platform]["display"] = 1;
					 globalData[platform]["r"] = 0;
					 draw(platform,_d);
			});
		}
		
		function _remove(val){
		  $( '.'+$.trim(val)+'' ).remove();
		}
		
					
		function draw(platform,data){
		
				for(var i in data){
				 var str = '';
				 str += '<li class="horiList clearfix">';
		
				 var config_data = data[i].split("--");
				 
				  str +='<div class="blockWidh width10" width="10%" align="center"><input type="checkbox" name="config_ids[]" value="'+config_data[0]+'"  /></div>';
				  
				  for(var j=1;j<config_data.length;j++){
				  
					   if(config_data[j]=='')
				         str +='<div class="blockWidh" width="15%">Full</div>';
						else
						str +='<div class="blockWidh" width="15%">'+config_data[j]+'</div>'; 
				  } 
				  
				   str +='</li>';

					if(!(data[i] instanceof Object) ){
					    str = str;
						$("#displayArea").append('<ul class="'+$.trim(platform)+'" >'+str+"</ul>");
						
				    }		
				}
		}
		
		$(document).ready(function(){
		
		
				var vid = new audioVideoEditor("_audiotool");
				vid.edit();
				

			$('#myForm').submit(function() {
			    var frmTime = vid.getFromTime();
				var toTime = vid.getToTime();
			 	$("#getfromTime").val(vid.getFromTime());
				$("#gettoTime").val(vid.getToTime());
				var toProceed = true;
				$('[name="config_ids[]"]').each(function(){
					$(this).parent().removeClass("REDBACK");
					if($(this).attr("checked") == "checked" || $(this).attr("checked")==true){
						var toCheck = $(this).val()+"--"+frmTime+"--"+toTime;
						if(array_exists(alreadyEditedData,toCheck)){
							alert("selected configuration already exists");
							$(this).parent().addClass("REDBACK");
							toProceed = false;
						}
					} 
				
				});
				if(!toProceed){
					return false;
				}
				var confirmBox = confirm("Are you sure to edit a song !!")
				if (confirmBox==true)
				  {
				 	return true;
				  }
					return false;
					
				
			});
				
		});
	
	
	
				
    </script>
<!--<div id="inline" style="display: none;">
		<div  style="width:400px;height:100px;overflow:auto;"><br><br><div id="fancybox-close"></div>
			<audio id="_audiotooll" controls>
  					Your user agent does not support the HTML5 Audio element.
			</audio>			
		</div>
</div>
--><div class="bloc">

    <div class="title"><!--<?=ucwords($_GET['action'])?>--> Edit Audio Song</div>
    <div class="content">

	<form id="myForm" action="<?php echo SITEPATH;?>audiotools?action=<?=$_GET['action']?>&id=<?=$_GET['id']?>&type=submit" enctype="multipart/form-data" method="post">
		<input  id="getfromTime" name="getfromTime" type="text" hidden  />
		<input  id="gettoTime" name="gettoTime" type="text" hidden  />
		<input  name="song_id" type="text" hidden value="<?=$_GET['id'];?>"  />
       <h3 class="head3Title">Select Platform.</h3>
 
	        <select class="selectBoxPlay" id="platform" name="platform" multiple="multiple" size="10" onchange="render(this);">
	           <?php
			   		foreach($data["platforms"] as $_d){
						echo "<option value='".$_d->platform."' >".$_d->platform."</option>";   
					}
			   ?>
	        </select>
			<div class="ulListing ulListingHead">
				<ul>
					 <li class="horiList clearfix">
						<!--<th><input type="checkbox" class="checkall"/></th>-->
						<div width="10%" class="blockWidh width10">&nbsp;&nbsp;&nbsp;</div>
						<div width="15%" class="blockWidh">Plateform</div>
						<div width="15%" class="blockWidh">Format</div>
						<div width="15%" class="blockWidh">Audio Bitrate</div>
						<div width="15%" class="blockWidh">Hz</div>
						<div width="15%" class="blockWidh">Duration</div>
					</li>
				</ul>
			</div>
			<div id='displayArea' class="ulListing"></div>
		        <div class="submit" style="clear:both; padding-top: 10px;">
            <input type="submit" value="Submit" class="black"/>
        </div>
		</form>
</div>
	
</div>
</div>