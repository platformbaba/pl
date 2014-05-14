<?php



class CampaignController extends BaseController{

	
	private $advModel ;
	private $cmpModel;
	private $views =array(
	
			"EDIT"=>"edit_campaign.php",
			"LIST"=>"list_campaign.php",
			"EDIT_CONSTRAINTS"=>"edit_campaign_constraints.php",
			"EDIT_AD_MAPPINGS"=>"edit_campaign_ad_mapping.php"
	
	);
	
	function __construct(){
		
		$this->advModel = new AdvertiserModel();
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
			$res = $this->cmpModel->listCampaigns($criteria);
			$messenger['data']['cmp_list'] = $res;
			return $this->views['LIST']	;

		}elseif ($action =='edit'){
			
			$cmpId = StringUtils::getFromRequest("id",false);
			if($cmpId){
				// this is an edit case
				$this->editCampaign(null,$cmpId);
			}else{
				// this is a new campaign case
				$this->editCampaign(null,null);
			}
			return $this->views['EDIT']	;
			
		}elseif($action == 'editc'){
			$cmpId = StringUtils::getFromRequest("id",false);
			if($cmpId){
				// this is an edit case
				$this->editCampaignConstraints(null,$cmpId);
			}else{
				// this is a new campaign case
				$this->editCampaignConstraints(null,null);
			}
			return $this->views['EDIT_CONSTRAINTS']	;
		}elseif($action == 'editam'){
			$cmpId = StringUtils::getFromRequest("id",false);
			if($cmpId){
				// this is an edit case
				$this->editAdMapping(null,$cmpId);
			}else{
				// this is a new campaign case
				$this->editAdMapping(null,null);
			}
			return $this->views['EDIT_AD_MAPPINGS']	;
		}elseif ($action == "save"){
		
			$ret =$this->saveCampaign();
			
			if($ret){
				return $ret;
			}else{
				header('Location: '.SITEPATH.'campaign');
			}
		}elseif ($action == "savec"){
		
			$cmpId = StringUtils::getFromRequest("cmp_id",false);
			if($cmpId){
				$this->saveCampaignConstraints();
				header('Location: '.SITEPATH.'campaign');
			}else{
				echo "illegal action";
				exit;
			}
			/* $ret =$this->saveCampaign();
			
			if($ret){
				return $ret;
			}else{
				header('Location: '.SITEPATH.'campaign');
			} */
			exit;
		}
	}
	
	private function commonDataForEditCampaign(){
		global $messenger;
		$data = array();
		
		if(isset($messenger['data']))
			$data = $messenger['data'];
		
		$data["countryList"] = array(
		
		);
		$data["stateList"] = array(
					
		);
		$data["cityList"] = array(
					
		);
		$criteria = array("status"=>1);
		if(isset($messenger['advIds'])){
			$criteria['advIds'] =  $messenger['advIds'];
		}
		$data["advList"] = $this->advModel->getAdvertiserNames($criteria);
		
		$messenger['data'] = $data;
	}
	
	private function editCampaignConstraints($cmpData,$cmpId){
	
		global $messenger;
		
		$data = array();
		
		if(isset($messenger['data']))
			$data = $messenger['data'];
		
		$data["countryList"] = array(	"IN"=>"India",
										"PAK"=>"Pakistan",
										"SRI"=>"Sri Lanka");
		$data["weekList"] = array(	"0"=>"Sunday",
									"1"=>"Monday",
									"2"=>"Tuesday",
									"3"=>"Wednesday",
									"4"=>"Thursday",
									"5"=>"Friday",
									"6"=>"Saturday");
		
		$data["stateList"] = array(	"MAH"=>"Maharashtra",
									"PNJ"=>"Punjab",
									"SRI"=>"Sri Lanka");
		$data["cityList"] = array("MUM"=>"Mumbai",
								  "KOL"=>"Kolkata"
		);
		
		if($cmpData==null && $cmpId>0){
			// editing a campaign
			$criteria = array("cmpId"=>$cmpId);
			if(isset($messenger['advIds'])){
				$criteria['advIds'] =  $messenger['advIds'];
			}
			$res = $this->cmpModel->getCampaignConstraints($criteria);
			if($res!=-1 && sizeof($res)>0){
				$cmpData=$res[0];
				$cmpData['week']=explode(",", $cmpData['week']);
				$cmpData['state']=explode(",", $cmpData['state']);
				$cmpData['city']=explode(",", $cmpData['city']);
				$cmpData['country']=explode(",", $cmpData['country']);
			}else{
				$cmpData = array();
			}
			$cmpData["cmp_id"] =$cmpId;
		}
		$data['cmp_data'] =$cmpData;
		$messenger['data'] = $data;
		return $this->views['EDIT_CONSTRAINTS']	;
	}
	
	private function editAdMapping($cmpData,$cmpId){
	
		global $messenger;
		$this->commonDataForEditCampaign();
		if($cmpData==null && $cmpId>0){
			// editing a campaign
			$criteria = array("cmpId"=>$cmpId);
			if(isset($messenger['advIds'])){
				$criteria['advIds'] =  $messenger['advIds'];
			}
			$res = $this->cmpModel->listCampaigns($criteria);
			if($res!=-1 && sizeof($res)>0){
				$cmpData = $res[0];
			}else{
				echo "Unauthorized access";
				exit;
			}
		}
	
		$messenger['data']['cmp_data'] =$cmpData;
		return $this->views['EDIT']	;
	}
	
	private function editCampaign($cmpData,$cmpId){
		
		global $messenger;
		$this->commonDataForEditCampaign();
		if($cmpData==null && $cmpId>0){
			// editing a campaign
			$criteria = array("cmpId"=>$cmpId);
			if(isset($messenger['advIds'])){
				$criteria['advIds'] =  $messenger['advIds'];
			}
			$res = $this->cmpModel->listCampaigns($criteria);
			if($res!=-1 && sizeof($res)>0){
				$cmpData = $res[0];
			}else{
				echo "Unauthorized access";
				exit;
			}
		}
		
		$messenger['data']['cmp_data'] =$cmpData;
		return $this->views['EDIT']	;
	}
	
	private function saveCampaign(){
		
		$cmpId = StringUtils::getFromRequest('cmp_id',false);
		$campName = StringUtils::getFromRequest('cmp_name',false);
		$advId = StringUtils::getFromRequest('advertiser_id',false);
		$cstdate = StringUtils::getFromRequest('cmp_start_date',false,date("mm/dd/Y"));
		$cendate = StringUtils::getFromRequest('cmp_end_date',false,date("mm/dd/Y",strtotime("12/12/2099")));
		$ctimp = StringUtils::getFromRequest('cmp_target_imp',false,-1);
		$ctclick = StringUtils::getFromRequest('cmp_target_click',false,-1);
		$cprior = StringUtils::getFromRequest('cmp_priority',false,1);
		$cstatus = StringUtils::getFromRequest('cmp_status',false);
		if($cstatus=='on')
			$cstatus=1;
		else 
			$cstatus=0;
		// assumpotion validaitno daone here;
		
		$cmpData = array(
			"cmp_id"=>$cmpId,	
			"cmp_name"=>$campName,
			"advertiser_id"=>$advId,
			"cmp_start_date"=>$cstdate,	
			"cmp_end_date"=>$cendate,
			"cmp_target_imp"=>$ctimp,
			"cmp_target_click"=>$ctclick,
			"cmp_priority"=>$cprior,
			"cmp_status"=>$cstatus	
		);
		if($this->validateCampaignForm($cmpData)){
			return $this->editCampaign($cmpData,null);
		}else{
			$this->cmpModel->saveCampaignDetails($cmpData);
		}
	}
	
	
	private function saveCampaignConstraints(){
		
		$cmpId = StringUtils::getFromRequest('cmp_id',false);
		$con_id = StringUtils::getFromRequest('con_id',false);
		$con_status = StringUtils::getFromRequest('con_status',false);
		$inc_exc_week = StringUtils::getFromRequest('inc_exc_week',false);
		$week = StringUtils::getFromRequest('week',false);
		$inc_exc_time = StringUtils::getFromRequest('inc_exc_time',false);
		$st_time = StringUtils::getFromRequest('st_time',false);
		$end_time = StringUtils::getFromRequest('end_time',false);
		$inc_exc_geo = StringUtils::getFromRequest('inc_exc_geo',false);
		$country = StringUtils::getFromRequest('country',false);
		$state = StringUtils::getFromRequest('state',false);
		$city = StringUtils::getFromRequest('city',false);
		
		$con_status = StringUtils::getStatusValue($con_status);
		$inc_exc_week = StringUtils::getStatusValue($inc_exc_week);
		$inc_exc_time = StringUtils::getStatusValue($inc_exc_time);
		$inc_exc_geo = StringUtils::getStatusValue($inc_exc_geo);
		$week = $week?implode (", ", $week):'';
		$country = $country?implode (", ", $country):'';
		$state = $state?implode (", ", $state):'';
		$city = $city?implode (", ", $city):'';
		$cmpData = array(
				"cmp_id"=>$cmpId,
				"con_id"=>$con_id,
				"con_status"=>$con_status,
				"inc_exc_week"=>$inc_exc_week,
				"week"=>$week,
				"inc_exc_time"=>$inc_exc_time,
				"st_time"=>$st_time,
				"end_time"=>$end_time,
				"inc_exc_geo"=>$inc_exc_geo,
				"country"=>$country,
				"state"=>$state,
				"city"=>$city,
		);
		$this->cmpModel->saveCampaignConstraints($cmpData);
	}
	
	private function saveAdMapping($cmpData,$cmpId){
		
		
	}
	
	private function validateCampaignForm($cmpData){
		global $messenger;
		$error =false;
		if(StringUtils::isEmpty($cmpData['cmp_name'])){
			$messenger['errormsg'][]="Campaign name is compulsary";
			$error =true;
		}
		if(StringUtils::isEmpty($cmpData['advertiser_id'])){
			$messenger['errormsg'][]="Advertiser name is compulsary";
			$error =true;
		}
		if(strtotime ($cmpData['cmp_start_date'])>=strtotime ($cmpData['cmp_end_date'])){
			$messenger['errormsg'][]="Start time cannot be greater than end time";
			$error =true;
		}
		return $error;
	}
}

?>