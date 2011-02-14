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

class TModifyRoleController extends TAbstractController
{
    protected $data;
    protected $rolesmodel;
    protected $membershipsmodel;

    public function __construct()
    {
        parent::__construct();

        $this->data = array();
        $this->rolesmodel = $this->loadmodel("Roles");
        $this->membershipsmodel = $this->loadmodel("Memberships");
    }

    protected function execute()
    {
        $action = $this->getUserAction();
        $this->executeAction($action);        
    }

    protected function executeAction($action)
    {
        $rolerecord = $this->getRequestedRole();
        if (!$rolerecord)
        {
            $this->data["error"] = "Could not file role.";
        }
        else
        {
            switch($action)    
            {
                case "update":
                    $this->updateRole();
                break;
    
                case "remove members":
                    $this->removeMembers($rolerecord);
                break;
    
                case "remove":
                    if ($this->removeRole())
                    {
                        $this->redirect();
                        return;
                    }
                break;
    
                default:
                    $rolerecord = $this->getRequestedRole();
                    
                    if ($rolerecord)
                    {
                        $this->data["role"        ] = $rolerecord;                                    
                        $this->data["input"       ] = $rolerecord;
                        $this->data["memberscount"] = $this->getRoleMembersCount($rolerecord["id"]);
                    }
                    else
                    {
                        $this->data["error"] = "Could not file role.";
                    }
                    
                break;
            }
        }
        
        $this->loadview("admin_modifyrole", $this->data);
    }
    
    protected function getRoleMembersCount($id)
    {
        return $this->membershipsmodel->getRoleMembersCount($id);
    }
    
    protected function removeMembers($rolerecord)
    {
        $this->membershipsmodel->removeRoleMembers($rolerecord["id"]);
        $this->data["memberscount"] = $this->getRoleMembersCount($rolerecord["id"]);
        $this->data["role"        ] = $rolerecord;
        $this->data["input"       ] = $rolerecord;

        $this->setActionNotice("Members of this role were unenrolled.");
    }

    protected function updateRole()
    {
        $input   = $this->getUserInput();
        $errors  = $this->checkInput($input);
        $roleid  = $this->get("roleid");
        
        $this->data["memberscount"] = $this->getRoleMembersCount($roleid);

        if (count($errors) == 0)
        {
            $this->rolesmodel->updateRole($roleid, $input);
            
            $rolerecord = $this->getRequestedRole();
            
            $this->data["input"] = $rolerecord;
            $this->data["role" ] = $rolerecord;
            $this->data["memberscount"] = $this->getRoleMembersCount($rolerecord["id"]);
            
            $this->setActionNotice("Role was just updated.");
        } 
        else
        {
            $this->data["role"        ] = $this->getRequestedRole();
            $this->data["input_errors"] = $errors;
            $this->data["input"       ] = $input;
        }        
    }
    
    protected function removeRole()
    {
        $role = $this->getRequestedRole();

        if ($role)
        {
            $memberCount = $this->membershipsmodel->getRoleMembersCount($role["id"]);
            
            if ($memberCount > 0)
            {
                $this->data["error"] = "This role has $memberCount member(s). You must remove the members first.";
                return;
            }
            
            $this->rolesmodel->remove($role["id"]);
            return true;
        }
        
        return false;
    }

    protected function getUserAction()
    {
        $action = $this->post("action");
        return ($action) ? strtolower($action) : $action;
    }
    
    protected function getRequestedRole()
    {
        $roleid = $this->get("roleid");

        if (!$roleid || !$this->utils->isNumeric($roleid))
            return null;
            
        return $this->rolesmodel->getRoleById($roleid);
    }

    public function getUserInput()
    {
        $result = array(
            "name"        => $this->post("name"),        
            "description" => $this->post("description")        
        );
        
        return $result;
    }

    public function checkInput($input)
    {
        $result = array();
        
        if ($this->utils->isNullOrEmptyString($input["name"]))
        {
            $result["name"] = "Role name is missing.";
        }
        else
        {
            $role = $this->getRequestedRole();
            $namesAreTheSame = $this->utils->stringsEqual($role["name"], $input["name"], false);
            if (!$namesAreTheSame && $this->rolesmodel->willDuplicate($input["name"])) 
            {
                $result["name"] = "Role '" . $input["name"] . "' is already in use.";        
            }
        }
            
        if ($this->utils->isNullOrEmptyString($input["description"]))
            $result["description"] = "Role description is missing.";

        return $result;
    }

    protected function redirect()
    {
        header("Location: ". SITE_URL . "/admin/roles.php");
    }

    protected function setActionNotice($message)
    {
        $this->data["notice"] = $message;
    }
}

$controller = new TModifyRoleController();
$controller->run(array("admin"));
?>