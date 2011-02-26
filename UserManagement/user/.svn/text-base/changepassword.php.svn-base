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

class TChangePasswordController extends TAbstractController
{
    protected $data;

    public function __construct()
    {
        parent::__construct();    
        $this->data = array();
    }
    
    protected function execute()
    {
        if ($this->getUserAction())
        {
            $this->changePassword();
        }

        $this->loadview("user_changepassword", $this->data);
    }
    
    protected function getUserAction()
    {
        if ($this->post("changepassword"))
            return "changepassword";
        return null;
    }
    
    protected function getUserInput()
    {
        return array(
            "currentpassword" => $this->post("currentpassword"),
            "newpassword"     => $this->post("newpassword"    ),
            "confirmpassword" => $this->post("confirmpassword")
        );
    }
    
    protected function checkUserInput($input)
    {
        $result = array();

        $account = $this->auth_result->account;
        
        if ($this->utils->isNullOrEmptyString($input["currentpassword"]))
        {
            $result["currentpassword"] = "You must provide current password for the account!";
        }
        else if ($this->utils->stringsEqual(md5($input["currentpassword"]), $account["password"]) == false)
        {
            $result["currentpassword"] = "Provided current password didn't match account's current password!";
        }
        
        if ($this->utils->isNullOrEmptyString($input["newpassword"]))
        {
            $result["newpassword"] = "You must provide a new password";
        }
        else
        {
            $minpasslength = $this->appsettings->valueOf("Minimum Password Length");
            
            if (strlen($input["newpassword"]) < $minpasslength)
                $result["newpassword"] = "New password must be at least $minpasslength charecters long!";
        }
        
        if ($this->utils->isNullOrEmptyString($input["confirmpassword"]))
        {
            $result["confirmpassword"] = "You did not confirm the new password!";
        }
        else if ($this->utils->stringsEqual($input["confirmpassword"], $input["newpassword"]) == false)
        {
            $result["confirmpassword"] = "New password and confirmation password did not match!";
        }
        
        return $result;
    }
    
    protected function changePassword()
    {
        $input  = $this->getUserInput();
        $errors = $this->checkUserInput($input);
        
        if (count($errors) == 0)
        {
            $model = $this->loadmodel("Users");
            $model->changeUserPassword($this->auth_result->account["id"], $input["newpassword"]);
            $this->setActionNotice("Account password was changed!");
        }
        else
        {
            $this->data["input_error"] = $errors;        
        }
    }

    protected function setActionNotice($message)
    {
        $this->data["notice"] = $message;
    }
}

$controller = new TChangePasswordController();
$controller->run();
?>