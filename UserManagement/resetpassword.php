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

class TResetPasswordController extends TAbstractController
{
    public function run()
    {
        $this->execute();
    }
    
    protected function execute()
    {
        $data = array();
        
        if ($this->getUserAction())
        {

            $username = $this->post("username");
            $model    = $this->loadmodel("Users");
            $user     = $model->getByUsername($username);
            
            if ($user)
            {
                $newpassword = $this->utils->randomPassword();
                $model->changeUserPassword($user["id"], $newpassword);
                $this->sendEmail($user, $newpassword);                
                
                $data["password_was_reset"] = true;
            }
            else
            {
                $data["error"] = "No account could be found with the username you provided!";            
            }
        }
        
        $this->loadview("resetpassword", $data);
    }
    
    protected function getUserAction()
    {
        return $this->post("resetpassword");
    }
    
    protected function sendEmail($user, $newPassword)
    {
        $applicationName = $this->appsettings->valueOf("Application Name");
        $message         = $this->getResetPasswordEmailContent($user, $newPassword); 
        $settings        = $this->getEmailSettings(); 

        $email = new CI_email();

        $email->initialize($settings);
        $email->from($this->appsettings->valueOf("Admin Email"), 'Site admin');
        $email->to($user["email"]);
        $email->subject("Your $applicationName password was reset");
        $email->message($message);
        $email->send();
    }
    
    protected function getResetPasswordEmailContent($user, $newpassword)
    {
        $email              = $this->loademail("PasswordReset");
        $email->appname     = $this->appsettings->valueOf("Application Name");
        $email->newpassword = $newpassword;
        $email->username    = $user["username"];

        return $email->get();
    }
}

$controller = new TResetPasswordController();
$controller->run();
?>