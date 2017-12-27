<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Checkout page 2
 */

    require_once("../classes/Orders.php");
    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/RegisteredUser.php");

    createHead(true, "Legoshop | Checkout", ['checkout'], NULL);
    // Check user role to create appropriate header and check session variable
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin")
        && isset($_SESSION['order']))
    {
        createHeader(true, "'".$_SESSION['firstname']."'", $_SESSION['role'] === "admin");

        // create database connection
        $connection = new Connection();

        // variables
        $totalPrice = $_SESSION['total'];
        list($costID, $shippingCost) = Orders::getShipCost($_SESSION['order']->m_shipAddressID, $totalPrice, $connection);

        // process putOrder
        if (isset($_POST['putOrder']))
        {
            $orders = $_SESSION['order'];
            $orders->__set('m_shipCostID', $costID);
            list($errMessage, $primaryKey) = $orders->addToDB($connection, $_SESSION['bag']);
            if ($errMessage == "")
            {
                // reset shopping bag
                for ($i = 0; $i < count($_SESSION['bag']['productno']); $i++)
                {
                    $_SESSION['bag']['productno'][$i] = NULL;
                    $_SESSION['bag']['amount'][$i] = 0;
                    $_SESSION['bag']['pName'][$i] = NULL;
                    $_SESSION['bag']['price'][$i] = NULL;
                }
                createMessagePage(['Your order has been placed.', 'Thank you for shopping at the Lego Shop'],
                    NULL, $_SESSION['role'] === "admin", "../index.php", "Back to home page");
                die();
            }
            else
            {
                createErrorPage(['Your order could not be processed.', 'Please contact the Lego Shop administrator.']);
                die();
            }
        }
?>
        <div class="center">
            <h1>Checkout</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
        <?php
            echo("\t\t\t<form action='". $_SERVER['PHP_SELF'] ."' method='post'>\n");
                echo("\t<table>\n");
                echo("\t\t\t\t<tr>\n");
                echo("\t\t\t\t\t<th colspan='2'>Product</th>\n");
                echo("\t\t\t\t\t<th>Quantity</th>\n");
                echo("\t\t\t\t\t<th>Price</th>\n");
                echo("\t\t\t\t\t<th>Subtotal</th>\n");
                echo("\t\t\t\t</tr>\n");
                for ($i = 0; $i < count($_SESSION['bag']['productno']); $i++)
                {
                    $productno = $_SESSION['bag']['productno'][$i];
                    if (!is_null($productno))
                    {
                        $amount = $_SESSION['bag']['amount'][$i];
                        if (is_null($_SESSION['bag']['pName'][$i]))
                        {
                            list($_SESSION['bag']['pName'][$i], $_SESSION['bag']['price'][$i]) =
                                Product::getInfo($productno, $connection);
                        }
                        $pName = $_SESSION['bag']['pName'][$i];
                        $price = $_SESSION['bag']['price'][$i];
                        echo("\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t<td>". $productno ."</td>\n");
                        echo("\t\t\t\t\t<td>". htmlspecialchars($pName) ."</td>\n");
                        echo("\t\t\t\t\t<td class='tdCenter'>\n");
                        echo("\t\t\t\t\t\t ". $amount ." \n");
                        echo("\t\t\t\t\t</td>\n");
                        $subtotal = $amount * $price;
                        echo("\t\t\t\t\t<td class='right'>". $price ." &euro;</td>\n");
                        echo("\t\t\t\t\t<td class='right'>". $subtotal ." &euro;</td>\n");
                        echo("\t\t\t\t</tr>\n");
                    }
                }
                echo("\t\t\t\t<tr class='shipping'>\n");
                echo("\t\t\t\t\t<td class='right' colspan='4'>Shipping cost</td>\n");
                echo("\t\t\t\t\t<td class='right'>". $shippingCost ." &euro;</td>\n");
                echo("\t\t\t\t</tr>\n");
                echo("\t\t\t\t<tr class='total'>\n");
                echo("\t\t\t\t\t<td class='right' colspan='4'>Total</td>\n");
                echo("\t\t\t\t\t<td class='right'>". ($totalPrice + $shippingCost) ." &euro;</td>\n");
                echo("\t\t\t\t</tr>\n");
                echo("\t\t\t</table>\n");
            ?>
            <div class="btnBox">
                <a class="button" href="buildingSets.php">Continue shopping</a>
                <input class="button marginLeft" type="submit" name="putOrder" value="Order">
            </div>
            <p class="spacer"></p>
            </form>
        </div> <!-- end center -->
<?php
        // close database connection
        $connection->close();
         
         createFooter(true);
     }
     else
     {
         // Session variable is not set, role does not comply or order empty: user should not be on this page
         header("Location: ../index.php");
     }
?>