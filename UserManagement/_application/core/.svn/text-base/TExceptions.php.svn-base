<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/


class TExceptions {

    static function throw_invalid_model_exception()
    {
        Throw new Exception("Invalid Model Name.");
    }

    static function throw_invalid_view_exception()
    {
        Throw new Exception("Invalid View Name.");
    }

    static function throw_db_connection_exception()
    {
        Throw new Exception("Connection to database failed.");
    }

    static function throw_sql_exception($message)
    {
        Throw new Exception($message);
    }

    static function throw_username_alread_exists_exception($username)
    {
        Throw new Exception("Username ('$username') already exists.");
    }
    
    static function throw_invalid_setting_exception($setting)
    {
        Throw new Exception("Setting '$setting' does not exist.");
    }
}

?>