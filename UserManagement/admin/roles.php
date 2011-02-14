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

class TRolesController extends TAbstractController
{
    protected $rolesmodel = null;

    public function __construct() 
    {
        parent::__construct();
        $this->rolesmodel = $this->loadmodel("Roles");
    }

    protected function execute()
    {
        $roles = $this->rolesmodel->getAllRolesWithStatusData();

        $data = array(
            "roles" => $roles,
        );
        
        $this->loadview("admin_roles", $data);        
    }
}

$controller = new TRolesController();
$controller->run(array("admin"));

?>