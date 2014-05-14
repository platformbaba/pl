<?php
class AdModel extends BaseModel{
	
	
	public function listAds($criteria=array()){
		$status =null;
		$advIsIn = null;
		$cmpId = null;
		if(isset($criteria['status'])){
			$status = $criteria['status'];
		}
		if(isset($criteria['advIds'])){
			$advIsIn = "(".implode($criteria['advIds'],",").")";
		}
		if(isset($criteria['cmpId'])){
			$cmpId = $criteria['cmpId'];
		}
		$query = "select * from ad left join campaign as cmp on ( ad.campaign_id=cmp.cmp_id )
					inner join advertiser adv on (adv.adv_id = cmp.advertiser_id) 
					inner join dimension dim on (dim.dim_id= ad.dimension_id)
				
				";
		$where = ' where 1=1 ';
		if($status !=null)
			$where .=' and ad_status = '.$status;
		if($advIsIn != null)
			$where .=' and adv.adv_id in '.$advIsIn;
		if($cmpId !=null)
			$where .=' and cmp_id = '.$cmpId;
		
		$query.=$where;
		$res = $this->mysql->query($query);
		return $res;
	}
}