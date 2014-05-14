<?php



class AdController extends BaseController{
	
	private $advModel ;
	private $cmpModel;
	private $adModel;
	private $dimModel;
	private $views =array(
	
			"EDIT"=>"edit_ad.php",
			"LIST"=>"list_ad.php"
	);
	
	function __construct(){
	
		$this->advModel = new AdvertiserModel();
		$this->adModel = new AdModel();
		$this->dimModel = new DimensionModel();
		$this->cmpModel = new CampaignModel();
	}
	
	public function execute(){
		
		global $messenger;
		
		$action = StringUtils::getFromRequest("action",false,"list");
		if($action == 'list'){
				
			$criteria = array();
			if(isset($messenger['advIds'])){
				$criteria['advIds'] =  $messenger['advIds'];
			}
			$res = $this->adModel->listAds($criteria);
			if($res)
			$messenger['data']['ad_list'] = $res;
			return $this->views['LIST']	;
		
		}elseif ($action =='edit'){
				
			$adId = StringUtils::getFromRequest("id",false);
			if($adId){
				// this is an edit case
				$this->editAd(null,$adId);
			}else{
				// this is a new campaign case
				$this->editAd(null,null);
			}
			return $this->views['EDIT']	;
				
		}elseif ($action =='save'){
			/* var_dump($_REQUEST);
			exit; */	
			$ret =$this->saveAd();
			if($ret){
				return $ret;
			}else{
				header('Location: '.SITEPATH.'ad');
			}
		}
		
	}
	
	private function saveAd(){
		
		$ad_id = StringUtils::getFromRequest("ad_id",false);
		$ad_name = StringUtils::getFromRequest("ad_name",false);
		$ad_type = StringUtils::getFromRequest("ad_type",false);
		$dimension_id = StringUtils::getFromRequest("dimension_id",false);
		$campaign_id = StringUtils::getFromRequest("campaign_id",false);
		$ad_content = StringUtils::getFromRequest("ad_content",false);
		$clickurl = StringUtils::getFromRequest("clickurl",false);
		$start_date = StringUtils::getFromRequest('start_date',false,date("mm/dd/Y"));
		$end_date = StringUtils::getFromRequest('end_date',false,date("mm/dd/Y",strtotime("12/12/2099")));
		$target_imp = StringUtils::getFromRequest("target_imp",false);
		$target_click = StringUtils::getFromRequest("target_click",false);
		$ad_status = StringUtils::getFromRequest("ad_status",false);
		$adData = array(
			"ad_id"=>$ad_id,
			"ad_name"=>$ad_name,
			"ad_type"=>$ad_type,
			"dimension_id"=>$dimension_id,
			"campaign_id"=>$campaign_id,
			"ad_content"=>$ad_content,
			"clickurl"=>$clickurl,			
			"start_date"=>$start_date,
			"end_date"=>$end_date,
			"target_imp"=>$target_imp,
			"target_click"=>$target_click,
			"ad_status"=>$ad_status				
		);
		if(!$this->validate($adData)){
			return $this->editAd($adData,0);
		}
	}
	
	
	private function editAd($adData,$adId){
		global $messenger;
		$this->commonDataForEditAd();
		if($adData == null && $adId>0){
			// editing an ad
		}
		$messenger['data']['ad_data'] =$adData;
		return $this->views['EDIT']	;
	}
	
	private function commonDataForEditAd(){
		global $messenger;
		$data = array();
	
		if(isset($messenger['data']))
			$data = $messenger['data'];
	
		$res = $this->dimModel->listDimensions();
		$data["dimensionList"] = $res;
		
		$criteria = array();
		if(isset($messenger['advIds'])){
			$criteria['advIds'] =  $messenger['advIds'];
		}
		$res = $this->cmpModel->listCampaigns($criteria);
		
		$data["campaignList"] = $res;
		
		$data["adType"] = array("0"=>"text","1"=>"script","2"=>"image","3"=>"flash");
		
		$messenger['data'] = $data;
	}
	
	private function validate(){
		return false;
	}
}


?>