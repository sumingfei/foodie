<?php 
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

include_once("../includes.php");

class TDashboard extends TAbstractController {

    protected $rolesmodel = null;
    protected $usermodel  = null;

    public function __construct() 
    {
        parent::__construct();
        $this->rolesmodel    = $this->loadmodel("Roles"   );
        $this->usermodel     = $this->loadmodel("Users"   );
    }

    protected function execute() 
    {
        $recentusers = $this->usermodel->getAllUsers(0, 5, "registered_on", "DESC");
        $roles       = $this->rolesmodel->getAllRolesWithStatusData();
        $sessions    = $this->loadmodel("Sessions")->getActiveSessions(0, 5);

        $data = array(
            "recentusers" => $recentusers, 
            "roles"       => $roles,
            "sessions"    => $sessions
        );
        
        $this->loadview("admin_dashboard", $data);        
    }
    
}    

$controller = new TDashboard();
$controller->run(array('admin'));

?>