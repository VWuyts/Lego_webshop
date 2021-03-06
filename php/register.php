<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Registration page
 */

    session_start();
    require_once("functions.php");
    require_once("../classes/Address.php");
    require_once("../classes/Connection.php");
    require_once("../classes/CustomerAddress.php");
    require_once("../classes/RegisteredUser.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");

    // check if user is admin or not already logged on
    if (!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'))
    {
        // Create db connection
        $connection = new Connection();

        // Define variables and set to empty values
        $firstname = $surname = $email = $passw = "";
        $firstnameErr = $surnameErr = $emailErr = $passwErr = "";
        $street = $hNumber = $box = $postalCode = $city = $country = "";
        $streetErr = $hNumberErr = $boxErr = $postalCodeErr = $cityErr = $countryErr = "";
        // Get possible countries to ship to
        $countryArr = Address::getShipCountries($connection);

        // Form validation
        if (isset($_POST['register']))
        {
            // Check firstname
            $firstname = cleanInput($_POST['firstname']);
            if (!empty($firstnameErr = RegisteredUser::check("m_firstname", $firstname)))
            {
                $firstname = "";
            }
            // Check surname
            $surname = cleanInput($_POST['surname']);
            if (!empty($surnameErr = RegisteredUser::check("m_surname", $surname)))
            {
                $surname = "";
            }
            // Check email
            $email = cleanInput($_POST['email']);
            if (!empty($emailErr = RegisteredUser::check("m_email", $email)))
            {
                $email="";
            }
            // Check password
            $passw = trim($_POST['passw']); // password will be hashed
            if(!empty($passwErr = RegisteredUser::check("m_password", $passw)))
            {
                $passw = "";
            }
            // Check street
            $street = cleanInput($_POST['street']);
            if (!empty($streetErr = Address::check("m_street", $street)))
            {
                $street = "";
            }
            // Check hNumber
            $hNumber = cleanInput($_POST['hNumber']);
            if (!empty($hNumberErr = Address::check("m_hNumber", $hNumber)))
            {
                $hNumber = "";
            }
            // Check box
            $box = cleanInput($_POST['box']);
            if (!empty($boxErr = Address::check("m_box", $box)))
            {
                $box = NULL;
            }
            // Check postalCode
            $postalCode = cleanInput($_POST['postalCode']);
            if (!empty($postalCodeErr = Address::check("m_postalCode", $postalCode)))
            {
                $postalCode = "";
            }
            // Check city
            $city = cleanInput($_POST['city']);
            if (!empty($cityErr = Address::check("m_city", $city)))
            {
                $city = "";
            }
            // Check country
            $country = cleanInput($_POST['country']);
            if (!empty($countryErr = Address::check("m_country", $country)))
            {
                $country = "";
            }

            // If there are no errors, add user and address to database.
            if (empty($firstnameErr) && empty($surnameErr) && empty($emailErr) && empty($passwErr)
                && empty($streetErr) && empty($hNumberErr) && empty($boxErr) && empty($postalCodeErr)
                && empty($cityErr) && empty($countryErr))
            {
                $address = new Address($street, $hNumber, $postalCode, $city, $country, $box);
                list($addressErr, $addressID) = $address->addToDB($connection);
                if (empty($addressErr))
                {
                    $registeredUser = new RegisteredUser($firstname, $surname, $email, $passw);
                    list($registerErr, $userID) = $registeredUser->addToDB($connection);
                    if (empty($registerErr))
                    {
                        $customerAddress = new CustomerAddress((int)$userID, (int)$addressID, true, true);
                        list($customerAddressErr, $customerAddressID) = $customerAddress->addToDB($connection);
                        if (empty($customerAddressErr))
                        {
                            // Show message page
                            createMessagePage(["Your Lego account has been created.", "You can now sign in."],
                                null, false, "../index.php", "Back to home page");
                            die();
                        }
                        else
                        {
                            // User set to non-active, as registration is not complete
                            $registeredUser->setNonActive($connection);
                            // show error page
                            createErrorPage(["The registration is not complete.", "Please contact the Legoshop administrator."]);
                            die();
                        }
                    }
                    else
                    {
                        // show error page
                        createErrorPage([$registerErr]);
                        die();
                    }
                }
                else
                {
                    // show error page
                    createErrorPage([$addressErr]);
                    die();
                }
            }
            unset($_POST['register']);
        }

        // close db connection
        $connection->close();

        // Show form
        createHead(true, "Legoshop | register", ["register"], ["register"]);
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') createHeader(true, $_SESSION['firstname'], true);
        else createHeader(true, NULL, false);
?>
        <div class="center">
            <h1>Create a Lego account</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <form id="inputform" action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post" onSubmit="return checkRegister()">
                <p><label for="firstname">First name:</label></p>
                <p>
                    <input class="textinput" id="firstname" type="text" name="firstname" value="<?php echo(htmlspecialchars($firstname)); ?>" autofocus />
                    <span id="firstnameErr" class="red">* <?php echo($firstnameErr); ?></span>
                </p>
                <p class="topmargin"><label for="surname">Surname:</label></p>
                <p>
                    <input class="textinput" id="surname" type="text" name="surname" value="<?php echo(htmlspecialchars($surname)); ?>" />
                    <span id="surnameErr" class="red">* <?php echo($surnameErr); ?></span>
                </p>
                <p class="topmargin"><label for="email">E-mail address:</label></p>
                <p>
                    <input class="textinput" id="email" type="text" name="email" value="<?php echo(htmlspecialchars($email)); ?>" />
                    <span id="emailErr" class="red">* <?php echo($emailErr); ?></span>
                </p>
                <p class="topmargin"><label for="passw">Password:</label></p>
                <p>
                    <input class="textinput" id="passw" type="password" name="passw" />
                    <span id="passwErr" class="red">* <?php echo($passwErr); ?></span>
                </p>
                <p class="smallfont">Use at least 8 characters, containing 1 number, 1 lower and 1 upper case letter.</p>
                <p class="topmargin"><label for="street">Street:</label></p>
                <p>
                    <input class="textinput" id="street" type="text" name="street" value="<?php echo(htmlspecialchars($street)); ?>" />
                    <span id="streetErr" class="red">* <?php echo($streetErr); ?></span>
                </p>
                <p class="topmargin"><label for="hNumber">Number:</label></p>
                <p>
                    <input class="textinput" id="hNumber" type="text" name="hNumber" value="<?php echo(htmlspecialchars($hNumber)); ?>" />
                    <span id="hNumberErr" class="red">* <?php echo($hNumberErr); ?></span>
                </p>
                <p class="topmargin"><label for="box">Box:</label></p>
                <p>
                    <input class="textinput" id="box" type="text" name="box" value="<?php echo(htmlspecialchars($box)); ?>" />
                    <span id="boxErr" class="red"><?php echo($boxErr); ?></span>
                </p>
                <p class="topmargin"><label for="postalCode">Postal code:</label></p>
                <p>
                    <input class="textinput" id="postalCode" type="text" name="postalCode" value="<?php echo(htmlspecialchars($postalCode)); ?>" />
                    <span id="postalCodeErr" class="red">* <?php echo($postalCodeErr); ?></span>
                </p>
                <p class="topmargin"><label for="city">City:</label></p>
                <p>
                    <input class="textinput" id="city" type="text" name="city" value="<?php echo(htmlspecialchars($city)); ?>" />
                    <span id="cityErr" class="red">* <?php echo($cityErr); ?></span>
                </p>
                <p class="topmargin"><label for="country">Country:</label></p>
                <p>
                    <select class="textinput" name="country" id="country">
                        <?php
                            for ($i = 0; $i < count($countryArr); $i++)
                            { 
                                echo(($i > 0 ? "\t\t\t\t\t" : "") ."<option value='". $countryArr[$i]."'");
                                echo($countryArr[$i] === $country ? " selected" : "");
                                echo(">". $countryArr[$i] ."</option>\n");
                            }
                        ?>
                    </select>
                    <span id="countryErr" class="red">* <?php echo($countryErr); ?></span>
                </p>
                <div class="buttonbox">
                    <input class="button" type="submit" name="register" value="Register" />
                    <a class="button" href="home.php">Cancel</a>
                    <input class="button" type="reset" value="Reset">
                    <p class="spacer"></p>
                </div>
            </form>
        </div> <!-- end center -->
<?php
        createFooter(true);
    }
    else
    {
        // User should not be on this page
        header("Location: ../index.php");
    }
?>