<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Page to add shipping address
 */

    session_start();
    require_once("functions.php");
    require_once("../classes/Address.php");
    require_once("../classes/Connection.php");
    require_once("../classes/CustomerAddress.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");

    createHead(true, "Legoshop | Add address", ['checkout'], NULL);
    // Check user role and shopping bag
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin")
        && array_sum($_SESSION['bag']['amount']) != 0)
    {
        // create database connection
        $connection = new Connection();

        // Define variables and set to empty values
        $tao = $street = $hNumber = $box = $postalCode = $city = $country = "";
        $taoErr = $streetErr = $hNumberErr = $boxErr = $postalCodeErr = $cityErr = $countryErr = "";
        // Get possible countries to ship to
        $countryArr = Address::getShipCountries($connection);

        // Form validation
        if (isset($_POST['addAddress']))
        {
            // Check tao
            $tao = cleanInput($_POST['tao']);
            if (!empty($taoErr = CustomerAddress::check("m_tao", $tao)))
            {
                $tao = "";
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
            if (empty($taoErr) && empty($streetErr) && empty($hNumberErr) && empty($boxErr)
                && empty($postalCodeErr) && empty($cityErr) && empty($countryErr))
            {
                $address = new Address($street, $hNumber, $postalCode, $city, $country, $box);
                list($addressErr, $addressID) = $address->addToDB($connection);
                if (empty($addressErr))
                {
                    $customerAddress = new CustomerAddress((int)$_SESSION['userID'], (int)$addressID, true, false, $tao);
                    list($customerAddressErr, $customerAddressID) = $customerAddress->addToDB($connection);
                    if (empty($customerAddressErr))
                    {
                        // Go back to checkout
                        header("Location: checkout.php");
                        die();
                    }
                    else
                    {
                        // show error page
                        createErrorPage(["The shipping address could not be added."]);
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
            unset($_POST['addAddress']);
        }

        // Show form
        createHead(true, "Legoshop | Add address", ["register"], ["addAddress"]);
        createHeader(true, $_SESSION['firstname'], $_SESSION['role'] === "admin");
?>
        <div class="center">
            <h1>Add a shipping address</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <form id="inputform" action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post" onSubmit="return checkAddress()">
                <p><label for="tao">To the attention off:</label></p>
                <p>
                    <input class="textinput" id="tao" type="text" name="tao" value="<?php echo(htmlspecialchars($tao)); ?>" autofocus />
                    <span id="taoErr" class="red"> <?php echo($taoErr); ?></span>
                </p>
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
                    <input class="button" type="submit" name="addAddress" value="Add shipping address" />
                    <a class="button" href="checkout.php">Cancel</a>
                    <input class="button" type="reset" value="Reset">
                    <p class="spacer"></p>
                </div>
            </form>
        </div> <!-- end center -->
<?php
        // close database connection
        $connection->close();
         
        createFooter(true);
     }
     else
     {
         // Session variable is not set, role does not comply or shopping bag is empty: user should not be on this page
         header("Location: ../index.php");
     }
?>