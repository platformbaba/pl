<?php


class AdminController extends BaseController{

	public function execute(){
		$i=100;
		while($i-->0)
			echo "In Admin Controller"."<br>";
	}
}


?>