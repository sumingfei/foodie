<?php 
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/


class TAbstractModel {

    protected $db = null;

    public function __construct() {
        $this->db = new TDatabase();
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
}

?>