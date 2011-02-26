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

class TSearchController extends TAbstractController
{
    protected $data;
    protected $searchterm;
    protected $usersmodel;
    protected $requestedPage;
    protected $searchResult;
    
    public function __construct()
    {
        parent::__construct();
        $this->data = array();
        $this->usersmodel = $this->loadmodel("Users");
    }
    
    protected function execute()
    {
        $this->searchterm = $this->get("q");

        if ($this->utils->isNullOrEmptyString($this->searchterm))
        {
            $this->data["error"] = "No valid search term was provided.";        
        }
        else
        {
            $this->requestedPage = $this->getRequestedPageNumber();
            $pageSize            = $this->getRequestedPageSize();
            $recordOffset        = $this->getRecordOffset();
            $this->searchResult  = $this->usersmodel->searchUserByTerm($this->searchterm, $recordOffset, $pageSize);

            $this->data["search_term"  ] = $this->searchterm;
            $this->data["search_result"] = $this->searchResult;
            $this->data["paging"       ] = $this->getPagingData();
        }
        
        $this->loadview("admin_search", $this->data);
    }
    
    protected function getRecordOffset()
    {
        return ($this->requestedPage - 1) * $this->getRequestedPageSize();
    }
    
    protected function getPagingData() 
    {
        $pagesize     = $this->getRequestedPageSize();
        $totalrecords = $this->searchResult["totalresultscount"];
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

$controller = new TSearchController();
$controller->run(array("admin"));
?>