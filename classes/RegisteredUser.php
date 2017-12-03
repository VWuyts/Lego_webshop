<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class RegisteredUser
 */

require_once("Connection.php");
require_once("../php/errorhandling.php");

class RegisteredUser
{
    // member variables
    private $m_firstname;
    private $m_surname;
    private $m_email;
    private $m_password;
    private $m_userID;
    private $m_role;
    private $m_isActive;

    // constants
    private const HASH = "SHA256";
    private const MIN_NAME = 2;
    private const MIN_PASSW = 8;
    private const MAX_NAME = 50;
    private const ROLES = array("customer", "admin");

    // constructor
    public function __construct($p_firstname, $p_surname, $p_email, $p_password,
        $p_userID = NULL, $p_role = "customer", $p_isActive = true)
    {
        if (empty(self::check("firstname", $p_firstname)))
        {
            $this->m_firstname = $p_firstname;
        }
        else
        {
            $this->m_firstname = "";
        }
        if (empty(self::check("surname", $p_surname)))
        {
            $this->m_surname = $p_surname;
        }
        else
        {
            $this->m_surname = "";
        }
        if (empty(self::check("email", $p_email)))
        {
            $this->m_email = $p_email;
        }
        else
        {
            $this->m_email = "";
        }
        if (empty(self::check("password", $p_password)))
        {
            $this->m_password = hash(self::HASH, $p_password);
        }
        else
        {
            $this->m_password = "";
        }
        if (empty(self::check("userID", $p_userID)))
        {
            $this->m_userID = $p_userID;
        }
        else
        {
            $this->m_userID = NULL; // MariaDB: if auto_increment field is NULL, the value will automatically be incremented
        }
        if (empty(self::check("role", $p_role)))
        {
            $this->m_role = $p_role;
        }
        else
        {
            $this->m_role = "customer";
        }
        if (empty(self::check("isActive", $p_isActive)))
        {
            $this->m_isActive = $p_isActive;
        }
        else
        {
            $this->m_isActive = true;
        }
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
                case "firstname":
                    $this->m_firstname = $p_value;
                    break; 
                case "surname":
                    $this->m_surname = $p_value;
                    break;
                case "email":
                    $this->m_email = $p_value;
                    break;
                case "password":
                    $this->m_password = hash(self::HASH, $p_value);
                    break;
                case "userID":
                    $this->m_userID = $p_value;
                    break;
                case "role":
                    $this->m_role = $p_value;
                    break;
                case "isActive":
                    $this->m_isActive = $p_value;
                    break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        switch ($p_property) {
            case "firstname":
                $result = $this->m_firstname;
                break;
            case "surname":
                $result = $this->m_surname;
                break;
            case "email":
                $result = $this->m_email;
                break;
            case "password":
                $result = $this->m_password;
                break;
            case "userID":
                $result = $this->m_userID;
                break;
            case "role":
                $result = $this->m_role;
                break;
            case "isActive":
                $result = $this->m_isActive;
                break;
        }
    } // end function get

    /*
     * add the RegisteredUser to the database
     * The user will be added with role = 'customer' and isActive = true.
     * The function returns a numerical array('error message', 'primary key').
     * If the user is not in the database, a non-empty error message is returned.
     */
    public function addToDB($config)
    {
        $connection = new Connection($config);
        if (empty($this->m_firstname) || empty($this->m_surname)  || empty($this->m_email) || empty($this->m_password))
        {
            $errMessage = "First name, surname, email and password are required.";
            $primaryKey = NULL;
        }
        else
        {
            list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
            
            if ($primaryKey === false)
            {
                $query = "INSERT INTO registeredUser (firstname, surname, email, passw, role, isActive) ".
                    "VALUES ('". $this->m_firstname ."', '". $this->m_surname ."', '".
                             $this->m_email ."', '". $this->m_password ."', 'customer', true);";
                if ($connection->queryBool($query))
                {
                    $errMessage = "";
                    list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
                }
            }
            else
            {
                if ($isActive == false)
                {
                    $query = "UPDATE registeredUser SET isActive=true WHERE userID=". $primaryKey .";";
                    $connection->queryBool($query);
                    $errMessage = "";
                }
                $errMessage = "A user with e-mail ". $this->m_email ." is already registered.";
            }
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

        if (empty($p_value))
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            switch ($p_property)
            {
                case "firstname":
                case "surname":
                    if (strlen($p_value) < self::MIN_NAME)
                    {
                        $errMessage = "At least ". self::MIN_NAME ." characters required";
                    }
                    elseif (strlen($p_value) > self::MAX_NAME)
                    {
                        $errMessage = "Maximum ". self::MAX_NAME ." characters allowed";
                    }
                    break;
                case "email":
                    if (filter_var($p_value, FILTER_VALIDATE_EMAIL) === false)
                    {
                        $errMessage = "Invalid e-mail format";
                    }
                    break;
                case "password":
                    if (strlen($p_value) < self::MIN_PASSW)
                    {
                        $errMessage = "At least ". self::MIN_PASSW ." characters required";
                    }
                    elseif (preg_match('/[A-Z]/', $p_value) === 0)
                    {
                        $errMessage = "At least 1 upper case letter required";
                    }
                    elseif(preg_match('/[a-z]/', $p_value) === 0)
                    {
                        $errMessage = "At least 1 lower case letter required";
                    }
                    elseif(preg_match('/[0-9]/', $p_value) === 0)
                    {
                        $errMessage = "At least 1 number required";
                    }
                    break;
                case "userID":
                    if ($p_value < 0)
                    {
                        $errMessage = "Has to be greater than or equal to 0";
                    }
                    break;
                case "role":
                    if (!in_array($p_value, self::ROLES))
                    {
                        $errMessage = "Has to be customer or admin";
                    }
                    break;
                case "isActive":
                    if (!is_bool($p_value))
                    {
                        $errMessage = "Has to be true or false";
                    }
                    break;
            }
        }
        
        return $errMessage;
    } // end function check

    /*
     * check if email and password are a valid login
     * Function checkLogin returns an array with the error message and the primary key,
     * first name and role of the registered user.
     * If the given email and password do not match a registered user in the database,
     * a non-empty error message is returned.
     */
    public static function checkLogin($p_email, $p_password, $config)
    {
        $errMessage = "The email you entered cannot be identified";
        $primaryKey = false;
        $firstname = $role = $passw = NULL;
        $p_password = hash(self::HASH, $p_password);

        $query = "SELECT * FROM registeredUser WHERE email='". $p_email ."' AND isActive=true;";
        $connection = new Connection($config);
        $result = $connection->queryResult($query);
        while ($row = $result->fetch_array())
        {
            $primaryKey = $row['userID'];
            $firstname = $row['firstname'];
            $role = $row['role'];
            $passw = $row['passw'];
        }
        $result->close();
        $connection->close();
        if (!is_null($passw) && $passw === $p_password)
        {
            $errMessage = "";
        }
        else
        {
            $errMessage = "The password you entered was incorrect";
        }

        return array($errMessage, $primaryKey, $firstname, $role);
    } // end function checkLogin

    /*
     * check for duplicate users in database
     * This function checks if the e-mail address is not yet included in the database.
     */
    /*private function isDuplicate($connection)
    {
        $query = "SELECT * FROM registeredUser WHERE email = '". $this->m_email ."';";
        if (($connection->queryNoRows($query)) === 0)
        {
            return false;
        }

        return true;
    }*/ // end function isDuplicate

    /*
     * get the primary of this RegisteredUser
     * Function getPrimaryKey returns an array of the primary key and the value
     * of the field isActive.
     * If this RegisteredUser is not found in the database, false is returned
     * as primary key
     */

    private function getPrimaryKey($connection)
    {
        $query = "SELECT userID, isActive FROM registeredUser WHERE email='". $this->m_email ."';";
        $result = $connection->queryResult($query);
        $noRows = $result->num_rows;
        if ($noRows === 0)
        {
            $result->close();
            return false;
        }
        $row = $result->fetch_array();
        $primaryKey = $row['userID'];
        $isActive = $row['isActive'];
        $result->close();

        return array($primaryKey, $isActive);
    } // end function getPrimaryKey

} // end class RegisteredUser
?>