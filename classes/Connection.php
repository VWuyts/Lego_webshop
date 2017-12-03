<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Class Connection
 */

require_once("../php/errorhandling.php");

class Connection extends mysqli
{
    // constructor
    public function __construct($config)
    {
        parent::__construct($config['host'], $config['user'], $config['passw'], $config['db'], $config['port']);

        if(mysqli_connect_error())
        {
            $backtrace = debug_backtrace();
            trigger_error("001@1@". mysqli_connect_errno() ."@". mysqli_connect_error()
                ."@".$backtrace[1]['file']."@".$backtrace[1]['line'], E_USER_ERROR);
            die();
        }
    } // end constructor

    // query the database and return true on success
    public function queryBool($query)
    {
        if(($result = $this->query($query)) === false)
        {
            $backtrace = debug_backtrace();
            trigger_error("002@0@".$backtrace[1]['file']."@".$backtrace[1]['line'], E_USER_ERROR);
            die();
        }
        
        return true;
    } // end function queryBool

    // query the database and return the number of rows on success
    public function queryNoRows($query)
    {
        if(($result = $this->query($query)) === false)
        {
            $backtrace = debug_backtrace();
            trigger_error("002@0@".$backtrace[1]['file']."@".$backtrace[1]['line'], E_USER_ERROR);
            die();
        }
        $noRows = $result->num_rows;
        $result->close();

        return $noRows;
    } // end function queryNoRows

    // query the database and return an open result set on success
    public function queryResult($query)
    {
        if(($result = $this->query($query)) === false)
        {
            $backtrace = debug_backtrace();
            trigger_error("002@0@".$backtrace[1]['file']."@".$backtrace[1]['line'], E_USER_ERROR);
            die();
        }
        
        return $result;
    } // end function queryResult

} // end class Connection
?>