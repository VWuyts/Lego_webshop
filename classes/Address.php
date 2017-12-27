<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class Address
 */

require_once("../php/errorhandling.php");
require_once("../php/exceptionHandling.php");

class Address
{
    // member variables
    private $m_street;
    private $m_hNumber;
    private $m_postalCode;
    private $m_city;
    private $m_country;
    private $m_box;
    private $m_addressID;

    // constants
    private const MAX_LONG = 50;
    private const MAX_SHORT = 8;
    private const MIN_LONG = 2;
    private const MIN_SHORT = 1;

    // constructor
    public function __construct($p_street, $p_hNumber, $p_postalCode, $p_city, $p_country,
        $p_box = NULL, $p_addressID = NULL)
    {
        if (empty(self::check("m_street", $p_street)))
        {
            $this->m_street = $p_street;
        }
        else
        {
            $this->m_street = "";
        }
        if (empty(self::check("m_hNumber", $p_hNumber)))
        {
            $this->m_hNumber = $p_hNumber;
        }
        else
        {
            $this->m_hNumber = "";
        }
        if (empty(self::check("m_postalCode", $p_postalCode)))
        {
            $this->m_postalCode = $p_postalCode;
        }
        else
        {
            $this->m_postalCode = "";
        }
        if (empty(self::check("m_city", $p_city)))
        {
            $this->m_city = $p_city;
        }
        else
        {
            $this->m_city = "";
        }
        if (empty(self::check("m_country", $p_country)))
        {
            $this->m_country = $p_country;
        }
        else
        {
            $this->m_country = "";
        }
        if (empty(self::check("m_box", $p_box)))
        {
            $this->m_box = $p_box;
        }
        else
        {
            $this->m_box = NULL;
        }
        if (empty(self::check("m_addressID", $p_addressID)))
        {
            $this->m_addressID = $p_addressID;
        }
        else
        {
            $this->m_addressID = NULL;
        }
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_street":
                $this->m_street = $p_value;
                break;
            case "m_hNumber":
                $this->m_hNumber = $p_value;
                break;
            case "m_postalCode":
                $this->m_postalCode = $p_value;
                break;
            case "m_city":
                $this->m_city = $p_value;
                break;
            case "m_country":
                $this->m_country = $p_value;
                break;
            case "m_box":
                $this->m_box = $p_value;
                break;
            case "m_addressID":
                $this->m_addressID = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        switch ($p_property)
        {
        case "m_street":
            $result = $this->m_street;
            break;
        case "m_hNumber":
            $result = $this->m_hNumber;
            break;
        case "m_postalCode":
            $result = $this->m_postalCode;
            break;
        case "m_city":
            $result = $this->m_city;
            break;
        case "m_country":
            $result = $this->m_country;
            break;
        case "m_box":
            $result = $this->m_box;
            break;
        case "m_addressID":
            $result = $this->m_addressID;
            break;
        }

        return $result;
    } // end function get

    /*
     * add the Address to the database
     * The function returns a numerical array('error message', 'primary key').
     * If the address is not in the database, a non-empty error message is returned.
     */
    public function addToDB($connection)
    {
        if (empty($this->m_street) || empty($this->m_hNumber) || empty($this->m_postalCode) ||
            empty($this->m_city) || empty($this->m_country))
        {
            $errMessage = "Street, number, postal code, city and country are required.";
            $primaryKey = NULL;
        }
        elseif (($primaryKey = $this->getPrimaryKey($connection)) === false)
        {
            $query = "INSERT INTO address (street, hNumber, box, postalCode, city, country) 
                VALUES (?, ?, ?, ?, ?, ?)";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('ssssss', $this->m_street, $this->m_hNumber, $this->m_box,
                    $this->m_postalCode, $this->m_city, $this->m_country)) === false)
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
            $primaryKey =  $this->getPrimaryKey($connection);
            $stmt->close();
        }
        else // address is already in db
        {
            $errMessage = "";
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

        if (empty($p_value) && $p_property !== "m_box")
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            switch ($p_property)
            {
            case "m_street":
            case "m_city":
            case "m_country":
                if (strlen($p_value) < self::MIN_LONG)
                {
                    $errMessage = "At least ". self::MIN_LONG ." character required";
                }
                elseif (strlen($p_value) > self::MAX_LONG)
                {
                    $errMessage = "Maximum ". self::MAX_LONG ." characters allowed";
                }
                break;
            case "m_hNumber":
            case "m_postalCode":
                if (strlen($p_value) < self::MIN_SHORT)
                {
                    $errMessage = "At least ". self::MIN_SHORT ." character required";
                }
                elseif (strlen($p_value) > self::MAX_SHORT)
                {
                    $errMessage = "Maximum ". self::MAX_SHORT ." characters allowed";
                }
                break;
            case "m_box":
                if (strlen($p_value) > self::MAX_SHORT)
                {
                    $errMessage = "Maximum ". self::MAX_SHORT ." characters allowed";
                }
            case "m_addressID":
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
     * get shipCountries
     * Returns all the possible countries where orders can be shipped to as an array
     */
    public static function getShipCountries($connection)
    {
        $query = "SELECT DISTINCT country FROM shippingCost ORDER BY 1 ASC;";
        $countryArray = array();
        $result = $connection->queryResult($query);
        while ($row = $result->fetch_array())
        {
            $countryArray[] = $row['country'];
        }
        $result->close();

        return $countryArray;
    } // end function getShipCountries
    
    /*
     * get the primary key of this Address
     * If this address is not found in the database, false is returned
     */
    private function getPrimaryKey($connection)
    {
        $query = "SELECT addressID FROM address WHERE street = ? AND hNumber = ? AND postalCode = ? 
            AND CITY = ? AND country = ? AND box = ?";
        $box = (is_null($this->m_box) ? "NULL" : $this->m_box);
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('ssssss', $this->m_street, $this->m_hNumber, $this->m_postalCode,
            $this->m_city, $this->m_country, $box)) === false)
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
            $stmt->fetch();
        }
        $stmt->free_result();
        $stmt->close();
        
        return $primaryKey;
    } // end function getPrimaryKey
} // end class Address
?>