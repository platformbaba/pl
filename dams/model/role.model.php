<?php
/* editors role */
class Role
{
    public $permissions;
 	protected $oMysqli;
    public function __construct() {
        $this->permissions = array();
		global $oMysqli;
		$this->oMysqli=$oMysqli;
    }
    // return a role object with associated permissions
    public static function getRolePerms($role_id) {
        global $oMysqli;
		$role = new Role();
        $sSql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = ".$role_id;
		$data=$oMysqli->query($sSql);
		if($data){
			foreach($data as $row){
					$role->permissions[$row->perm_desc] = true;
			}
		}
        return $role;
    }
    // check if a permission is set
    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
	
	// insert a new role
	public function addRole(array $a=array()) {
		if($a){
			$role_name=$a['roleName'];
			$status=$a['status'];
			$sSql = "INSERT INTO roles (role_name,insertDate,status) VALUES ('".$this->oMysqli->secure($role_name)."',now(),'".$status."')";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	// edit a role
	public function editRole(array $a=array()) {
		if($a){
			$role_name=$a['roleName'];
			$status=$a['status'];
			$roleId=$a['id'];
			$sSql = "UPDATE roles SET role_name='".$this->oMysqli->secure($role_name)."',status='".$status."' WHERE role_id='".$roleId."' LIMIT 1";
			$data=$this->oMysqli->query($sSql);
			return $data;
		}
	}
	public function getRoleById(array $a=array()){
		$sSql="SELECT role_id,role_name,status FROM roles WHERE role_id = '".$this->oMysqli->secure($a['id'])."' LIMIT 1";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	public function getAllRoles(array $a=array()){
		$limit = MAX_DISPLAY_COUNT; $start =0; $orderby = ' ORDER BY insertDate DESC '; $where ='';
		if( isset($a['limit']) && $a['limit'] != '' ){
			$limit = (int)$a['limit'];
		}
		if( isset($a['orderby']) && $a['orderby'] != '' ){
			$orderby = $a['orderby'];
		}
		if( isset($a['start']) && $a['start'] != '' ){
			$start = (int)$a['start'];
		}
		if( isset($a['where']) && $a['where'] != '' ){
			$where = $a['where'];
		}
		$sSql = "SELECT role_id,role_name,status FROM `roles` WHERE status!='-1' $where $orderby LIMIT $start, $limit";
		$data=$this->oMysqli->query($sSql);
		return $data;
	}
	/*********************************************
	* Will return total result count
	* @param: array
	********************************************/
	function getTotalCount( array $a = array() ){
		$sSql = "SELECT count(1) as cnt FROM `roles` WHERE status!='-1' ";
		$res = $this->oMysqli->query($sSql);
		if($res[0]){
			return $res[0]->cnt;
		}else{
			return 0;	
		}
	}
		/*********************************************
	* Will DELETE/Publish/Draft given records
	* @Param: array()
	**********************************************/
	public function doAction( array $a = array() ){
		$sSql = "UPDATE `roles` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND role_id='".(int)$a['contentId']."' LIMIT 1";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will DELETE/Publish/Draft Multiple given records
	* @Param: array()
	**********************************************/
	public function doMultiAction( array $a = array() ){
		$limit = count($a['contentIds']);
		$sSql = "UPDATE `roles` SET `status`='".(int)$a['contentActionValue']."' WHERE status!='-1' AND role_id IN(".implode(',', $a['contentIds']).") LIMIT $limit";
		$res = $this->oMysqli->query($sSql);
	}
	/*********************************************
	* Will return all permissions
	* @param: array
	********************************************/
	public function getAllPermissions( array $a = array() ){
		$orderBy=" ORDER BY perm_desc ASC";
		$sSql = "SELECT * FROM `permissions`".$orderBy;
		$data = $this->oMysqli->query($sSql);
		return $data;
	}
	/*********************************************
	* Will insert all permissions by role
	* @param: array
	********************************************/
	public function insertRolePermissions( array $a = array() ){
		if($a){
			$roleId=$a['roleId'];
			if($roleId){
				$iSql="DELETE FROM role_perm WHERE role_id=".$this->oMysqli->secure($roleId);
				$idata = $this->oMysqli->query($iSql);
			}
			$permArr=$a['permArr'];
			if($permArr){
				foreach($permArr as $permId){			
					$sSql = "INSERT INTO role_perm (role_id,perm_id) VALUES('".$this->oMysqli->secure($roleId)."','".$this->oMysqli->secure($permId)."')";
					$data = $this->oMysqli->query($sSql);
				}
			}			
			return $data;
		}
	}
}
?>