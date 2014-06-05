<?php
class privilegeduser
{
    private $roles;
 
    /*public function __construct() {
        parent::__construct();
    }*/
    // override User method
	public static function getEditorById(array $a=array()){
		global $oMysqli;
		$sSql="SELECT id,username,password,name,image,status FROM editor_master WHERE id = '".$oMysqli->secure($a['id'])."' LIMIT 1";
		$data=$oMysqli->query($sSql);
		if (!empty($data)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $data[0]->id;
            $privUser->username = $data[0]->username;
            $privUser->password = $data[0]->password;
            $privUser->name = $data[0]->name;
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
	}
	
    // populate roles with their associated permissions
    protected function initRoles() {
		global $oMysqli;
        $this->roles = array();
        $sSql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id	
                WHERE t1.user_id =".$this->user_id;
		$data=$oMysqli->query($sSql);
		foreach($data as $row){
			$this->roles[$row->role_name] = Role::getRolePerms($row->role_id);
		}		
    }
 
    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}
?>