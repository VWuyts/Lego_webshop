<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class BuildingSet
 */

require_once("Product.php");

class BuildingSet extends Product
{
    // data members
    private $m_sortID;
    private $m_labelID;

    // constants
    public const PRICE_ARRAY = array(20, 50, 100, 200);
    public const PIECES_ARRAY = array(100, 250, 500, 1000);

    // constructor
    public function __construct($p_productno, $p_pName, $p_price, $p_minAge,
        $p_description, $p_isActive, $p_pieces, $p_themeID, $p_sortID, $p_labelID = NULL)
    {
        parent::__construct($p_productno, $p_pName, $p_price, $p_minAge,
            $p_description, $p_isActive, $p_pieces, $p_themeID);
        if (empty(self::check("m_sortID", $p_sortID)))
        {
            $this->m_sortID = $p_sortID;
        }
        else
        {
            $this->m_sortID = NULL;
        }
        if (is_null($p_labelID) || empty(self::check("m_labelID", $p_labelID)))
        {
            $this->m_labelID = $p_labelID;
        }
        else
        {
            $this->m_sortID = NULL;
        }
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        parent::_set($p_property, $p_value);
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_sortID":
                $this->m_sortID = $p_value;
                break;
            case "m_labelID":
                $this->m_labelID = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        $result = parent::__get($p_property);
        switch ($p_property)
        {
        case "m_sortID":
            $result = $this->m_sortID;
            break;
        case "m_labelID":
            $result = $this->m_labelID;
            break;
        }

        return $result;
    } // end function get

    /*
     * add the BuildingSet to the database
     * The BuildingSet will be added with category = 'sets' and isActive = true.
     * The function returns a numerical array('error message', 'primary key').
     * If the BuildingSet is not in the database, a non-empty error message is returned.
     */
    public function addToDB($connection)
    {
        /*if (empty($this->m_productno) || empty($this->m_pName) || empty($this->m_price)  || empty($this->m_minAge) 
            || empty($this->m_description) || empty($this->m_pieces) || empty($this->m_themeID) || empty($this->m_sortID))
        {
            $errMessage = "Product number, product name, price, minimum age, description, number of pieces
                themeID and sortID are required.";
            $primaryKey = NULL;
        }
        else
        {*/
            $errMessage = "";
            // Check if BuildingSet is not yet in the database
            list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
            if ($primaryKey === false)
            {
                // Check themeID, sortID and labelID
                $themeArray = self::getTheme($connection);
                $sortArray = self::getSort($connection);
                $labelArray = self::getLabel($connection);
                if (array_search($this->m_themeID, $themeArray['themeID']) !== false)
                {
                    if (array_search($this->m_sortID, $sortArray['sortID']) !== false)
                    {
                        if (!is_null($this->m_labelID) && (array_search($this->m_labelID, $labelArray['labelID']) === false))
                        {
                            $this->m_labelID = NULL;
                            $errMessage = "The label is not valid";
                        }
                    }
                    else
                    {
                        $errMessage = "The sortID is not valid";
                    }
                }
                else
                {
                    $errMessage = "The themeID is not valid";
                }
                // If no error message, building set can be added to database
                if ($errMessage === "")
                {
                    $query = "INSERT INTO product 
                        (productno, pName, price, minAge, description, isActive, category, pieces, themeID, sortID, labelID) 
                    VALUES (?, ?, ?, ?, ?, true, 'sets', ?, ?, ?, ?)";
                    try
                    {
                        if (($stmt = $connection->prepare($query)) === false)
                        {
                            throw new MySQLException("Preparation of query failed."); 
                        }
                        if (($stmt->bind_param('isdisiiii', $this->m_productno, $this->m_pName, $this->m_price,
                            $this->m_minAge, $this->m_description, $this->m_pieces, $this->m_themeID, $this->m_sortID, $this->m_label)) === false)
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
            else // BuildingSet is already in the database
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
        //}

        return array($errMessage, $primaryKey);
    } // end function addToDB

    /*
     * get the category of this BuildingSet
     */
    public function getCategory()
    {
        return "sets";
    } // end function getCategory

    /*
     * print this product
     * If shoppingbag === true, a button 'add to bag' is also printed
     */
    public function print($shoppingBag, $labelArray)
    {
        echo("\t\t\t\t<div class='product'>\n");
        if (!is_null($this->m_labelID))
        {
            $labelIndex = array_search($this->m_labelID, $labelArray['labelID']);
            if ($labelIndex !== false)
            {
                echo("\t\t\t\t\t<p class='label'>". $labelArray['lName'][$labelIndex] ."</p>\n");
            }
            else
            {
                echo("\t\t\t\t<p class='labelEmpty'>&nbsp;</p>\n");
            }
        }
        else
        {
            echo("\t\t\t\t<p class='labelEmpty'>&nbsp;</p>\n");
        }
        
        echo("\t\t\t\t\t<img src='../images/". $this->m_productno .".jpg' alt='image of building set' />\n");
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
     * get an array of all active BuildingSets ordered by productno
     */
    public static function getProducts($connection)
    {
        $buildingSetArray = array();
        $query = "SELECT * FROM product
            WHERE category = 'sets' AND isActive = true 
            ORDER BY productno";
        $result = $connection->queryResult($query);
        
        while ($row = $result->fetch_array())
        {
            $buildingSetArray[] = new BuildingSet($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID'], $row['sortID'], $row['labelID']);
        }
        return $buildingSetArray;
    } // end function getProducts

    /*
     * get an array of all BuildingSets ordered by productno
     */
    public static function getAllProducts($connection)
    {
        $buildingSetArray = array();
        $query = "SELECT * FROM product
            WHERE category = 'sets'  
            ORDER BY productno";
        $result = $connection->queryResult($query);
        
        while ($row = $result->fetch_array())
        {
            $buildingSetArray[] = new BuildingSet($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID'], $row['sortID'], $row['labelID']);
        }
        return $buildingSetArray;
    } // end function getAllProducts

    /*
     * get an array of BuildingSets from a MySQLi result set
     */
    public static function getProductsFromResultSet($result)
    {
        $buildingSetArray = array();
        
        while ($row = $result->fetch_array())
        {
            $buildingSetArray[] = new BuildingSet($row['productno'], $row['pName'], $row['price'],
                $row['minAge'], $row['description'], $row['isActive'], $row['pieces'],
                $row['themeID'], $row['sortID'], $row['labelID']);
        }
        return $buildingSetArray;
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
            WHERE product.category = 'sets'  AND isActive = true 
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
     * get an array of all sorts and their sortID
     */
    public static function getSort($connection)
    {
        $sortArray = array(
            'sortID'   => array(),
            'sName'     => array() 
        );
        $query = "SELECT DISTINCT sort.sortID, sort.sName 
            FROM sort INNER JOIN product 
            ON sort.sortID = product.sortID 
            WHERE product.category = 'sets'  AND isActive = true";
        $result = $connection->queryResult($query);

        while ($row = $result->fetch_array())
        {
            $sortArray['sortID'][] = $row['sortID'];
            $sortArray['sName'][] = $row['sName'];
        }

        return $sortArray;
    } // end function getSort

    /*
     * get an array of all labels and their labelID
     */
    public static function getLabel($connection)
    {
        $labelArray = array(
            'labelID'   => array(),
            'lName'     => array() 
        );
        $query = "SELECT DISTINCT label.labelID, label.lName 
            FROM label INNER JOIN product 
            ON label.labelID = product.labelID  
            WHERE product.category = 'sets' AND isActive = true 
            ORDER BY label.lName";
        $result = $connection->queryResult($query);

        while ($row = $result->fetch_array())
        {
            $labelArray['labelID'][] = $row['labelID'];
            $labelArray['lName'][] = $row['lName'];
        }

        return $labelArray;
    } // end function getLabel

    /*
     * get an array of all minAges
     */
    public static function getAge($connection)
    {
        $ageArray = array();
        $query = "SELECT DISTINCT minAge FROM product  
            WHERE category = 'sets' AND isActive = true 
            ORDER BY minAge";
        $result = $connection->queryResult($query);

        while ($row = $result->fetch_array())
        {
            $ageArray[] = $row['minAge'];
        }

        return $ageArray;
    } // end function getAge

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
            case "m_labelID":
                $query .= "labelID";
                $param = "i";
                break;
            case "m_sortID":
                $query .= "sortID";
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
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";

        if (empty($p_value) && $p_property !== 'm_label')
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            $errMessage = parent::check($p_property, $p_value);
            switch ($p_property)
            {
            case "m_sortID":
            case "m_labelID":
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
} // end class BuildingSet
?>
