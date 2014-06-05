<?php  
/** 
 * The Editor Model
 */
class editor   
{
	public $data;
	protected $oMysqli;
	public function __construct(){
		global $oMysqli;
		$this->oMysqli=$oMysqli;
	} 
	public function addEditor($a=array()){
		$sSql="INSERT INTO editor_master (username,password,name,status,image,insertDate,email_id) VALUES ('".$this->oMysqli->secure($a['username'])."','".$this->oMysqli->secure(md5($a['password']))."','".$this->oMysqli->secure($a['name'])."','".(int)$this->oMysqli->secure($a['status'])."','".$this->oMysqli->secure($a['image'])."',now(),'".$this->oMysqli->secure($a['emailId'])."')";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	public function checkUserExist($username){
		$sWhere="";
		if((int)$_GET['id']>0){
			$sWhere=" AND id!=".(int)$_GET['id'];
		}
		$sSql="SELECT count(1) as cnt FROM editor_master WHERE username = '".$this->oMysqli->secure($username)."' AND status!='-1' $sWhere LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	public function getEditorById(array $a=array()){
		$sSql="SELECT id,username,password,name,image,status,email_id FROM editor_master WHERE id = '".$this->oMysqli->secure($a['id'])."' LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	public function updateEditor($a=array()){
		$sSql="UPDATE editor_master SET username='".$this->oMysqli->secure($a['username'])."',password='".$this->oMysqli->secure(md5($a['password']))."',name='".$this->oMysqli->secure($a['name'])."',status='".(int)$this->oMysqli->secure($a['status'])."',image='".$this->oMysqli->secure($a['image'])."',email_id='".$this->oMysqli->secure($a['emailId'])."' WHERE id='".$this->oMysqli->secure($a['id'])."' LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	/*********************************************
	* Will return All Editors as Object
	* @param: array
	********************************************/
	public function getAllEditors(array $a=array()){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY username '; $where ='';
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
		$sSql = "SELECT id,username,password,name,image,status,email_id FROM `editor_master` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($sSql);
		$aData = '';
		if( !empty($data) ){
			foreach($data as $k=>$val){
				$aData[$val->id] = $val;
			}
		}
		return $aData;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$sSql = "SELECT count(1) as cnt FROM `editor_master` WHERE status!='-1' ";
		$res = $this->oMysqli->query($sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
	
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `editor_master` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$sSql = "UPDATE `editor_master` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*
	assign role to user
	*/
	public function assignRole( array $a = array() ){
		$id=$a['user_id'];
		if($a['role_id']){
			$dSql = "DELETE FROM  `user_role` WHERE user_id='".(int)$id."'";
			$res = $this->oMysqli->query($dSql);
		
			foreach($a['role_id'] as $rId){
				$sSql="INSERT INTO user_role (user_id,role_id) VALUES ('".$this->oMysqli->secure($a['user_id'])."','".$this->oMysqli->secure($rId)."')";
				$data=$this->oMysqli->query($sSql);
			}
		}
	}
	/*
	get editors roles
	*/
	public function getUsersRolesById(array $a=array()){
		if($a){
			$sSql="SELECT role_id FROM user_role WHERE user_id = '".$this->oMysqli->secure($a['id'])."'";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	
	public function getUsersByContentPermission( array $a=array() ){
		$data = null;
		 if( $a['perm'] ){
			$sSql= "SELECT em.* 
			FROM saregama_db.permissions p, role_perm rp, user_role ur, editor_master em
			where p.perm_desc='".$a['perm']."' 
			and rp.perm_id=p.perm_id and ur.role_id=rp.role_id and em.id=ur.user_id and em.status=1";
			$data=$this->oMysqli->query($sSql);
		}
		return $data;
	}
	
}