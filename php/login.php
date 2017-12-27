<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Login page
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/RegisteredUser.php");
    require_once("../classes/Connection.php");

    // check if user is not already logged on
    if (!isset($_SESSION['role']))
    {
        createHead(true, "Legoshop | login", ["login"], ["login"]);
        createHeader(true, NULL, false);

        // Create db connection
        $connection = new Connection();

        // Define variables and set to empty value
        $email = $passw = "";
        $err = "";
        $userID = $firstname = $role = "";

        // Form validation
        if (isset($_POST['submitLogin']))
        {
            // Check email
            $email = cleanInput($_POST['email']);
            if (!empty($emailErr = RegisteredUser::check("email", $email)))
            {
                $email="";
                $err = "The email you entered cannot be identified";
            }
            else
            {
                // Check password
                $passw = trim($_POST['passw']);
                // If the password does not comply, there is no need to check the database
                if(!empty($passwErr = RegisteredUser::check("password", $passw)))
                {
                    $passw = "";
                    $err = "The password you entered was incorrect";
                }
                else
                {
                    // Check database
                    list($err, $userID, $firstname, $role) = RegisteredUser::checkLogin($email, $passw, $connection);
                    if ($err === "")
                    {
                        $_SESSION['userID'] = $userID;
                        $_SESSION['firstname'] = $firstname;
                        $_SESSION['role'] = $role;
                        $_SESSION['bag'] = array(
                            'productno' => array(),
                            'amount' => array(),
                            'pName' => array(),
                            'price' => array(),
                        );

                        header("Location: ../index.php");
                        die();
                    }
                }
            }
            unset($_POST['submitLogin']);

            // close db connection
            $connection->close();
        }
        
?>
    <div class="center">
        <h1>Sign in to your Lego account</h1>
    </div> <!-- end center -->
    <hr />
    <div id='login'>
        <p id='err'><?php echo($err); ?></p>
        <form action='<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>' method='post' onSubmit='return checkLogin()'>
            <p><label for='email'>E-mail:</label></p>
		    <p><input class='textinput' id='email' type='text' name='email' autofocus /></p>
		    <p class='topmargin'><label for='passw'>Password:</label></p>
		    <p><input class='textinput' id='passw' type='password' name='passw' />
		    <p><input class='button' type='submit' name='submitLogin' value='Log in' /></p>
            <p class="spacer"></p>
        </form>
    </div> <!-- end login -->
<?php
        createFooter(true);
    }
    else
    {
        // User is already logged on and should not be on this page
        header("Location: ../index.php");
    }
?>
