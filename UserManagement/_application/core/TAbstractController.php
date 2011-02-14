<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

class TAbstractController 
{
    protected $utils;
    protected $allowedRoles;
    protected $authentication;
    protected $auth_result;
    protected $appsettings;

    public function __construct() 
    {
        $this->authentication = new TAuthentication();
        $this->utils          = new TUtilities();
        $this->appsettings    = $this->loadmodel("Settings");
    }
    
    public function run($allowedRoles = null)
    {
        $this->auth_result = $this->validateSession($allowedRoles);
        
        switch ($this->auth_result->auth_code)
        {
            case AUTH_NO_SESSION:
                $this->handleNoSession();                 
            break;
        
            case AUTH_INSUFFICIENT_ROLES:
                $this->handleInSufficientRole();
            break;
        
            case AUTH_OKAY:
                $this->execute();
            break;
        }
    }
    
    protected function execute() 
    {
    }
    
    protected function validateSession($allowedRoles)
    {
        return $this->authentication->validateSession($allowedRoles);
    }

    protected function handleNoSession()
    {
        $this->redirect(SITE_URL);
    }
    
    protected function handleInSufficientRole()
    {
        $data = array("message" => "Your account has insufficient access!");
        $this->loadview("error", $data);       
    }
    
    protected function get($parameter) 
    {
        if(isset($_GET[$parameter]))
        {
            $value = (get_magic_quotes_gpc()) ? $_GET[$parameter] : addslashes($_GET[$parameter]); 
            return $this->utils->xss_clean($value);
        }   
        else 
            return null; 
    }

    protected function post($parameter) 
    {
        if(isset($_POST[$parameter]))
        {
            $value = (get_magic_quotes_gpc()) ? $_POST[$parameter] : addslashes($_POST[$parameter]); 
            return $this->utils->xss_clean($value);
        }
        else 
            return null; 
    }
    
    protected function printPostVariables() 
    {
        print_r($_POST);
    }

    protected function printGetVariables() 
    {
        print_r($_GET);
    }

    protected function loadview($viewname, $data = null)
    {
        $filePath = VIEWS_FOLDER . "/" . $viewname . ".view";
        
        if (file_exists($filePath)) 
            include_once($filePath);
        else
            TExceptions::throw_invalid_view_exception();
    }    
    
    protected function loadmodel($modelname)
    {
        $filePath = MODELS_FOLDER . "/" . $modelname . ".model";

        if (file_exists($filePath)) 
            include_once($filePath);
        else
            TExceptions::throw_invalid_model_exception();
        
        if (class_exists($modelname, true)) 
            return new $modelname();
    }
    
    protected function loademail($emailname)
    {
        $filePath = EMAILS_FOLDER . "/" . $emailname . ".email";

        if (file_exists($filePath)) 
            include_once($filePath);
        else
            TExceptions::throw_invalid_model_exception();
        
        if (class_exists($emailname, true)) 
            return new $emailname();
    }
    
    protected function redirect($location)
    {
        header("Location: $location");
    }
    
    protected function getEmailSettings()
    {
        return array(
            "smtp_host" => $this->appsettings->valueOf("SMTP Host"       ),
            "smtp_user" => $this->appsettings->valueOf("SMTP Username"   ),
            "smtp_pass" => $this->appsettings->valueOf("SMTP Password"   ),
            "smtp_port" => $this->appsettings->valueOf("SMTP Port"       ),
            "useragent" => $this->appsettings->valueOf("Application Name"),
            "mailtype"  => "text"
        );
    }
}

?>