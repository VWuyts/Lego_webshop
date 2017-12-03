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
    if (isset($_SESSION['role']) && $_SESSION['role'] === "regular")
    {
        require_once("functions.php");
        require_once("../classes/RegisteredUser.php");

        createHead(true, "Legoshop | login", ["login"], ["login"]);
        createHeader(true, NULL, false);

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
                if(!empty($passwErr = RegisteredUser::check("password", $passw)))
                {
                    $passw = "";
                    $err = "The password you entered was incorrect";
                }
                else
                {
                    // Check database
                    list($err, $userID, $firstname, $role) = RegisteredUser::checkLogin($email, $passw, $config);
                    if ($err === "")
                    {
                        $_SESSION['userID'] = $userID;
                        $_SESSION['firstname'] = $firstname;
                        $_SESSION['role'] = $role;

                        header("Location: ../index.php");
                        die();
                    }
                }
            }
            unset($_POST['submitLogin']);
        }
        
?>
    <div class="center">
        <h1>Login to your Lego account</h1>
    </div> <!-- end center -->
    <hr />
    <div id='login'>
        <p id='err'>&nbsp;<?php echo($err); ?></p>
        <form action='<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>' method='post' onSubmit='return checkLogin()'>
            <p><label for='email'>E-mail:</label></p>
		    <p><input class='textinput' id='email' type='text' name='email' /></p>
		    <p class='topmargin'><label for='passw'>Password:</label></p>
		    <p><input class='textinput' id='passw' type='password' name='passw' />
		    <p>
		        <input class='button' type='submit' name='submitLogin' value='Log in' />
            </p>
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
