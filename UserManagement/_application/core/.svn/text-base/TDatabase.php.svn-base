<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/


$GLOBALS["connection"] = null;

class TDatabase {

    private $connection;

    public function __construct(){
        global $db_settings;
        
        if ($GLOBALS["connection"] == null) {

            $dbinfo = $db_settings["default"];
            $GLOBALS["connection"] = mysql_connect($dbinfo["host"    ],
                                                   $dbinfo["username"],
                                                   $dbinfo["password"]);

            if (!$GLOBALS["connection"]) {
               TExceptions::throw_db_connection_exception();
            }
            
            mysql_select_db($dbinfo["database"], $GLOBALS["connection"]);
        }
        
        $this->connection = $GLOBALS["connection"];
    }
    
    public function query($sql) {
        $result = mysql_query($sql, $this->connection);

        if ($result) 
            return $result;
        
        $error = mysql_errno($this->connection) . ": " . mysql_error($this->connection);
        TExceptions::throw_sql_exception($error);
    }
    
    public function getInsertId() {
        return mysql_insert_id($this->connection);
    }
}

?>