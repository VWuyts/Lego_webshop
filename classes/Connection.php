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

require_once("MySQLException.php");
require_once("../php/functions.php");
require_once("../php/errorhandling.php");
require_once("../php/exceptionhandling.php");

class Connection extends mysqli
{
    // constants
    private const HOST = 'localhost';
    private const PORT = 3306;
    private const USER = 'Webgebruiker';
    private const PASSW = 'Labo2017';
    private const DB = 'Legoshop';

    // constructor
    public function __construct()
    {
        try
        {
            parent::__construct(self::HOST, self::USER, self::PASSW, self::DB, self::PORT);
            if(mysqli_connect_error())
            {
                throw new MySQLException("The connection to the database failed.");
            }
        } catch (MySQLException $e)
        {
            $e->HandleException();
            die();
        }
        
    } // end constructor

    // query the database and return true on success
    // Only to be used for queries without user input
    public function queryBool($query)
    {
        try
        {
            if(($result = $this->query($query)) === false)
            {
                throw new MySQLException("A database query failed.");
            }
        } catch (MySQLException $e)
        {
            $e->HandleException();
            die();
        }
        
        return true;
    } // end function queryBool

    // query the database and return the number of rows on success
    // Only to be used for queries without user input
    public function queryNoRows($query)
    {
        try
        {
            if(($result = $this->query($query)) === false)
            {
                throw new MySQLException("A database query failed.");
            }
            $noRows = $result->num_rows;
            $result->close();
        } catch (MySQLException $e)
        {
            $e->HandleException();
            die();
        }
        
        return $noRows;
    } // end function queryNoRows

    // query the database and return an open result set on success
    // Only to be used for queries without user input
    public function queryResult($query)
    {
        try
        {
            if(($result = $this->query($query)) === false)
            {
                throw new MySQLException("A database query failed.");
            }
        } catch (MySQLException $e)
        {
            $e->HandleException();
            die();
        }
        
        return $result;
    } // end function queryResult

} // end class Connection
?>