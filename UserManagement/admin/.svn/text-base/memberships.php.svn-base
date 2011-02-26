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

class TMembershipsController extends TAbstractController 
{
    protected $totalUsers    = 0;
    protected $requestedPage = 0;
    protected $users         = null;

    protected function execute() 
    {
        $usersmodel          = $this->loadmodel("Users");
        $this->requestedPage = $this->getRequestedPageNumber();
        
        $pageSize     = $this->getRequestedPageSize();
        $recordOffset = $this->getRecordOffset();
        
        $this->users      = $usersmodel->getAllUsers($recordOffset, $pageSize, "username");
        $this->totalUsers = $usersmodel->count();

        $data = array(
            "users"  => $this->users,
            "paging" => $this->getPagingData()
        );
        
        $this->loadview("admin_memberships", $data);
    }
    
    protected function getRecordOffset()
    {
        return ($this->requestedPage - 1) * $this->getRequestedPageSize();
    }
    
    protected function getPagingData() 
    {
        $pagesize     = $this->getRequestedPageSize();
        $totalrecords = $this->totalUsers;
        $offset       = $this->requestedPage;

        $paging = new TPagination();
        return $paging->calculate_pages($totalrecords, $pagesize, $offset);
    }
    
    protected function getRequestedPageNumber() {
        $result = (int)$this->get("page");
        if (!$result)
            $result = 1;
        return $result;
    }

    protected function getRequestedPageSize() {
        $result = (int)$this->get("pagesize");
        if (!$result)
            $result = $this->appsettings->valueOf("Default Paging Size");
        return $result;
    }
}

$controller = new TMembershipsController();
$controller->run(array("admin"));

?>