<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * abstract class Product
 */

require_once("../php/errorHandling.php");
require_once("../php/exceptionHandling.php");
require_once("Connection.php");

abstract class Product
{
    // member variables
    private $m_productno;
    private $m_pName;
    private $m_price;
    private $m_minAge;
    private $m_description;
    private $m_isActive;
    private $m_pieces;
    private $m_themeID;

    // constants
    private const MAX_PRODUCTNO = 16777215; // max MEDIUM INT UNSIGNED
    private const MAX_VARCHAR = 50;
    private const MAX_PRICE = 9999.99;
    private const MAX_AGE = 16;
    private const MAX_TEXT = 65535; // max number of chars in TEXT
    private const MAX_PIECES = 10000;
    private const MIN_CHAR = 2;

    // constructor
    public function __construct($p_productno, $p_pName, $p_price, $p_minAge,
        $p_description, $p_isActive = false, $p_pieces = NULL, $p_themeID = NULL)
    {
        if (empty(self::check("m_productno", $p_productno)))
        {
            $this->m_productno = $p_productno;
        }
        else
        {
            $this->m_productno = 1;
        }
        if (empty(self::check("m_pName", $p_pName)))
        {
            $this->m_pName = $p_pName;
        }
        else
        {
            $this->m_pName = "";
        }
        if (empty(self::check("m_price", $p_price)))
        {
            $this->m_price = $p_price;
        }
        else
        {
            $this->m_price = 0;
        }
        if (empty(self::check("m_minAge", $p_minAge)))
        {
            $this->m_minAge = $p_minAge;
        }
        else
        {
            $this->m_minAge = self::MAX_AGE;
        }
        if (empty(self::check("m_description", $p_description)))
        {
            $this->m_description = $p_description;
        }
        else
        {
            $this->m_description = 0;
        }
        if (empty(self::check("m_isActive", $p_isActive)))
        {
            $this->m_isActive = $p_isActive;
        }
        else
        {
            $this->m_isActive = false;
        }
        if (empty(self::check("m_pieces", $p_pieces)))
        {
            $this->m_pieces = $p_pieces;
        }
        else
        {
            $this->m_pieces = NULL;
        }
        if (empty(self::check("m_themeID", $p_themeID)))
        {
            $this->m_themeID = $p_themeID;
        }
        else
        {
            $this->m_themeID = NULL;
        }
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_productno":
                $this->m_productno = $p_value;
                break;
            case "m_pName":
                $this->m_pName = $p_value;
                break;
            case "m_price":
                $this->m_price = $p_value;
                break;
            case "m_minAge":
                $this->m_minAge = $p_value;
                break;
            case "m_description":
                $this->m_description = $p_value;
                break;
            case "m_isActive":
                $this->m_isActive = $p_value;
                break;
            case "m_pieces":
                $this->m_pieces = $p_value;
                break;
            case "m_themeID":
                $this->m_themeID = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        $result = NULL;

        switch ($p_property)
        {
        case "m_productno":
            $result = $this->m_productno;
            break;
        case "m_pName":
            $result = $this->m_pName;
            break;
        case "m_price":
            $result = $this->m_price;
            break;
        case "m_minAge":
            $result = $this->m_minAge;
            break;
        case "m_description":
            $result = $this->m_description;
            break;
        case "m_isActive":
            $result = $this->m_isActive;
            break;
        case "m_pieces":
            $result = $this->m_pieces;
            break;
        case "m_themeID":
            $result = $this->m_themeID;
            break;
        }

        return $result;
    } // end function get

    // Abstract functions
    abstract function addToDB($connection);
    abstract function getCategory();
    abstract function print($shoppingBag, $labelArray);
    abstract static function getProducts($connection);
    abstract static function getAllProducts($connection);

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";

        if (empty($p_value) && ($p_property !== 'm_pieces' || $p_property !== 'm_themeID'))
        {
            $errMessage = ucfirst(substr($p_property, 2)) . " is required";
        }
        else
        {
            switch ($p_property)
            {
            case "m_productno":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value <= 0)
                {
                    $errMessage = "Should be greater than zero";
                }
                elseif ($p_value > self::MAX_PRODUCTNO)
                {
                    $errMessage = "Should be less than or equal to ". self::MAX_PRODUCTNO;
                }
                break;
            case "m_pName":
                if (strlen($p_value) < self::MIN_CHAR)
                {
                    $errMessage = "At least ". self::MIN_CHAR ." characters required";
                }
                elseif (strlen($p_value) > self::MAX_VARCHAR)
                {
                    $errMessage = "Maximum ". self::MAX_VARCHAR ." characters allowed";
                }
                break;
            case "m_price":
                if (filter_var($p_value, FILTER_VALIDATE_FLOAT) === false)
                {
                    $errMessage = "Invalid decimal input";
                }
                elseif ($p_value < 0)
                {
                    $errMessage = "Has to be greater than or equal to 0";
                }
                elseif ($p_value > self::MAX_PRICE)
                {
                    $errMessage = "Should be less than or equal to ". self::MAX_PRICE;
                }
                break;
            case "m_minAge":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value <= 0)
                {
                    $errMessage = "Should be greater than zero";
                }
                elseif ($p_value > self::MAX_AGE)
                {
                    $errMessage = "Should be less than or equal to ". self::MAX_AGE;
                }
                break;
            case "m_description":
                if (strlen($p_value) < self::MIN_CHAR)
                {
                    $errMessage = "At least ". self::MIN_CHAR ." characters required";
                }
                elseif (strlen($p_value) > self::MAX_TEXT)
                {
                    $errMessage = "Maximum ". self::MAX_TEXT ." characters allowed";
                }
                break;
            case "m_isActive":
                if (filter_var($p_value, FILTER_VALIDATE_BOOLEAN) === false)
                {
                    $errMessage = "Has to be true or false";
                }
                break;
            case "m_pieces":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value <= 0)
                {
                    $errMessage = "Should be greater than zero";
                }
                elseif ($p_value > self::MAX_PIECES)
                {
                    $errMessage = "Should be less than or equal to ". self::MAX_PIECES;
                }
                break;
            case "m_themeID":
                if (!is_null($p_value) && filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value <= 0)
                {
                    $errMessage = "Should be greater than zero";
                }
                break;
            }
        }
        
        return $errMessage;
    } // end function check

    // get pName and price of a product with the given productno
    public static function getInfo($productno, $connection)
    {
        $query = "SELECT pName, price FROM product WHERE productno = ". $productno;
        $result = $connection->queryResult($query);
        while ($row = $result->fetch_array())
        {
            $pName = $row['pName'];
            $price = $row['price'];
        }

        return array($pName, $price);
    } // end function getInfo

    // change the status of the product with the given productno
    // If the status could not be changed, a non-empty error message is returned.
    public static function changeStatus($productno, $connection)
    {
        $isActive = 0;
        $errMessage = "";
        $query = "SELECT isActive FROM product WHERE productno = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('i', $productno)) === false)
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
        $stmt->bind_result($isActive);
        $stmt->fetch();
        if (is_null($isActive))
        {
            $errMessage = "The product with the given productno could not be found.";
        }
        else
        {
            $isActive = ($isActive ? 0 : 1);
            $stmt->close();
            $query = "UPDATE product SET isActive = ". $isActive ." WHERE productno = ?";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('i', $productno)) === false)
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
        }
        $stmt->close();

        return $errMessage;
    } // end function changeStatus

    // change a property in the database
    public static function changeProperty($p_property, $p_value, $productno, $connection)
    {
        $errMessage = "";
        $query = "UPDATE product SET ";
        $param = "";
        if (empty($errMessage = self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_pName":
                $query .= "pName";
                $param = "s";
                break;
            case "m_price":
                $query .= "price";
                $param = "d";
                break;
            case "m_minAge":
                $query .= "minAge";
                $param = "i";
                break;
            case "m_description":
                $query .= "description";
                $param = "s";
                break;
            case "m_isActive":
                $query .= "isActive";
                $param = "i";
                break;
            case "m_pieces":
                $query .= "pieces";
                $param = "i";
                break;
            case "m_themeID":
                $query .= "themeID";
                $param = "i";
                break;
            }
            $query .= " = ? WHERE productno = ?";
            $param .= "i";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param($param, $p_value, $productno)) === false)
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
        }

        return $errMessage;
    } // end function changeProperty

    /*
     * get the primary key of this Product
     * Function getPrimaryKey returns an array of the primary key and the value
     * of the field isActive.
     * If this Product is not found in the database, false is returned
     * as primary key.
     */
    protected function getPrimaryKey($connection)
    {
        $query = "SELECT productno, isActive FROM product WHERE pName = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('i', $this->m_pName)) === false)
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
            $isActive = false;
        }
        else
        {
            $stmt->bind_result($primaryKey, $isActive);
            $stmt->fetch();
        }
        $stmt->free_result();
        $stmt->close();

        return array($primaryKey, $isActive);
    } // end function getPrimaryKey
} // end class product
?>