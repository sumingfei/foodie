<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

define("AUTH_OKAY"              , 0);
define("AUTH_NO_SESSION"        , 1);
define("AUTH_INSUFFICIENT_ROLES", 2);

class TAuthentication
{
    private $allowedRoles;
    private $utils;
    private $usersmodel;

    public function __construct()
    {
        $this->allowedRoles  = null;    
        $this->usersmodel    = $this->loadmodel("Users"   );
        $this->sessionsmodel = $this->loadmodel("Sessions");
        $this->utils         = new TUtilities();
    }

    private function loadmodel($modelname)
    {
        $filePath = MODELS_FOLDER . "/" . $modelname . ".model";

        if (file_exists($filePath)) 
            include_once($filePath);
        else
            TExceptions::throw_invalid_model_exception();
        
        if (class_exists($modelname, true)) 
            return new $modelname();
    }
    
    public function validateSession($allowedRoles = null)
    {
        $result            = new stdClass();
        $result->auth_code = AUTH_OKAY;
        $result->roles     = array();

        $this->allowedRoles = $allowedRoles;
        $sessionrec         = $this->getSessionRecord();

        if (!$sessionrec)
        {
            $result->auth_code = AUTH_NO_SESSION;
            return $result;
        }
        
        $user            = $this->usersmodel->getById($sessionrec["userid"]); 
        $result->account = $user;
        $result->roles   = $user["roles"];

        if (!$this->checkRoles($result->roles))
        {
            $result->auth_code = AUTH_INSUFFICIENT_ROLES;
            return $result;
        }
        
        return $result;    
    }

    public function getCurrentSessionId()
    {
        if (isset($_SESSION['SESSIONID']))
        {
            $id = $_SESSION['SESSIONID'];
            return $this->utils->xss_clean($id);
        }
        return "";    
    }
    
    private function getSessionRecord()
    {
        $sessionid = $this->getCurrentSessionId();
        if ($this->utils->isNullOrEmptyString($sessionid))
            return null;
        
        $sessionrec = $this->sessionsmodel->getSessionRecord($sessionid);
        return ($sessionrec && $sessionrec["expired"] == 0) ? $sessionrec : null;
    }
    
    private function checkRoles($userRoles)
    {
        if ($this->allowedRoles == null) 
            return true;

        foreach($this->allowedRoles as $allowedRole)
        {
            foreach($userRoles as $userRole)
            {
                if ($this->utils->stringsEqual($allowedRole, $userRole["name"], false))
                    return true;
            }        
        }
        
        return false;
    }
}
?>