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

require_once("../php/errorHandling.php");
require_once("../php/exceptionHandling.php");

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
        if (empty(self::check("m_firstname", $p_firstname)))
        {
            $this->m_firstname = $p_firstname;
        }
        else
        {
            $this->m_firstname = "";
        }
        if (empty(self::check("m_surname", $p_surname)))
        {
            $this->m_surname = $p_surname;
        }
        else
        {
            $this->m_surname = "";
        }
        if (empty(self::check("m_email", $p_email)))
        {
            $this->m_email = $p_email;
        }
        else
        {
            $this->m_email = "";
        }
        if (empty(self::check("m_password", $p_password)))
        {
            $this->m_password = hash(self::HASH, $p_password);
        }
        else
        {
            $this->m_password = "";
        }
        if (empty(self::check("m_userID", $p_userID)))
        {
            $this->m_userID = $p_userID;
        }
        else
        {
            $this->m_userID = NULL; // MariaDB: if auto_increment field is NULL, the value will automatically be incremented
        }
        if (empty(self::check("m_role", $p_role)))
        {
            $this->m_role = $p_role;
        }
        else
        {
            $this->m_role = "customer";
        }
        $this->m_isActive = $p_isActive;
        /*if (empty(self::check("m_isActive", $p_isActive)))
        {
            $this->m_isActive = $p_isActive;
        }
        else
        {
            $this->m_isActive = true;
        }*/
    } // end constructor

    // set property to value
    public function __set($p_property, $p_value)
    {
        if (empty(self::check($p_property, $p_value)))
        {
            switch ($p_property)
            {
            case "m_firstname":
                $this->m_firstname = $p_value;
                break; 
            case "m_surname":
                $this->m_surname = $p_value;
                break;
            case "m_email":
                $this->m_email = $p_value;
                break;
            case "m_password":
                $this->m_password = hash(self::HASH, $p_value);
                break;
            case "m_userID":
                $this->m_userID = $p_value;
                break;
            case "m_role":
                $this->m_role = $p_value;
                break;
            case "m_isActive":
                $this->m_isActive = $p_value;
                break;
            }
        }
    } // end function set

    // get property value
    public function __get($p_property)
    {
        switch ($p_property)
        {
        case "m_firstname":
            $result = $this->m_firstname;
            break;
        case "m_surname":
            $result = $this->m_surname;
            break;
        case "m_email":
            $result = $this->m_email;
            break;
        case "m_password":
            $result = $this->m_password;
            break;
        case "m_userID":
            $result = $this->m_userID;
            break;
        case "m_role":
            $result = $this->m_role;
            break;
        case "m_isActive":
            $result = $this->m_isActive;
            break;
        }

        return $result;
    } // end function get

    /*
     * add the RegisteredUser to the database
     * The user will be added with role = 'customer' and isActive = true.
     * The function returns a numerical array('error message', 'primary key').
     * If the user is not added to the database, a non-empty error message is returned.
     */
    public function addToDB($connection)
    {
        if (empty($this->m_firstname) || empty($this->m_surname)  || empty($this->m_email) || empty($this->m_password))
        {
            $errMessage = "First name, surname, email and password are required.";
            $primaryKey = NULL;
        }
        else
        {
            // Check if user is not yet in the database
            list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
            if ($primaryKey === false)
            {
                $query = "INSERT INTO registeredUser (firstname, surname, email, passw, role, isActive) 
                    VALUES (?, ?, ?, ?, 'customer', true)";
                try
                {
                    if (($stmt = $connection->prepare($query)) === false)
                    {
                        throw new MySQLException("Preparation of query failed."); 
                    }
                    if (($stmt->bind_param('ssss', $this->m_firstname, $this->m_surname,
                            $this->m_email, $this->m_password)) === false)
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
            else // User with this email address is already in the database
            {
                if ($isActive == false) // The admin has placed the user on non-active
                {
                    $errMessage = "Please contact the Lego Shop administrator for your registration.";
                }
                else
                {
                    $errMessage = "A user with e-mail ". $this->m_email ." is already registered.";
                }
            }
        }

        return array($errMessage, $primaryKey);
    } // end function addToDB

    // Set this RegisteredUser as non-active in the database
    public function setNonActive($connection)
    {
        // Check if user is in the database
        list($primaryKey, $isActive) =  $this->getPrimaryKey($connection);
        if ($primaryKey !== false)
        {
            $query = "UPDATE registeredUser SET isActive = false WHERE m_userID = ?";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('i', $this->m_userID)) === false)
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
    } // end function setNonActive

    /*
     * check if value is valid for property
     * If the value is not valid for the property, a non-empty error message is returned.
     */
    public static function check($p_property, $p_value)
    {
        $errMessage = "";

        if (empty($p_value) && $p_property != 'm_isActive')
        {
            $errMessage = ucfirst($p_property) . " is required";
        }
        else
        {
            switch ($p_property)
            {
            case "m_firstname":
            case "m_surname":
                if (strlen($p_value) < self::MIN_NAME)
                {
                    $errMessage = "At least ". self::MIN_NAME ." characters required";
                }
                elseif (strlen($p_value) > self::MAX_NAME)
                {
                    $errMessage = "Maximum ". self::MAX_NAME ." characters allowed";
                }
                break;
            case "m_email":
                if (filter_var($p_value, FILTER_VALIDATE_EMAIL) === false)
                {
                    $errMessage = "Invalid e-mail format";
                }
                break;
            case "m_password":
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
            case "m_userID":
                if (filter_var($p_value, FILTER_VALIDATE_INT) === false)
                {
                    $errMessage = "Invalid integer input";
                }
                elseif ($p_value < 0)
                {
                    $errMessage = "Has to be greater than or equal to 0";
                }
                break;
            case "m_role":
                if (!in_array($p_value, self::ROLES))
                {
                    $errMessage = "Has to be customer or admin";
                }
                break;
            case "m_isActive":
                if ($p_value !==0 && $p_value !== 1 && filter_var($p_value, FILTER_VALIDATE_BOOLEAN) === false)
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
    public static function checkLogin($p_email, $p_password, $connection)
    {
        $errMessage = "The email you entered cannot be identified";
        $primaryKey = false;
        $firstname = $role = $passw = NULL;
        $p_password = hash(self::HASH, $p_password);

        $query = "SELECT userID, firstname, role, passw FROM registeredUser
            WHERE email=? AND isActive=true";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('s', $p_email)) === false)
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
        $stmt->bind_result($primaryKey, $firstname, $role, $passw);
        while ($stmt->fetch());
        if (!is_null($firstname))
        {
            if (!is_null($passw) && $passw === $p_password)
            {
                $errMessage = "";
            }
            else
            {
                $errMessage = "The password you entered was incorrect";
            }
        }
        $stmt->close();

        return array($errMessage, $primaryKey, $firstname, $role);
    } // end function checkLogin

    // Print the invoice addres of the user with the given userID
    // returns the custAddressID of the invoice address
    public static function printFactAddress($userID, $connection)
    {

        $query = "SELECT ru.firstname, ru.surname, ca.custAddressID,
                a.street, a.hNumber, a.box, a.postalCode, a.city, a.country
            FROM registeredUser ru
                INNER JOIN customerAddress ca
                ON ru.userID = ca.userID
                INNER JOIN address a
                ON ca.addressID = a.addressID
            WHERE ru.userID = ". $userID ."
                AND ca.isActive = true
                AND ca.isInvoice = true;";
        $result = $connection->queryResult($query);
        while ($row = $result->fetch_array())
        {
            echo("\t\t\t\t<p class='bold'>". htmlspecialchars($row['firstname']) ." ". htmlspecialchars($row['surname']) ."</p>\n");
            echo("\t\t\t\t<p>". htmlspecialchars($row['street']) ." ". htmlspecialchars($row['hNumber']) ." ". (is_null($row['box'])? "" : htmlspecialchars($row['box'])) ."</p>\n");
            echo("\t\t\t\t<p>". htmlspecialchars($row['postalCode']) ." ". htmlspecialchars($row['city']) ."</p>\n");
            echo("\t\t\t\t<p>". htmlspecialchars($row['country']) ."</p>\n");
            $custAddressID = $row['custAddressID'];
        }

        return $custAddressID;
    } // end function printFactAddress

    // Print the shipping addresses of the user with the given userID
    public static function printShipAddress($userID, $connection)
    {
        $query = "SELECT ru.firstname, ru.surname, ca.custAddressID, ca.tao,
                a.street, a.hNumber, a.box, a.postalCode, a.city, a.country
            FROM registeredUser ru
                INNER JOIN customerAddress ca
                ON ru.userID = ca.userID
                INNER JOIN address a
                ON ca.addressID = a.addressID
            WHERE ru.userID = ". $userID ."
                AND ca.isActive = true
                AND ca.isInvoice = false;";
        $result = $connection->queryResult($query);
        echo("\t\t\t\t\t<p><input class='radio' type='radio' name='shipAddress' value='-1' checked>Same as invoice address</p>\n");
        while ($row = $result->fetch_array())
        {
            echo("\t\t\t\t<p class='bold'><input class='radio' type='radio' name='shipAddress' value='". $row['custAddressID'] ."'>");
            
            if (is_null($row['tao'])) echo(htmlspecialchars($row['firstname']) ." ". htmlspecialchars($row['surname']));
            else echo($row['tao']);
            echo("</p>\n");
            echo("\t\t\t\t\t<p class='marginLeft'>". htmlspecialchars($row['street']) ." ". htmlspecialchars($row['hNumber']) . (is_null($row['box'])? "" : " box ". htmlspecialchars($row['box'])) ."</p>\n");
            echo("\t\t\t\t\t<p class='marginLeft'>". htmlspecialchars($row['postalCode']) ." ". htmlspecialchars($row['city']) ."</p>\n");
            echo("\t\t\t\t\t<p class='marginLeft'>". htmlspecialchars($row['country']) ."</p>\n");
        }
    } // end function printShipAddress

    // Get an array of all RegisteredUsers
    public static function getAllUsers($connection)
    {
        $usersArray = array();
        $query = "SELECT * FROM registeredUser;";
        $result = $connection->queryResult($query);
        while($row = $result->fetch_array())
        {   
            $usersArray[] = new RegisteredUser($row['firstname'], $row['surname'], $row['email'],
                $row['passw'], $row['userID'], $row['role'], (int)$row['isActive']);
        }
        $result->close();

        return $usersArray;
    } // end function getAllUsers

    // Change the role of the user with the given userID
    // A non-empty error message is returned if the role has not been changed
    public static function changeRole($userID, $connection)
    {
        $role = "";
        $errMessage = "";
        $query = "SELECT role FROM registeredUser WHERE userID = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('i', $userID)) === false)
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

        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();
        if (is_null($role))
        {
            $errMessage = "The user with the given userID could not be found.";
        }
        else
        {
            if ($role == 'customer') $role = 'admin';
            else $role = 'customer';
            $query = "UPDATE registeredUser SET role = '". $role ."' WHERE userID = ?";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('i', $userID)) === false)
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
    } // end function changeRole

    // change the status of the user with the given userID
    // If the status could not be changed, a non-empty error message is returned.
    public static function changeStatus($userID, $connection)
    {
        $isActive = 0;
        $errMessage = "";
        $query = "SELECT isActive FROM registeredUser WHERE userID = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('i', $userID)) === false)
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
            $errMessage = "The user with the given userID could not be found.";
        }
        else
        {
            $isActive = ($isActive ? 0 : 1);
            $stmt->close();
            $query = "UPDATE registeredUser SET isActive = ". $isActive ." WHERE userID = ?";
            try
            {
                if (($stmt = $connection->prepare($query)) === false)
                {
                    throw new MySQLException("Preparation of query failed."); 
                }
                if (($stmt->bind_param('i', $userID)) === false)
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
    /*
     * get the primary of this RegisteredUser
     * Function getPrimaryKey returns an array of the primary key and the value
     * of the field isActive.
     * If this RegisteredUser is not found in the database, false is returned
     * as primary key.
     */
    private function getPrimaryKey($connection)
    {
        $query = "SELECT userID, isActive FROM registeredUser WHERE email = ?";
        try
        {
            if (($stmt = $connection->prepare($query)) === false)
            {
                throw new MySQLException("Preparation of query failed."); 
            }
            if (($stmt->bind_param('s', $this->m_email)) === false)
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
} // end class RegisteredUser
?>