<?php 
require_once '../lib/mysql.php';

$db = new mysqliDb("adserver");



$ad_data_query="select ads.id,ads.name,ads.type,ads.clickurl,ads.ad_content,dim.name,cmp.priority

from adserver.ad as ads inner join 

(SELECT id,priority FROM adserver.campaign where 
status =1 
and (curr_imp <target_imp || target_imp=-1) 
and( curr_click < target_click || target_click=-1)
and now() between start_date and end_date ) as cmp  on (ads.campaign_id = cmp.id)
inner join adserver.dimension as dim on(dim.id=ads.dimension_id)

where

ads.status =1 
and (ads.curr_imp <ads.target_imp || ads.target_imp=-1) 
and( ads.curr_click < ads.target_click || ads.target_click=-1)
and now() between ads.start_date and ads.end_date 
";

$resp = $db->query($ad_data_query);
$valid_ads = [];
$ad_data = [];

foreach($resp as $key=>$value){
	$valid_ads[]= $value['id'];
	$adContent = $value['ad_content'];
	$onclick = $value['clickurl'];
	$js = "document.write('<div onclick='".$onclick."'>".$adContent."'</div>)";
	$nojs = array("content"=>$adContent , "onclick" =>$onclick);
	$ad_data[$value['id']]["js"] = $js;
	$ad_data[$value['id']]["nojs"] = $nojs;
}

/// THIS IS VALID_ADS DATA HERE
echo  urlencode(json_encode($ad_data));


echo "\n###############################################\n";

$str= "(".implode($valid_ads,",").")";

$ad_spots_query ="select ads.id as adId,adrel.spot_id as spot_id,cn.id constraint_id,type,adrel.priority ,cn.* from 
	ad as ads inner join ad_spot_rel adrel on ads.id=adrel.ad_id
	inner join spot as spot on spot.id=adrel.spot_id
	left join constraints as cn on ( ads.constraint_id=cn.id and cn.status=1 and 

	
	CASE
		when(cn.inc_exc=1)
			then
				(

					CASE
						when (cn.st_time < cn.end_time)
							then (CURTIME() between cn.st_time and cn.end_time)
						else
							((CURTIME() between '00:00:00' and cn.end_time) or (CURTIME() between cn.st_time and '00:00:00'))
					END
				)
		else !(

					CASE
						when (cn.st_time < cn.end_time)
							then (CURTIME() between cn.st_time and cn.end_time)
						else
							((CURTIME() between '00:00:00' and cn.end_time) or (CURTIME() between cn.st_time and '00:00:00'))
					END
				)
	END

)
	where ads.id in $str
	order by adrel.spot_id";

$resp = $db->query($ad_spots_query);
$ad_spot=[];
foreach($resp as $key=>$value){
	$priority = $value['priority'];
	if($value['constraint_id'] != null && $value['inc_exc']==1){
		while($priority-->0)
			$ad_spot[$value['spot_id']]["includes"][]=$value;
	}
	else{
		while($priority-->0)
			$ad_spot[$value['spot_id']]["excludes"][]=$value;
	}
}
echo urlencode(json_encode($ad_spot));




?>