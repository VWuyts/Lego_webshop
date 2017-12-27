<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Checkout page 1
 */

    require_once("../classes/Orders.php");
    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/RegisteredUser.php");

    createHead(true, "Legoshop | Checkout", ['checkout'], NULL);
    // Check user role to create appropriate header and check shopping bag
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin")
        && array_sum($_SESSION['bag']['amount']) != 0)
    {
        createHeader(true, $_SESSION['firstname'], $_SESSION['role'] === "admin");

        // create database connection
        $connection = new Connection();

        //variables
        $invoiceAddressID = NULL;

        // process continue
        if (isset($_POST['continue']))
        {
            if (($shipaddressID = $_POST['shipAddress']) == -1)
            {
                $shipaddressID = $_POST['invAddrID'];
            }
            $_SESSION['order'] = new Orders(true, $_SESSION['userID'], $_POST['invAddrID'], $shipaddressID, 0);
            $_SESSION['total'] = $_POST['total'];
            unset($_POST['continue']);
            header("Location: checkoutProcess.php");
            die();
        }

?>
        <div class="center">
            <h1>Checkout</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
        <?php
            $total = 0;
            $subtotal = 0;
            $shippingCost = 0;
           
            echo("\t\t\t<form action='". $_SERVER['PHP_SELF'] ."' method='post'>\n");
            echo("\t\t\t<div class='address'>\n");
            echo("\t\t\t\t<h2>Invoice address</h2>\n");
            $invoiceAddressID = RegisteredUser::printFactAddress($_SESSION['userID'], $connection);
            echo("\t\t\t\t<input type='hidden' name='invAddrID' value='". $invoiceAddressID ."'>\n");
            echo("\t\t\t</div>\n");
            echo("\t\t\t<div class='address'>\n");
            echo("\t\t\t\t<h2>Shipping address</h2>\n");
            RegisteredUser::printShipAddress($_SESSION['userID'], $connection);
            echo("\t\t\t\t\t<a class='button' href='addShipAddress.php'>Add shipping address</a>\n");
            echo("\t\t\t</div>\n");
        ?>
            <div class='address'>
                <h2>Payment method</h2>
                <p><input type="radio" name="payment" value="onlineBanking" checked />Online banking</p>
                <p><input type="radio" name="payment" value="Credit card" />Credit card</p>
                <p><input type="radio" name="payment" value="bankTransfer" />Bank transfer</p>
            </div>
            <?php
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
                         echo("\t\t\t\t\t<td class='right'>". $price ." &euro;</td>\n");
                         $subtotal = $amount * $price;
                         $total += $subtotal;
                         echo("\t\t\t\t\t<td class='right'>". $subtotal ." &euro;</td>\n");
                         echo("\t\t\t\t</tr>\n");
                     }
                 }
                 echo("\t\t\t</table>\n");
                 /*list($costID, $amount) = Orders::getShipCost($shipAddressID, $totalPrice, $connection);
                 echo("\t\t\t\t<tr class='shipping'>\n");
                 echo("\t\t\t\t\t<td class='right' colspan='4'>Shipping cost</td>\n");
                 echo("\t\t\t\t\t<td class='right'>". $shippingCost ." &euro;</td>\n");
                 echo("\t\t\t\t</tr>\n");
                 echo("\t\t\t\t<tr class='total'>\n");
                 echo("\t\t\t\t\t<td class='right' colspan='4'>Total</td>\n");
                 echo("\t\t\t\t\t<td class='right'>". ($total + $shippingCost) ." &euro;</td>\n");
                 echo("\t\t\t\t</tr>\n");
                 ;*/
            ?>
            <div class="btnBox">
                <a class="button" href="buildingSets.php">Continue shopping</a>
                <input class="button marginLeft" type="submit" name="continue" value="Continue to order">
            </div>
            <p class="spacer"></p>
            <input type='hidden' name='total' value='<?php echo($total); ?>' />
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