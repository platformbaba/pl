<?php
class AdvertiserModel extends BaseModel{
	
	
	
	
	public function getAdvertiserNames($criteria=array()){
		
		$status =null;
		$advIsIn = null;
		if(isset($criteria['status'])){
			$status = $criteria['status'];
		}
		if(isset($criteria['advIds'])){
			$advIsIn = "(".implode($criteria['advIds'],",").")";
		}
		
		$query = "select * from advertiser ";
		$where = ' where 1=1 ';
		if($status !=null)
			$where .=' and adv_status = '.$status;
		if($advIsIn != null)
			$where .=' and adv_id in '.$advIsIn;
		
		$query.=$where;
		$res = $this->mysql->query($query);
		return $res;
	}
}