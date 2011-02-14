<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

include_once("includes.php");

class TSigninController extends TAbstractController {

    public function run($allowedRoles = null)
    {
        $this->allowedRoles = $allowedRoles;
        $this->execute();
    }

    protected function execute() 
    {
        $this->auth_result = parent::validateSession(null);

        if ($this->auth_result->auth_code == AUTH_OKAY)
        {
            $this->goToAfterSignInPage($this->auth_result->roles);
        }
        /*else if (!$this->getUserAction())
        {
            $this->loadview("signin");
        }*/
        else
        {
            $this->signin();        
        }
    }
    
    protected function signin()
    {
        $input   = $this->getUserInput();
        $model   = $this->loadmodel("Users");
        $account = $model->getUser($input["username"], $input["password"]);
        
        if ($account == null || sizeof($account) == 0) 
        {
            $data = array("error" => "Could not sign you in");
            $this->loadview("signin", $data);
            return;
        } 
        
        if ($account["disabled"] == 1 || $account["admin_disabled"] == 1) 
        {
            $data = array("error" => ($account["admin_disabled"] == 0) ? "This account is disabled." : "This account is been locked by the admin. Please contact the site admin!");
            $this->loadview("signin", $data);
            return;
        } 
        
        $this->createNewSession($account);
        $this->goToAfterSignInPage($account["roles"]);
    }
    
    protected function createNewSession($account) {
        $model     = $this->loadmodel("Sessions");
        $sessionid = crypt($account["username"] . date('now'));
        
        $_SESSION['SESSIONID'] = $sessionid;
        $model->createNewSession($sessionid, $account["id"]);
    }

    public function goToAfterSignInPage($roles)
    {
        foreach($roles as $role)
        {
            if ($this->utils->stringsEqual($role["name"], "admin", false))
            {
                $this->redirect(SITE_URL . "/admin/dashboard.php");
                return;
            }
        }
        
        $this->redirect(SITE_URL . "/user/userprofile.php");
    }

    protected function getUserAction()
    {
        if ($this->post("signin"))
            return "signin";
        else     
            return null;            
    }
    
    protected function getUserInput()
    {
        return array(
            "username" => $this->post("username"),
            "password" => $this->post("password")
        );
    }
}

$controller = new TSigninController();
$controller->run();

?>