<?php

class CampaignModel extends BaseModel{
	
	public function saveCampaignDetails($data){
		
		extract($data);
		
		if(isset($cmp_id)){
			//update case
			$query = "update campaign set cmp_name='$cmp_name',cmp_start_date=STR_TO_DATE('$cmp_start_date', '%m/%d/%Y'),
						cmp_end_date=STR_TO_DATE('$cmp_end_date', '%m/%d/%Y'),cmp_target_imp=$cmp_target_imp,
						cmp_target_click=$cmp_target_click,cmp_priority=$cmp_priority,
						advertiser_id=$advertiser_id,cmp_status=$cmp_status,
						update_timestamp=now() where cmp_id=$cmp_id
			";
			//echo $query;
		}else{
			$query = "insert into campaign(
					cmp_name,
					cmp_start_date,
					cmp_end_date,
					cmp_target_imp,
					cmp_target_click,
					cmp_priority,
					advertiser_id,
					cmp_status,
					update_timestamp
					
					) VALUES ( ";
			$values = "'$cmp_name',STR_TO_DATE('$cmp_start_date', '%m/%d/%Y'),STR_TO_DATE('$cmp_end_date', '%m/%d/%Y'),
					$cmp_target_imp,$cmp_target_click,$cmp_priority,$advertiser_id,$cmp_status,NOW()";
					$query.=$values.")";
		}
		return $this->mysql->query($query);
	}
	
	public function saveCampaignConstraints($data){
		extract($data);
		if(isset($con_id)){
			$query = "update constraints set inc_exc_week='$inc_exc_week',week=$week,
						inc_exc_geo=$inc_exc_geo,state=$state,
						city=$city,country=$country,
						inc_exc_time=$inc_exc_time,st_time=$st_time,
						end_time=$end_time,con_status=$con_status,
						update_timestamp=NOW() where con_id=$con_id";
		}else{
			$query = "insert into constraints(
					inc_exc_week,
					week,
					inc_exc_geo,
					state,
					city,
					country,
					inc_exc_time,
					st_time,
					end_time,
					con_status,
					update_timestamp
					) VALUES ( ";
			$values = "$inc_exc_week,'$week',$inc_exc_geo,
			'$state','$city','$country',$inc_exc_time,'$st_time','$end_time',$con_status,NOW()";
			$query.=$values.")";
		}
		$con_id = $this->mysql->query($query);
		if($con_id){
			$query = "update campaign set constraint_id=$con_id where cmp_id=$cmp_id";
			$this->mysql->query($query);
		}
	}
	
	public function saveCampaignAds($data){
	
	}
	
	public function getCampaignConstraints($criteria=array()){
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
		$query = "select * from campaign cmp inner join constraints con on(con.con_id=cmp.constraint_id) ";
		$where = ' where 1=1 ';
		if($status !=null)
			$where .=' and cmp_status = '.$status;
		if($advIsIn != null)
			$where .=' and advertiser_id in '.$advIsIn;
		if($cmpId !=null)
			$where .=' and cmp_id = '.$cmpId;
		
		$query.=$where;
		$res = $this->mysql->query($query);
		return $res;
	}
	
	public function listCampaigns($criteria=array()){
		
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
		$query = "select * from campaign ";
		$where = ' where 1=1 ';
		if($status !=null)
			$where .=' and cmp_status = '.$status;
		if($advIsIn != null)
			$where .=' and advertiser_id in '.$advIsIn;
		if($cmpId !=null)
			$where .=' and cmp_id = '.$cmpId;
		
		$query.=$where;
		
		$res = $this->mysql->query($query);
		return $res;
		
	}
	
}