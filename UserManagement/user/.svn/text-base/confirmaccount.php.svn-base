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

class TConfirmAccountController extends TAbstractController
{
    protected $usersmodel;

    public function __construct()
    {
        parent::__construct();
        $this->usersmodel = $this->loadmodel("Users");
    }

    public function run($allowedRoles = null)
    {
        $this->execute();
    }
    
    protected function execute()
    {
        $data    = array();
        $account = $this->getUserAccount();
        
        if ($account)
        {
            if ($account["admin_disabled"] == 1)
            {
                $data["error"] = "This account has been locked by the admin! Please contact the site admin!";
            }
            else
            {
                $this->usersmodel->enableUser($account["id"]);
                $this->usersmodel->userConfirmedEmail($account["id"]);
                $data["account"] = $account;
            }
        }
        else
        {
            $data["error"] = "Could not identify the account from the request!";
        }
        
        $this->loadview("user_confirmaccount", $data);
    }
    
    protected function getUserId()
    {
        return $this->get("ticket");
    }
    
    protected function getUserAccount()
    {
        $id = $this->getUserId();
        return ($id) ? $this->usersmodel->getById($id) : null;
    }
}

$controller = new TConfirmAccountController();
$controller->run();
?>