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

require_once("Connection.php");
require_once("../php/errorhandling.php");

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
        $p_box=NULL, $p_addressID=NULL)
    {
        if (empty(self::check("street", $p_street)))
        {
            $this->m_street = $p_street;
        }
        else
        {
            $this->m_street = "";
        }
        if (empty(self::check("hNumber", $p_hNumber)))
        {
            $this->m_hNumber = $p_hNumber;
        }
        else
        {
            $this->m_hNumber = "";
        }
        if (empty(self::check("postalCode", $p_postalCode)))
        {
            $this->m_postalCode = $p_postalCode;
        }
        else
        {
            $this->m_postalCode = "";
        }
        if (empty(self::check("city", $p_city)))
        {
            $this->m_city = $p_city;
        }
        else
        {
            $this->m_city = "";
        }
        if (empty(self::check("country", $p_country)))
        {
            $this->m_country = $p_country;
        }
        else
        {
            $this->m_country = "";
        }
        if (empty(self::check("box", $p_box)))
        {
            $this->m_box = $p_box;
        }
        else
        {
            $this->m_box = NULL;
        }
        if (empty(self::check("addressID", $p_addressID)))
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
                case "street":
                    $this->m_street = $p_value;
                    break;
                case "hNumber":
                    $this->m_hNumber = $p_value;
                    break;
                case "postalCode":
                    $this->m_postalCode = $p_value;
                    break;
                case "city":
                    $this->m_city = $p_value;
                    break;
                case "country":
                    $this->m_country = $p_value;
                    break;
                case "box":
                    $this->m_box = $p_value;
                    break;
                case "addressID":
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
            case "street":
                $result = $this->m_street;
                break;
            case "hNumber":
                $result = $this->m_hNumber;
                break;
            case "postalCode":
                $result = $this->m_postalCode;
                break;
            case "city":
                $result = $this->m_city;
                break;
            case "country":
                $result = $this->m_country;
                break;
            case "box":
                $result = $this->m_box;
                break;
            case "addressID":
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
    public function addToDB($config)
    {
        $connection = new Connection($config);
        if (empty($this->m_street) || empty($this->m_hNumber) || empty($this->m_postalCode) ||
            empty($this->m_city) || empty($this->m_country))
        {
            $errMessage = "Street, number, postal code, city and country are required.";
            $primaryKey = NULL;
        }
        elseif (($primaryKey = $this->getPrimaryKey($connection)) === false)
        {
            $query = "INSERT INTO address (street, hNumber, box, postalCode, city, country) ".
            "VALUES ('". $this->m_street ."', '". $this->m_hNumber ."', '". $this->m_box ."', '".
                $this->m_postalCode ."', '". $this->m_city ."', '". $this->m_country ."');";
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

        if (empty($p_value) && $p_property !== "box")
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            switch ($p_property)
            {
                case "street":
                case "city":
                case "country":
                    if (strlen($p_value) < self::MIN_LONG)
                    {
                        $errMessage = "At least ". self::MIN_LONG ." character required";
                    }
                    elseif (strlen($p_value) > self::MAX_LONG)
                    {
                        $errMessage = "Maximum ". self::MAX_LONG ." characters allowed";
                    }
                    break;
                case "hNumber":
                case "postalCode":
                    if (strlen($p_value) < self::MIN_SHORT)
                    {
                        $errMessage = "At least ". self::MIN_SHORT ." character required";
                    }
                    elseif (strlen($p_value) > self::MAX_SHORT)
                    {
                        $errMessage = "Maximum ". self::MAX_SHORT ." characters allowed";
                    }
                    break;
                case "box":
                    if (strlen($p_value) > self::MAX_SHORT)
                    {
                        $errMessage = "Maximum ". self::MAX_SHORT ." characters allowed";
                    }
                case "addressID":
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
     * get shipCountries($config)
     * Returns all the possible countries where orders can be shipped to as an array
     */
    public static function getShipCountries($config)
    {
        $query = "SELECT DISTINCT country FROM shippingCost ORDER BY 1 ASC;";
        $countryArray = array();
        $connection = new Connection($config);
        $result = $connection->queryResult($query);
        while ($row = $result->fetch_array())
        {
            $countryArray[] = $row['country'];
        }
        $result->close();
        $connection->close();

        return $countryArray;
    } // end function getShipCountries
    
    /*
     * get the primary key of this Address
     * If this address is not found in the database, false is returned
     */
    private function getPrimaryKey($connection)
    {
        $query = "SELECT addressID FROM address WHERE street='". $this->m_street .
            "' AND hNumber='". $this->m_hNumber ."' AND postalCode='". $this->m_postalCode .
            "' AND CITY='". $this->m_city ."' AND country='". $this->m_country ."' AND box=";
        $query .= (is_null($this->m_box) ? "NULL;" : "'". $this->m_box ."';");
        $result = $connection->queryResult($query);
        $noRows = $result->num_rows;
        if ($noRows === 0)
        {
            $result->close();
            return false;
        }
        $row = $result->fetch_array();
        $primaryKey = $row['addressID'];
        $result->close();

        return $primaryKey;
    } // end function getPrimaryKey

} // end class Address
?>