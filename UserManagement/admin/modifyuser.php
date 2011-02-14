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

class TModifyUser extends TAbstractController {

    protected $membershipsmodel;
    protected $userid;
    protected $account;
    protected $data;
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->usersmodel       = $this->loadmodel("Users"      );
        $this->membershipsmodel = $this->loadmodel("Memberships");
        $this->data             = array();
    }    

    protected function execute() 
    {
        $error  = $this->checkRequest();
        $action = $this->getUserAaction();        

        $this->data["account"       ] = $this->account;
        $this->data["input"         ] = $this->account;
        $this->data["possible_roles"] = $this->loadmodel("Roles")->getAllRoles(false);

        if ($error)
        {
            $this->onError($error);
        }    
        else 
        {
            $this->executeAction($action);           
        }
    }
    
    protected function onError($error)
    {
        $this->data["error"] = $error;        
        $this->loadview("admin_modifyuser", $this->data);
    }

    protected function executeAction($action) 
    {
        switch ($action) 
        {
            case "update": $this->updateAccount();
            break;

            case "addrole": $this->addRole();
            break;

            case "droprole": $this->dropRole();
            break;

            case "disable": $this->disable();
            break;

            case "enable": $this->enable();
            break;
            
            case "resetpassword": $this->resetPassword();
            break;

            case "remove": 
                $this->remove();
                $this->redirect(SITE_URL . "/admin/memberships.php");
                return;
            break;

            default:
                $this->data["input"] = $this->account;
            break;
        }    

        $this->loadview("admin_modifyuser", $this->data);
    }
    
    protected function getUserId() 
    {
        return $this->get("userid");
    }
    
    protected function getUserAaction()
    {
        if ($this->post("update"       )) return "update";
        if ($this->post("addrole"      )) return "addrole";
        if ($this->post("droprole"     )) return "droprole";
        if ($this->post("disable"      )) return "disable";
        if ($this->post("enable"       )) return "enable";
        if ($this->post("remove"       )) return "remove";
        if ($this->post("resetpassword")) return "resetpassword";

        return null;    
    }
    
    protected function checkRequest()
    {
        $this->userid = $this->getUserId();

        if (!$this->userid || !$this->utils->isNumeric($this->userid)) 
            return "No user was specified.";

        $this->account = $this->usersmodel->getById($this->userid);
        if (!$this->account)
            return "Could not locate user.";
        
        return null;
    }
    
    protected function updateAccount()
    {
        $input  = $this->getUserInput();
        $errors = $this->checkUserInput($input);
        
        if (count($errors) == 0) 
        {
            $this->usersmodel->updateUserRecord($this->account["id"], $input);
            $this->data["input"] = $this->usersmodel->getById($this->userid);

            $this->setActionNotice("Account was updated.");
        } 
        else
        {
            $this->data["input_error"] = $errors;
            $this->data["input"      ] = $this->usersmodel->getById($this->userid);
        }
    }
    
    protected function addRole()
    {
        $rolename   = $this->post("addrole");
        $rolerecord = $this->loadmodel("Roles")->getRoleByName($rolename);
        
        if (!$rolerecord)
        {
            $this->data["error"] = "Referenced role does not exist.";
        } 
        else
        {   
            $model = $this->loadmodel("Memberships");
            if (!$model->willDuplicate($this->account["id"], $rolerecord["id"]))
            {
                $this->loadmodel("Memberships")->add($this->account["id"], $rolerecord["id"]);
                $this->account = $this->usersmodel->getById($this->userid);
    
                $this->data["account"] = $this->account;
                $this->data["input"  ] = $this->account;

                $this->setActionNotice("Role '". $rolename ."' was added to this account.");
            }
        }
    }
    
    protected function dropRole()
    {
        $rolename   = $this->post("droprole");
        $rolerecord = $this->loadmodel("Roles")->getRoleByName($rolename);

        if (!$rolerecord)
        {
            $this->data["error"] = "Referenced role does not exist.";
        } 
        else
        {   
            $this->loadmodel("Memberships")->remove($this->account["id"], $rolerecord["id"]);
            $this->account = $this->usersmodel->getById($this->userid);

            $this->data["account"] = $this->account;
            $this->data["input"  ] = $this->account;
            
            $this->setActionNotice("Role '". $rolename ."' was removed from this account.");
        }
    }
    
    protected function disable()
    {
        $this->usersmodel->disableUser($this->account["id"], true);
        $this->account = $this->usersmodel->getById($this->account["id"]);
        $this->data["account"] = $this->account;

        $this->setActionNotice("The account for '". $this->account["username"] ."' is set disabled.");
    }

    protected function enable()
    {
        $this->usersmodel->enableUser($this->account["id"], true);
        $this->account = $this->usersmodel->getById($this->account["id"]);
        $this->data["account"] = $this->account;
        
        $this->setActionNotice("The account for '". $this->account["username"] ."' is set enabled.");
    }
    
    protected function remove()
    {
        $this->membershipsmodel->removeMemberRoles($this->account["id"]);
        $this->usersmodel->removeUser($this->account["id"]);
    }

    protected function resetPassword()
    {
        $newPassword = $this->utils->randomPassword();
        $this->usersmodel->changePassword($this->account["id"], $newPassword);
        $this->setActionNotice("The password for '". $this->account["username"] ."' was reset.");

        $applicationName = $this->appsettings->valueOf("Application Name");
        $message         = $this->getResetPasswordEmailContent($newPassword); 
        $settings        = $this->getEmailSettings(); 

        $email = new CI_email();

        $email->initialize($settings);
        $email->from($this->appsettings->valueOf("Admin Email"), 'Site admin');
        $email->to($this->account["email"]);
        $email->subject("Your $applicationName password was reset");
        $email->message($message);
        $email->send();
    }
    
    protected function getResetPasswordEmailContent($newpassword)
    {
        $email              = $this->loademail("PasswordReset");
        $email->appname     = $this->appsettings->valueOf("Application Name");
        $email->newpassword = $newpassword;
        $email->username    = $this->account["username"];

        return $email->get();
    }

    protected function getUserInput() 
    {
        $result = array();

        $result["email"    ] = $this->post("email"    );        
        $result["firstname"] = $this->post("firstname");        
        $result["lastname" ] = $this->post("lastname" );        
        
        return $result;
    }
    
    protected function checkUserInput($input)
    {
        $result = array();
        
        if ($this->utils->isNullOrEmptyString($input["firstname"])) 
            $result["firstname"] = "Missing first name.";

        if ($this->utils->isNullOrEmptyString($input["lastname"])) 
            $result["lastname"] = "Missing last name.";
            
        if ($this->utils->isNullOrEmptyString($input["email"])) 
            $result["email"] = "Missing email address.";

        if ($this->utils->checkEmail($input["email"]) == false) 
            $result["email"] = "Invalid email address.";    

        return $result;    
    }
    
    protected function setActionNotice($message)
    {
        $this->data["notice"] = $message;
    }
}

$controller = new TModifyUser();
$controller->run();

?>