<?php

class DimensionModel extends BaseModel{

	public function listDimensions($criteria = array()){
		$status =null;
		if(isset($criteria['status'])){
			$status = $criteria['status'];
		}
		$query = "select * from dimension ";
		$where = " where 1=1  ";
		if($status!=null)
			$where.=" and dim_status=1";
		$query.=$where;
		$res = $this->mysql->query($query);
		
		return $res;
	}
}