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

class TSignupController extends TAbstractController {

    protected $usersmodel = null;
    
    public function __construct() 
    {
        parent::__construct();

        if ($this->isPostBack())
            $this->usersmodel = $this->loadmodel("Users");
    }
    
    public function run($allowedRoles = null)
    {
        $this->execute();
    }

    protected function execute() 
    {
        $data = array();

        if ($this->isPostBack()) 
        {
            $input = $this->getUserInput();
            $error = $this->checkInput($input);
            
            if (count($error) == 0) 
            {
                $activateViaEmail = $this->userMustConfirmEmail();
                
                $userid = $this->usersmodel->createNewUser($input, ($activateViaEmail) ? false : true);
                $this->setDefaultRole($userid);

                if ($activateViaEmail) 
                {
                    $this->sendConfirmationEmail($input["email"], $userid);
                    $data["email"] = $input["email"];    
                    $this->loadview("confimemail", $data);
                } 
                else 
                {
                    $this->redirect(SITE_URL);
                }

                return;
            }
            
            $data = array(
                "input"  => $input, 
                "errors" => $error
            );
        }

        $this->loadview("signup", $data);    
    }
    
    protected function setDefaultRole($userid) 
    {
        $defaultRole = $this->appsettings->valueOf("Default User Role");
 
        if ($this->utils->isNullOrEmptyString($defaultRole))
            return;
        
        $rolesModel = $this->loadmodel("Roles");
        $roleRecord = $rolesModel->getRoleByName($defaultRole);
        
        $membershipsModel = $this->loadmodel("Memberships");
        $membershipsModel->add($userid, $roleRecord["id"]);
    }
    
    protected function isPostBack() 
    {
        return ($this->post("signup") != null);
    }

    protected function getUserInput() 
    {
        $result = array();
        
        $result["username" ] = $this->post("txtusername" );        
        $result["password" ] = $this->post("txtpassword" );        
        $result["firstname"] = $this->post("firstname");        
        $result["lastname" ] = $this->post("lastname" );        
        $result["email"    ] = $this->post("email"    );        
        
        return $result;
    }
    
    protected function checkInput($input) 
    {
        $result = array();
        
        if ($this->utils->isNullOrEmptyString($input["username"]))
        {
            $result["username"] = "Missing username.";
        }
        else if ($this->utils->isValidUsername($input["username"]) == false)   
        {
            $result["username"] = "Your username can only container alphabetic, numeric, '_' or '.' charecters.";
        }
        else if ($this->usersmodel->isUsernameAlreadyInUse($input["username"])) 
        {
            $result["username"] = "Username is already taken.";
        }
            
        if ($this->utils->isNullOrEmptyString($input["password"])) 
        {
            $result["password"] = "Missing password.";
        }
        else if ($this->utils->isValidPassword($input["password"]) == false)
        {
            $result["password"] = "This password contains invalid charecters!";
        }
        else
        {
            $minpasslength = (int)$this->appsettings->valueOf("Minimum Password Length");
            $password      = $input ["password"];
            
            if (strlen($password) < $minpasslength)
                $result["password"] = "Password must be at least $minpasslength charecters long.";
        }
        
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
    
    protected function userMustConfirmEmail() 
    {
        $setting = $this->appsettings->valueOf("Require Email Activation");
        return $this->utils->stringsEqual($setting, "yes", false);
    }
    
    protected function sendConfirmationEmail($emailaddress, $userid) 
    {
        $applicatioName = $this->appsettings->valueOf("Application Name");
        $message        = $this->loadConfirmationEmailContent($userid); 
        $settings       = $this->getEmailSettings(); 

        $email = new CI_email();

        $email->initialize($settings);
        $email->from($this->appsettings->valueOf("Admin Email"), 'Site admin');
        $email->to($emailaddress);
        $email->subject("$applicatioName accout conformation");
        $email->message($message);
        $email->send();
    }
    
    protected function loadConfirmationEmailContent($userid) 
    {
        $email          = $this->loademail("SignupEmailConfirmation");
        $email->appname = $this->appsettings->valueOf("Application Name");
        $email->link    = SITE_URL . "/user/confirmaccount.php?ticket=$userid";
        return $email->get();
    }
}    

$controller = new TSignupController();
$controller->run();

?>