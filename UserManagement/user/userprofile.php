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

class TUserProfileController extends TAbstractController
{
    protected $data;
    protected $usersmodel;
    
    public function __construct()
    {
        parent::__construct();
        $this->data = array();
        $this->usersmodel = $this->loadmodel("Users");
    }

    protected function execute()
    {
        $account = $this->auth_result->account;
        $this->data = array(
            "account" => $account,
            "input"   => $account
        );
        
        if ($this->getUserAction())
        {
            $this->updateAccount();
        }
        
        $this->loadview("user_profile", $this->data);
    }
    
    protected function updateAccount()
    {
        $input  = $this->getUserInput();
        $errors = $this->checkUserInput($input);
        $userid = $this->auth_result->account["id"];
        
        if (count($errors) == 0) 
        {

            $this->usersmodel->updateUserRecord($userid, $input);
            $this->data["input"] = $this->usersmodel->getById($userid);

            $this->setActionNotice("Account was updated.");
        } 
        else
        {
            $this->data["input_error"] = $errors;
            $this->data["input"      ] = $this->usersmodel->getById($userid);
        }
    }
    
    protected function getUserAction()
    {
        if ($this->post("update"))
            return "update";
        return null;
    }
    
    protected function getUserInput()
    {
        return array(
            "email"     => $this->post("email"),
            "firstname" => $this->post("firstname"),
            "lastname"  => $this->post("lastname")
        );
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

$controller = new TUserProfileController();
$controller->run();
?> 