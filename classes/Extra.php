<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class Extra
 */

require_once("Product.php");

class Extra extends Product
{
    // constants
    public const PRICE_ARRAY = array(20, 50, 100);
    public const PIECES_ARRAY = array(100, 500);

    // constructor
    public function __construct($p_productno, $p_pName, $p_price, $p_minAge,
        $p_description, $p_isActive, $p_pieces = NULL, $p_themeID = NULL)
    {
        parent::__construct($p_productno, $p_pName, $p_price, $p_minAge,
            $p_description, $p_isActive, $p_pieces, $p_themeID);
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        parent::_set($p_property, $p_value);
    } // end function set

    // get property value
    public function __get($p_property)
    {
        $result = parent::__get($p_property);

        return $result;
    } // end function get

    /*
     * add the Extra to the database
     * The Extra will be added with category = 'extras' and isActive = true.
     * The function returns a numerical array('error message', 'primary key').
     * If the Extra is not in the database, a non-empty error message is returned.
     */
    public function addToDB($connection)
    {
        if (empty($this->m_productno) || empty($this->m_pName) || empty($this->m_price)  || empty($this->m_minAge) 
            || empty($this->m_description))
        {
            $errMessage = "Product number, product name, price, minimum age AND description are required.";
            $primaryKey = NULL;
        }
        else
        {
            // Check if Extra is not yet in the database
            list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
            if ($primaryKey === false)
            {
                // Check themeID
                $themeArray = self::getTheme($connection);
                if (!is_null($this->m_themeID) && array_search($this->m_themeID, $themeArray['tName']) === false)
                {
                    $errMessage = "The themeID is not valid";
                    $this->m_themeID = NULL;
                }
                // If no error message, extra can be added to database
                if ($errMessage === "")
                {
                    $query = "INSERT INTO product 
                        (productno, pName, price, minAge, description, isActive, category, pieces, themeID) 
                    VALUES (?, ?, ?, ?, ?, true, 'sets', ?, ?)";
                    try
                    {
                        if (($stmt = $connection->prepare($query)) === false)
                        {
                            throw new MySQLException("Preparation of query failed."); 
                        }
                        if (($stmt->bind_param('isdisii', $this->m_productno, $this->m_pName, $this->m_price,
                            $this->m_minAge, $this->m_description, $this->m_pieces, $this->m_themeID)) === false)
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
                    list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
                    $stmt->close();
                }
            }
            else // Extra is already in the database
            {
                if ($isActive == false)
                {
                    // Set isActive to true
                    $query = "UPDATE product SET isActive = true 
                        WHERE productno = ?";
                    try
                    {
                        if (($stmt = $connection->prepare($query)) === false)
                        {
                            throw new MySQLException("Preparation of query failed."); 
                        }
                        if (($stmt->bind_param('i', $this->m_productno)) === false)
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
                    list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
                    $stmt->close();
                }
            }
        }

        return array($errMessage, $primaryKey);
    } // end function addToDB

    /*
     * get the category of this Extra
     */
    public function getCategory()
    {
        return "extras";
    } // end function getCategory

    /*
     * print this Product
     * If shoppingbag === true, a button 'add to bag' is also printed.
     * Label array is not used.
     */
    public function print($shoppingBag, $labelArray)
    {
        echo("\t\t\t\t<div class='product'>\n");
        echo("\t\t\t\t<p class='labelEmpty'>&nbsp;</p>\n");
        echo("\t\t\t\t\t<img src='../images/". $this->m_productno .".jpg' alt='image of extra' />\n");
        echo("\t\t\t\t\t<div class='info'>\n");
        echo("\t\t\t\t\t\t<p class='left smallfont lightGrey'>". $this->m_productno ."</p>\n");
        echo("\t\t\t\t\t\t<p class='left pName'>". htmlspecialchars($this->m_pName) ."</p>\n");
        echo("\t\t\t\t\t\t<p class='right price'>". $this->m_price ." &euro;</p>\n");
        echo("\t\t\t\t\t</div>\n");
        if ($shoppingBag)
        {
            echo("\t\t\t\t\t<div class='addToBag'>\n");
            echo("\t\t\t\t\t\t<form action='". $_SERVER['PHP_SELF'] ."' method='post'>\n");
            echo("\t\t\t\t\t\t\t<input type='hidden' name='productno' value='". $this->m_productno ."' />\n");
            echo("\t\t\t\t\t\t\t<input class='btn' type='submit' value='ADD TO BAG' name='addToBag' />\n");
            echo("\t\t\t\t\t\t</form>\n");
            echo("\t\t\t\t\t</div>\n");
        }
        echo("\t\t\t\t</div> <!-- end product -->\n");
    } // end function print

    /*
     * get an array of all active Extras ordered by productno
     */
    public static function getProducts($connection)
    {
        $extrasArray = array();
        $query = "SELECT * FROM product
            WHERE category = 'extras' AND isActive = true 
            ORDER BY productno";
        $result = $connection->queryResult($query);
        
        while ($row = $result->fetch_array())
        {
            $extrasArray[] = new Extra($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID']);
        }
        return $extrasArray;
    } // end function getProducts

    /*
     * get an array of all Extras ordered by productno
     */
    public static function getAllProducts($connection)
    {
        $extrasArray = array();
        $query = "SELECT * FROM product
            WHERE category = 'extras'  
            ORDER BY productno";
        $result = $connection->queryResult($query);
        
        while ($row = $result->fetch_array())
        {
            $extrasArray[] = new Extra($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID']);
        }
        return $extrasArray;
    } // end function getAllProducts

    /*
     * get an array of Extras from a MySQLi result set
     */
    public static function getProductsFromResultSet($result)
    {
        $extrasArray = array();
        
        while ($row = $result->fetch_array())
        {
            $extrasArray[] = new Extra($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID']);
        }
        return $extrasArray;
    } // end function getProductsFromResultSet

    /*
     * get an array of all themes and their themeID
     */
    public static function getTheme($connection)
    {
        $themeArray = array(
            'themeID'   => array(),
            'tName'     => array() 
        );
        $query = "SELECT DISTINCT theme.themeID, theme.tName 
            FROM theme INNER JOIN product 
            ON theme.themeID = product.themeID 
            WHERE product.category = 'extras'  AND isActive = true 
            ORDER BY theme.tName";
        $result = $connection->queryResult($query);

        while ($row = $result->fetch_array())
        {
            $themeArray['themeID'][] = $row['themeID'];
            $themeArray['tName'][] = $row['tName'];
        }

        return $themeArray;
    } // end function getTheme

    /*
     * get an array of all minAges
     */
    public static function getAge($connection)
    {
        $ageArray = array();
        $query = "SELECT DISTINCT minAge FROM product  
            WHERE category = 'extras' AND isActive = true 
            ORDER BY minAge";
        $result = $connection->queryResult($query);

        while ($row = $result->fetch_array())
        {
            $ageArray[] = $row['minAge'];
        }

        return $ageArray;
    } // end function getAge

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";
        if (empty($p_value) && ($p_property !== 'm_pieces' || $p_property !== 'm_themeID'))
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            $errMessage = parent::check($p_property, $p_value);
        }
        
        return $errMessage;
    } // end function check
} // end class Extra
?>
