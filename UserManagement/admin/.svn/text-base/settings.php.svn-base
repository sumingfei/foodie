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

class TSettingsController extends TAbstractController
{
    protected $data;
    
    public function __construct()
    {
        parent::__construct();

        $this->data = array();
    }

    protected function execute()
    {

        if ($this->isSubmit())
        {
            $this->updateSettings();
        }
        else
        {
            $this->appsettings->refreshSettings();
            $settings = $this->appsettings->getAllSettings();
            $this->data["input"] = $this->utils->asNormalArray($settings); 
        }
        
        $this->loadview("admin_settings", $this->data);
    }
    
    protected function post($parameter) 
    {
        $parameter = preg_replace('/ /', '_', $parameter);
        return parent::post($parameter);
    }
    
    protected function isSubmit()
    {
        return $this->post("update");
    }
    
    protected function updateSettings()
    {
        $input  = $this->getUserInput();
        $errors = $this->checkUserInput($input);

        if (count($errors) == 0)
        {
            $settings = $this->appsettings->getAllSettings();
            $settings = $this->mergeUserInputBack($input);
            
            $this->appsettings->updateSettings($settings);
            $this->appsettings->refreshSettings();
            
            $this->data["input"] = $this->utils->asNormalArray($this->appsettings->getAllSettings());
            $this->setActionNotice("Settings just got updated");   
        }
        else
        {
            $input = $this->mergeUserInputBack($input);

            $this->data["input"       ] = $this->utils->asNormalArray($input);
            $this->data["input_errors"] = $errors;
        }
    }
    
    protected function mergeUserInputBack($input)
    {
        $settings = $this->appsettings->getAllSettings();
 
        foreach($settings as &$s)
            $s["value"] = $input[$s["name"]];
 
        return $settings;
    }
    
    protected function getUserInput()
    {
        $settings = $this->appsettings->getAllSettings();
        $result   = array();
        
        foreach($settings as $entry)    
        {
            $name = $entry["name"];
            $result[$name] = $this->post($name);
        }
        
        return $result;
    }
    
    protected function checkUserInput($input)
    {
        $errors = array();
        $v      = new TSettingsValidator($this->loadmodel("Roles"));
         
        $v->validateAppName            ($input["Application Name"        ], &$errors);
        $v->validateSessionExpireTime  ($input["Expire Session After"    ], &$errors);
        $v->validateDefaultUserRole    ($input["Default User Role"       ], &$errors);
        $v->validateMinPasswordLength  ($input["Minimum Password Length" ], &$errors);
        $v->validateRequireEmailConfirm($input["Require Email Activation"], &$errors);
        $v->validateDefaultPageSize    ($input["Default Paging Size"     ], &$errors);
        $v->validateSmtpPort           ($input["SMTP Port"               ], &$errors);
        $v->validateSmtpHost           ($input["SMTP Host"               ], &$errors);
        $v->validateSmtpUsername       ($input["SMTP Username"           ], &$errors);
        $v->validateSmtpPassword       ($input["SMTP Password"           ], &$errors);
        $v->validateAdminEmail         ($input["Admin Email"             ], &$errors);
        
        return $errors;
    }

    protected function setActionNotice($message)
    {
        $this->data["notice"] = $message;
    }
}

class TSettingsValidator 
{
    private $utils;
    private $rolesmodel;
    
    public function __construct($rolesmodel)
    {
        $this->utils = new TUtilities();
        $this->rolesmodel = $rolesmodel;
    }    

    public function validateAppName($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
            $errors["Application Name"] = "Missing value here!";
    }

    public function validateSessionExpireTime($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["Expire Session After"] = "Missing value here!";
        }
        else if (!$this->utils->isNumeric($value))
        {
            $errors["Expire Session After"] = "This value must be a number representing span of time in seconds!";
        }    
    }
    
    public function validateDefaultUserRole($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
            return;
            
        if (!$this->rolesmodel->getRoleByName($value))
            $errors["Default User Role"] = "The specified role does not exist!";
    }
    
    public function validateMinPasswordLength($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["Minimum Password Length"] = "Missing value here!";
        }
        else if (!$this->utils->isNumeric($value))
        {
            $errors["Minimum Password Length"] = "This value must be a number!";
        }    
        else if ((int)$value <= 0)
        {
            $errors["Minimum Password Length"] = "This value must be a number larger than 0!";
        }    
    }
    
    public function validateRequireEmailConfirm($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["Require Email Activation"] = "Missing value here!";
        }
        else 
        {
            $test1 = $this->utils->stringsEqual($value, "yes", false);
            $test2 = $this->utils->stringsEqual($value, "no", false);

            if (!$test1 && !$test2)
            {
                $errors["Require Email Activation"] = "This value must be a either 'yes' or 'no'!";
            }    
        }
    }

    public function validateDefaultPageSize($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["Default Paging Size"] = "Missing value here!";
        }
        else if (!$this->utils->isNumeric($value))
        {
            $errors["Default Paging Size"] = "This value must be a number!";
        }    
        else if ((int)$value <= 0)
        {
            $errors["Default Paging Size"] = "This value must be a number larger than 0!";
        }    
    }

    public function validateSmtpPort($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["SMTP Port"] = "Missing value here!";
        }
        else if (!$this->utils->isNumeric($value))
        {
            $errors["SMTP Port"] = "This value must be a number!";
        }    
        else if ((int)$value <= 0)
        {
            $errors["SMTP Port"] = "This value must be a positive and larger than 0 number!";
        }    
    }

    public function validateSmtpHost($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["SMTP Host"] = "Missing value here!";
        }
        else if (!$this->utils->isDomainName($value))
        {
            $errors["SMTP Host"] = "This value is not a valid domain address!";
        }    
    }
    
    public function validateSmtpUsername($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["SMTP Username"] = "Missing value here!";
        }
    }

    public function validateSmtpPassword($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["SMTP Password"] = "Missing value here!";
        }
    }

    public function validateAdminEmail($value, $errors)
    {
        if ($this->utils->isNullOrEmptyString($value))
        {
            $errors["Admin Email"] = "Missing value here!";
        }
        else if (!$this->utils->checkEmail($value))
        {
            $errors["Admin Email"] = "This value is not a valid email address!";
        }
    }
}

$controller = new TSettingsController();
$controller->run(array("admin"));
?>