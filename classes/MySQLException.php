<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class MySQLException
 */

require_once("../classes/ErrorLog.php");
require_once("functions.php");

class MySQLException extends Exception
{
    public function HandleException()
    {
        $log = new ErrorLog($this->getCode(), $this->getMessage(), $this->getFile(), $this->getLine());
        $log->WriteError();
        if (isset($_SESSION['role']))
        {
            session_unset();
            session_destroy();
        }
        createErrorPage([$this->getMessage(), "Please contact the Lego Shop administrator."]);
    }
} // end class MySQLException
?>