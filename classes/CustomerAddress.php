<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class CustomerAddress
 */

require_once("../php/errorhandling.php");
require_once("../php/exceptionHandling.php");

class CustomerAddress
{
    // member variables
    private $m_userID;
    private $m_addressID;
    private $m_isActive;
    private $m_isInvoice;
    private $m_tao;
    private $m_custAddressID;

    // constants
    private const MIN_TAO = 2;
    private const MAX_TAO = 100;

    // constructor
    public function __construct($p_userID, $p_addressID ,$p_isActive=true, $p_isInvoice=true, $p_tao=NULL, $p_custAddressID=NULL)
    {
        if (empty(self::check("m_userID", $p_userID)))
        {
            $this->m_userID = $p_userID;
        }
        else
        {
            $this->m_userID = NULL;
        }
        if (empty(self::check("m_addressID", $p_addressID)))
        {
            $this->m_addressID = $p_addressID;
        }
        else
        {
            $this->m_addressID = NULL;
        }
        if (empty(self::check("m_isActive", $p_isActive)))
        {
            $this->m_isActive = $p_isActive;
        }
        else
        {
            $this->m_isActive = true;
        }
        if (empty(self::check("m_isInvoice", $p_isInvoice)))
        {
            $this->m_isInvoice = $p_isInvoice;
        }
        else
        {
            $this->m_isInvoice = false;
        }
        if (empty(self::check("m_tao", $p_tao)))
        {
            $this->m_tao = $p_tao;
        }
        else
        {
            $this->m_tao = NULL;
        }
        if (empty(self::check("m_custAddressID", $p_custAddressID)))
        {
            $this->m_custAddressID = $p_custAddressID;
        }
        else
        {
            $this->m_custAddressID = NULL;
        }
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_userID":
                $this->m_userID = $p_value;
                break;
            case "m_addressID":
                $this->m_addressID = $p_value;
                break;
            case "m_isActive":
                $this->m_isActive = $p_value;
                break;
            case "m_isInvoice":
                $this->m_isInvoice = $p_value;
                break;
            case "m_tao":
                $this->m_tao = $p_value;
                break;
            case "m_custAddressID":
                $this->m_custAddressID = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        switch ($p_property)
        {
        case "userID":
            $result = $this->m_userID;
            break;
        case "m_addressID":
            $result = $this->m_addressID;
            break;
        case "m_isActive":
            $result = $this->m_isActive;
            break;
        case "m_isInvoice":
            $result = $this->m_isInvoice;
            break;
        case "m_tao":
            $result = $this->m_tao;
            break;
        case "m_custAddressID":
            $result = $this->m_custAddressID;
            break;
        }

        return $result;
    } // end function get

    /*
     * add the CustomerAddress to the database
     * The function returns a numerical array('error message', 'primary key').
     * If the CustomerAddress is not in the database, a non-empty error message is returned.
     */
    public function addToDB($connection)
    {
        if (empty($this->m_userID) || empty($this->m_addressID))
        {
            $errMessage = "userID and addressID are required.";
            $primaryKey = NULL;
        }
        elseif (($primaryKey = $this->getPrimaryKey($connection)) === false)
        {
            $query = "INSERT INTO customerAddress (userID, addressID, isActive, isInvoice, tao) 
                VALUES (?, ?, ?, ?, ?)";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('iiiis', $this->m_userID, $this->m_addressID, $this->m_isActive,
                        $this->m_isInvoice, $this->m_tao)) === false)
                {
                    throw new MySQLException("Binding parameters failed."); 
                }
                if (($stmt->execute()) === false)
                {
                    throw new MySQLException("Query execution failed."); 
                }
            } catch (MySQLException $e)
            {
                $e->HandleException();
                die();
            }
            if ($stmt->affected_rows === 1)
            {
                $errMessage = "";
                $primaryKey =  $this->getPrimaryKey($connection);
            }
            else
            {
                $errMessage = "Customer address could not be added to database";
            }
            $stmt->close();
        }
        else // customerAddress is already in db, update tao field
        {
            $query = "UPDATE customerAddress SET tao = ? WHERE custAddressID = ?";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param($this->m_tao, $primaryKey)) === false)
                {
                    throw new MySQLException("Binding parameters failed."); 
                }
                if (($stmt->execute()) === false)
                {
                    throw new MySQLException("Query execution failed."); 
                }
            } catch (MySQLException $e)
            {
                $e->HandleException();
                die();
            }
            $errMessage = "";
            $stmt->close();
        }

        return array($errMessage, $primaryKey);
    } // end function addToDB

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";
        
        if (empty($p_value) && $p_property !== "m_tao")
        {
            $errMessage = ucfirst(substr($p_property, 2)) . " is required";
        }
        else
        {
            switch ($p_property)
            {
            case "m_userID":
            case "m_addressID":
            case "m_custAddressID":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value < 0)
                {
                    $errMessage = "Has to be greater than zero";
                }
                break;    
            case "m_isActive":
            case "m_isInvoice":
                if (filter_var($p_value, FILTER_VALIDATE_BOOLEAN) === false)
                {
                    $errMessage = "Has to be true or false";
                }
                break;
            case "m_tao":
                if (!empty($p_value) && strlen($p_value) < self::MIN_TAO)
                {
                    $errMessage = "At least ". self::MIN_TAO ." characters required";
                }
                elseif (!empty($p_value) && strlen($p_value) > self::MAX_TAO)
                {
                    $errMessage = "Maximum ". self::MAX_TAO ." characters allowed";
                }
                break;
            }
        }

        return $errMessage;
    } // end function check

    /*
     * get the primary key of this CustomerAddress
     * If this CustomerAddress is not found in the database, false is returned
     */
    private function getPrimaryKey($connection)
    {
        $query = "SELECT custAddressID FROM customerAddress
            WHERE userID = ? AND addressID = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('ii', $this->m_userID, $this->m_addressID)) === false)
            {
                throw new MySQLException("Binding parameters failed."); 
            }
            if (($stmt->execute()) === false)
            {
                throw new MySQLException("Query execution failed."); 
            }
            if (($stmt->store_result()) === false)
            {
                throw new MySQLException("Query result storage failed.");
            }
        } catch (MySQLException $e)
        {
            $e->HandleException();
            die();
        }
        if ($stmt->num_rows === 0)
        {
            $primaryKey = false;
        }
        else
        {
            $stmt->bind_result($primaryKey);
            $row = $stmt->fetch();
        }
        $stmt->free_result();
        $stmt->close();

        return $primaryKey;
    } // end function getPrimaryKey


} // end class CustomerAddress