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

class TAddRoleController extends TAbstractController 
{
    protected $rolesmodel;
    
    public function __construct()
    {
        parent::__construct();
        $this->rolesmodel = $this->loadmodel("Roles");
    }
    
    protected function execute()
    {
        $data   = array();
        $action = $this->getAction();
        
        if (strcmp($action, "create") == 0)
        {
            $input       = $this->getUserInput();
            $inputErrors = $this->checkInput($input);

            if (count($inputErrors) != 0)
            {
                $data["input"      ] = $input;           
                $data["input_error"] = $inputErrors;
            }
            else
            {
                $this->rolesmodel->add($input);
                $this->redirect();
                return;
            }
        }

        $this->loadview("admin_addrole", $data);    
    }
    
    public function getAction()
    {
        if ($this->post("create"))
            return "create";

        return null;
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
        else if ($this->rolesmodel->willDuplicate($input["name"]))
        {
            $result["name"] = "Role " . $input["name"] . " is already in use.";
        }
            
        if ($this->utils->isNullOrEmptyString($input["description"]))
            $result["description"] = "Role description is missing.";

        return $result;
    }
    
    public function redirect()
    {
        header("Location: " . SITE_URL . "/admin/roles.php");
    }
}

$controller = new TAddRoleController();
$controller->run(array("admin"));
?>