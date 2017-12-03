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

require_once("Connection.php");
require_once("../php/errorhandling.php");

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
        if (empty(self::check("userID", $p_userID)))
        {
            $this->m_userID = $p_userID;
        }
        else
        {
            $this->m_userID = NULL;
        }
        if (empty(self::check("addressID", $p_addressID)))
        {
            $this->m_addressID = $p_addressID;
        }
        else
        {
            $this->m_addressID = NULL;
        }
        if (empty(self::check("isActive", $p_isActive)))
        {
            $this->m_isActive = $p_isActive;
        }
        else
        {
            $this->m_isActive = true;
        }
        if (empty(self::check("isInvoice", $p_isInvoice)))
        {
            $this->m_isInvoice = $p_isInvoice;
        }
        else
        {
            $this->m_isInvoice = NULL;
        }
        if (empty(self::check("tao", $p_tao)))
        {
            $this->m_tao = $p_tao;
        }
        else
        {
            $this->m_tao = NULL;
        }
        if (empty(self::check("custAddressID", $p_custAddressID)))
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
                case "userID":
                    $this->m_userID = $p_value;
                    break;
                case "addressID":
                    $this->m_addressID = $p_value;
                    break;
                case "isActive":
                    $this->m_isActive = $p_value;
                    break;
                case "isInvoice":
                    $this->m_isInvoice = $p_value;
                    break;
                case "tao":
                    $this->m_tao = $p_value;
                    break;
                case "custAddressID":
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
            case "addressID":
                $result = $this->m_addressID;
                break;
            case "isActive":
                $result = $this->m_isActive;
                break;
            case "isInvoice":
                $result = $this->m_isInvoice;
                break;
            case "tao":
                $result = $this->m_tao;
                break;
            case "custAddressID":
                $result = $this->m_custAddressID;
                break;
        }

        return $result;
    } // end function get

    /*
     * add the CustomerAddress to the database
     * The CustomerAddress will be added with isInvoice = true and isActive = true.
     * The function returns a numerical array('error message', 'primary key').
     * If the CustomerAddress is not in the database, a non-empty error message is returned.
     */
    public function addToDB($config)
    {
        $connection = new Connection($config);
        if (empty($this->m_userID) || empty($this->m_addressID))
        {
            $errMessage = "userID and addressID are required.";
            $primaryKey = NULL;
        }
        elseif (($primaryKey = $this->getPrimaryKey($connection)) === false)
        {
            $query = "INSERT INTO customerAddress (userID, addressID, isActive, isInvoice, tao) ".
            "VALUES ('". $this->m_userID ."', '". $this->m_addressID ."', '". $this->m_isActive ."', '".
                $this->m_isInvoice ."', '". $this->m_tao ."');";
            if ($connection->queryBool($query))
            {
                $errMessage = "";
                $primaryKey = $this->getPrimaryKey($connection);
            }
        }
        else
        {
            $errMessage = "";
        }
        $connection->close();

        return array($errMessage, $primaryKey);
    } // end function addToDB

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";
        
        if (empty($p_value) && $p_property !== "tao")
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            switch ($p_property)
            {
                case "userID":
                case "addressID":
                    if ($p_value < 0)
                    {
                        $errMessage = "Has to be greater than zero";
                    }
                    break;    
                case "isActive":
                case "isInvoice":
                    if (!is_bool($p_value))
                    {
                        $errMessage = "Has to be true or false";
                    }
                    break;
                case "tao":
                    if (strlen($p_value) < self::MIN_TAO)
                    {
                        $errMessage = "At least ". self::MIN_TAO ." characters required";
                    }
                    elseif (strlen($p_value) > self::MAX_TAO)
                    {
                        $errMessage = "Maximum ". self::MAX_TAO ." characters allowed";
                    }
                    break;
                case "custAddressID":
                    if ($p_value < 0)
                    {
                        $errMessage = "Has to be greater than or equal to 0";
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
        $query = "SELECT custAddressID FROM customerAddress WHERE userID='".
            $this->m_userID ."' AND addressID='". $this->m_addressID ."'";
        $result = $connection->queryResult($query);
        $noRows = $result->num_rows;
        if ($noRows === 0)
        {
            $result->close();
            return false;
        }
        $row = $result->fetch_array();
        $primaryKey = $row['custAddressID'];
        $result->close();

        return $primaryKey;
    } // end function getPrimaryKey


} // end class CustomerAddress