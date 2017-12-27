<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Class Orders
 */

class Orders
{
    // member variables
    private $m_orderno;
    private $m_orderDate;
    private $m_isPayed;
    private $m_orderStatus;
    private $m_userID;
    private $m_invoiceAddressID;
    private $m_shipAddressID;
    private $m_shipCostID;

    // constructor
    public function __construct($p_isPayed, $p_userID, $p_invoiceAddressID, $p_shipAddressID, $p_shipCostID)
    {
        $this->m_orderno = NULL;
        $this->m_orderDate = getdate();
        if (empty(self::check("m_isPayed", $p_isPayed))) $this->m_isPayed = $p_isPayed;
        else $this->m_isPayed = false;
        $this->m_orderStatus = "processing";
        if (empty(self::check("m_userID", $p_userID))) $this->m_userID = $p_userID;
        else $this->m_userID = 0;
        if (empty(self::check("m_invoiceAddressID", $p_invoiceAddressID))) $this->m_invoiceAddressID = $p_invoiceAddressID;
        else $this->m_invoiceAddressID = 0;
        if (empty(self::check("m_shipAddressID", $p_shipAddressID))) $this->m_shipAddressID = $p_shipAddressID;
        else $this->m_shipAddressID = 0;
        if (empty(self::check("m_shipCostID", $p_shipCostID))) $this->m_shipCostID = $p_shipCostID;
        else $this->m_shipCostID = 0;
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_orderno":
                $this->m_orderno = $p_value;
                break;
            case "m_orderDate":
                $this->m_orderDate = $p_value;
                break;
            case "m_isPayed":
                $this->m_isPayed = $p_value;
                break;
            case "m_orderStatus":
                $this->m_orderStatus = $p_value;
                break;
            case "m_userID":
                $this->m_userID = $p_value;
                break;
            case "m_invoiceAddressID":
                $this->m_invoiceAddressID = $p_value;
                break;
            case "m_shipAddressID":
                $this->m_shipAddressID = $p_value;
                break;
            case "m_shipCostID":
                $this->m_shipCostID = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        switch ($p_property)
        {
        case "m_orderno":
            $result = $this->m_orderno;
            break;
        case "m_orderDate":
            $result = $this->m_orderDate;
            break;
        case "m_isPayed":
            $result = $this->m_isPayed;
            break;
        case "m_orderStatus":
            $result = $this->m_orderStatus;
            break;
        case "m_userID":
            $result = $this->m_userID;
            break;
        case "m_invoiceAddressID":
            $result = $this->m_invoiceAddressID;
            break;
        case "m_shipAddressID":
            $result = $this->m_shipAddressID;
            break;
        case "m_shipCostID":
            $result = $this->m_shipCostID;
            break;
        }

        return $result;
    } // end function get

     /*
     * add the Order to the database
     * The function returns an error message.
     * If the Order is not in the database, a non-empty error message is returned.
     */
    public function addToDB($connection, $shoppingBag)
    {
        if (empty($this->m_orderDate) || empty($this->m_isPayed) || empty($this->m_orderStatus)  || empty($this->m_userID) 
            || empty($this->m_invoiceAddressID) || empty($this->m_shipAddressID) || empty($this->m_shipCostID))
        {
            $errMessage = "Order date, payment, order status, userID, invoiceAddressID, shipAddressID 
                and shipCostID are required.";
            $primaryKey = NULL;
        }
        else
        {
            $query = "INSERT INTO orders 
                (orderDate, userID, isPayed, orderStatus, invoiceAddressID, shipAddressID, shipCostID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('iiisiii', $this->m_orderDate, $this->m_userID, $this->m_isPayed, $this->m_orderStatus, 
                    $this->m_invoiceAddressID, $this->m_shipAddressID, $this->m_shipCostID)) === false)
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
            $query = "INSERT INTO orderDetail (orderno, productno, quantity) 
                VALUES(?, ?, ?)";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                for ($i = 0; $i < count($shoppingBag['productno']); $i++)
                {
                    if (!is_null($shoppingBag['productno'][$i]))
                    {
                        if (($stmt->bind_param('iii', $primaryKey, $shoppingBag['productno'][$i],
                            $shoppingBag['amount'][$i])) === false)
                        {
                            throw new MySQLException("Binding parameters failed."); 
                        }
                        if (($stmt->execute()) === false)
                        {
                            throw new MySQLException("Query execution failed."); 
                        }
                    }
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

    // Get the shipCostID and the shipping cost
    public static function getShipCost($shipAddressID, $totalPrice, $connection)
    {
        $query = "SELECT s.costID, s.amount
            FROM shippingCost s INNER JOIN address a
                ON s.country = a.country 
            INNER JOIN customerAddress c 
                ON a.addressID = c.addressID 
            WHERE c.custAddressID = ? AND s.minPurchase <= ?
            ORDER BY s.minPurchase DESC 
            LIMIT 1";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('id', $shipAddressID, $totalPrice)) === false)
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
        $stmt->bind_result($costID, $amount);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        return array($costID, $amount);
    } // end function getShipCost

    // get the maximum shippingCost
    public static function getMaxShippingCost($connection, $totalPrice)
    {
        $query = "SELECT MAX(amount) FROM shippingCost WHERE minPurchase <= ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('d', $totalPrice)) === false)
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
        $stmt->bind_result($amount);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        return $amount;
    } // end function getMaxShippingCost

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";

        if (empty($p_value))
        {
            $errMessage = ucfirst(substr($p_property, 2)) . " is required";
        }
        else
        {
            switch ($p_property)
            {
            case "m_orderno":
            case "m_userID":
            case "m_invoiceAddressID":
            case "m_shipAddressID":
            case "m_shipCostID":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value <= 0)
                {
                    $errMessage = "Should be greater than zero";
                }
                break;
            case "m_isPayed":
                if (filter_var($p_value, FILTER_VALIDATE_BOOLEAN) === false)
                {
                    $errMessage = "Should be true or false";
                }
                break;
            case "m_orderStatus":
                if ($p_value != "processing" || $p_value != "shipped" || $p_value != "delivered")
                {
                    $errMessage = "Should be 'processing', 'shipped', or 'delivered'";
                }
            }
        }
    } // end function check

    /*
     * get the primary key of this Orders
     * If this orders is not found in the database, false is returned
     */
    private function getPrimaryKey($connection)
    {
        $query = "SELECT orderno FROM orders WHERE orderDate = ? AND userID = ? AND isPayed = ? 
            AND orderStatus = ? AND invoiceAddressID = ? AND shipAddressID = ? AND shipCostID = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('iiisiii', $this->m_orderDate, $this->m_userID, $this->m_isPayed, $this->m_orderStatus, 
            $this->m_invoiceAddressID, $this->m_shipAddressID, $this->m_shipCostID)) === false)
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
} // end class Orders
?>