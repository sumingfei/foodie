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

class TSignoutController extends TAbstractController {

    protected function execute() {
        $this->destroySession();
        $this->redirect(SITE_URL);        
    }
    
    public function destroySession() {
        $sessionid = $this->authentication->getCurrentSessionId();
        $model     = $this->loadmodel("Sessions");
        $model->destroySession($sessionid);
    }
}

$controller = new TSignoutController();
$controller->run();

?>