<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * View shopping bag page
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/Product.php");
    require_once("../classes/Orders.php");

    // process plus or minus
    // do before createHead, so that the number of items in the shopping bag is adjusted
    for ($i = 0; $i < count($_SESSION['bag']['productno']); $i++)
    {
        $pno = $_SESSION['bag']['productno'][$i];
        if (!is_null($pno))
        {
            if (isset($_POST['minus'. $pno]))
            {
                if ($_SESSION['bag']['amount'][$i] > 0)
                {
                    $_SESSION['bag']['amount'][$i]--;
                    if ($_SESSION['bag']['amount'][$i] == 0)
                    {
                        $_SESSION['bag']['productno'][$i] = NULL;
                        $_SESSION['bag']['pName'][$i] = NULL;
                        $_SESSION['bag']['price'][$i] = NULL;
                    }
                }
                unset($_POST['minus'. $pno]);
            }
            elseif (isset($_POST['plus'. $pno]))
            {
                $_SESSION['bag']['amount'][$i]++;
                unset($_POST['plus'. $pno]);
            }
        }
    }

    createHead(true, "Legoshop | Shopping bag", ['shoppingBag'], NULL);
    // Check user role to create appropriate header
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin"))
    {
        createHeader(true, $_SESSION['firstname'], $_SESSION['role'] === "admin");

        // create database connection
        $connection = new Connection();
?>
        <div class="center">
            <h1>Shopping bag</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
        <?php
            if (array_sum($_SESSION['bag']['amount']) == 0)
            {
                echo("\t<p class='message'>You have no products in your shopping bag</p>\n");
            }
            else
            {
                $total = 0;
                $subtotal = 0;
                $shippingCost = 0;
                echo("\t<form action='". htmlspecialchars($_SERVER['PHP_SELF']) ."' method='post'>\n");
                echo("\t\t\t\t<table>\n");
                echo("\t\t\t\t\t<tr>\n");
                echo("\t\t\t\t\t\t<th></th>\n");
                echo("\t\t\t\t\t\t<th colspan='2'>Product</th>\n");
                echo("\t\t\t\t\t\t<th>Quantity</th>\n");
                echo("\t\t\t\t\t\t<th>Price</th>\n");
                echo("\t\t\t\t\t\t<th>Subtotal</th>\n");
                echo("\t\t\t\t\t</tr>\n");
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
                        echo("\t\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t\t<td><img src='../images/". $productno .".jpg' alt='image of product' /></td>\n");
                        echo("\t\t\t\t\t\t<td>". $productno ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($pName) ."</td>\n");
                        echo("\t\t\t\t\t\t<td class='tdCenter'>\n");
                        echo("\t\t\t\t\t\t\t<input class='miniBtn' type='submit' name='minus". $productno ."' value='-' />\n");
                        echo("\t\t\t\t\t\t\t ". $amount ." \n");
                        echo("\t\t\t\t\t\t\t<input class='miniBtn' type='submit' name='plus". $productno ."' value='+' />\n");
                        echo("\t\t\t\t\t\t</td>\n");
                        echo("\t\t\t\t\t\t<td class='right'>". $price ." &euro;</td>\n");
                        $subtotal = $amount * $price;
                        $total += $subtotal;
                        echo("\t\t\t\t\t\t<td class='right'>". $subtotal ." &euro;</td>\n");
                        echo("\t\t\t\t\t</tr>\n");
                    }
                }
                echo("\t\t\t\t\t<tr class='shipping'>\n");
                echo("\t\t\t\t\t\t<td class='right' colspan='5'>Estimated shipping cost</td>\n");
                $shippingCost = Orders::getMaxShippingCost($connection, $total);
                echo("\t\t\t\t\t\t<td class='right'>". $shippingCost ." &euro;</td>\n");
                echo("\t\t\t\t\t</tr>\n");
                echo("\t\t\t\t\t<tr class='total'>\n");
                echo("\t\t\t\t\t\t<td class='right' colspan='5'>Total</td>\n");
                echo("\t\t\t\t\t\t<td class='right'>". ($total + $shippingCost) ." &euro;</td>\n");
                echo("\t\t\t\t\t</tr>\n");
                echo("\t\t\t\t</table>\n");
                echo("\t\t\t</form>\n");
            }
        ?>
            <div class="btnBox">
                <a class="button" href="buildingSets.php">Continue shopping</a>
                <a class="button marginLeft" href="checkout.php">Checkout</a>
            </div>
            <p class="spacer"></p>
        </div> <!-- end center -->
<?php
        // close database connection
        $connection->close();

        createFooter(true);
    }
    else
    {
        // Session variable is not set or role does not comply: user should not be on this page
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
?>