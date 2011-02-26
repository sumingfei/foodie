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

class TSessionsController extends TAbstractController
{
    protected $data;
    protected $sessionsmodel;
    protected $requestedPage;

    public function __construct()
    {
        parent::__construct();

        $this->data          = array();
        $this->sessionsmodel = $this->loadmodel("Sessions");
    }

    protected function execute()
    {
        $this->requestedPage = $this->getRequestedPageNumber();
        $pageSize            = $this->getRequestedPageSize();
        $recordOffset        = $this->getRecordOffset();
        $activeSessions      = $this->sessionsmodel->getActiveSessions($recordOffset, $pageSize);
        
        $this->data["sessions"] = $activeSessions;
        $this->data["paging"  ] = $this->getPagingData();
        
        $this->loadview("admin_sessions", $this->data);
    }
    
    protected function getRecordOffset()
    {
        return ($this->requestedPage - 1) * $this->getRequestedPageSize();
    }
    
    protected function getPagingData() 
    {
        $pagesize     = $this->getRequestedPageSize();
        $totalrecords = $this->sessionsmodel->getActiveSessionsCount();
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

$controller = new TSessionsController();
$controller->run(array("admin"));
?>