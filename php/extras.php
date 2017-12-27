<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Extras page
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/Product.php");
    require_once("../classes/Extra.php");

    // add product to shopping bag
    // do before createHead, so that the number of items in the shopping bag is adjusted
    if (isset($_POST['addToBag']))
    {
        if (($index = array_search($_POST['productno'], $_SESSION['bag']['productno'])) !== false)
        {
            $_SESSION['bag']['amount'][$index]++;
        }
        else
        {
            $_SESSION['bag']['productno'][] = $_POST['productno'];
            $_SESSION['bag']['amount'][] = 1;
            $_SESSION['bag']['pName'][] = NULL;
            $_SESSION['bag']['price'][] = NULL;
        }
        unset($_POST['addToBag']);
        unset($_POST['productno']);
    }

    createHead(true, "Legoshop | Extras", ['products'], ['extras']);
    // Check user role to create appropriate header
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin"))
    {
        createHeader(true, $_SESSION['firstname'], $_SESSION['role'] === "admin");
    }
    else
    {
        // User is a regular, not logged on user, no need to keep session
        session_unset();
        session_destroy();
        createHeader(true, NULL, false);
    }
    // create database connection
    $connection = new Connection();

    // variables
    $counter = 0;
?>
        <div class="center">
            <h1>Sets</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <div class="sideMenu">
                <form action="#">
                    <div class="filter">
                        <p class="filterLink paddingBottom"><a href="#" title="Filter results" onClick="start('filter'); return false;">Filter results</a></p>
                        <p class="filterLink"><a href="#" title="Reset filters" onClick="start('reset'); return false;">Reset all filters</a></p>
                    </div> <!-- end filter buttons -->
                    <div class="filter">
                        <p class="filterLabel">AGE</p>
                        <?php
                            $ageArray = Extra::getAge($connection);
                            echo("\t\t\t\t\t\t<ul>\n");
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='age' value='". $ageArray[0]
                                ."' />0 - ". $ageArray[0] ."</li>\n");
                            for ($i = 1; $i < count($ageArray); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='age' 
                                    value='". $ageArray[$i] ."' />". $ageArray[$i - 1] ." - ". $ageArray[$i] ."</li>\n");
                            }
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='age' 
                                value='". $ageArray[count($ageArray) - 1] ."' />". $ageArray[count($ageArray) - 1] ."+</li>\n");
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter age -->
                    <div class="filter">
                        <p class="filterLabel">PRICE</p>
                        <?php
                            echo("\t\t\t\t\t\t<ul>\n");
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='price' value='"
                                . Extra::PRICE_ARRAY[0] ."' />0 &euro; - ". Extra::PRICE_ARRAY[0] ." &euro;</li>\n");
                            for ($i = 1; $i < count(Extra::PRICE_ARRAY); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='price' value='"
                                    . Extra::PRICE_ARRAY[$i] ."' />". Extra::PRICE_ARRAY[$i - 1] ." &euro; - "
                                    . Extra::PRICE_ARRAY[$i] ." &euro;</li>\n");
                            }
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='price' 
                                value='". Extra::PRICE_ARRAY[count(Extra::PRICE_ARRAY) - 1]
                            ."' />". Extra::PRICE_ARRAY[count(Extra::PRICE_ARRAY) - 1] ."+ &euro;</li>\n");
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter price -->
                    <div class="filter">
                        <p class="filterLabel">THEME</p>
                        <?php
                            $themeArray = Extra::getTheme($connection);
                            echo("\t\t\t\t\t\t<ul>\n");
                            for ($i = 0; $i < count($themeArray['tName']); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='theme' 
                                    value='". $themeArray['themeID'][$i] ."' />". $themeArray['tName'][$i] ."</li>\n");
                            }
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter theme -->
                    <div class="filter">
                        <p class="filterLabel">PIECE COUNT</p>
                        <?php
                            echo("\t\t\t\t\t\t<ul>\n");
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' value='". Extra::PIECES_ARRAY[0]
                                ."' />1 - ". Extra::PIECES_ARRAY[0] ."</li>\n");
                            for ($i = 1; $i < count(Extra::PIECES_ARRAY); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' value='"
                                    . Extra::PIECES_ARRAY[$i] ."' />". Extra::PIECES_ARRAY[$i - 1] ." - "
                                    . Extra::PIECES_ARRAY[$i] ." </li>\n");
                            }
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' 
                                value='". Extra::PIECES_ARRAY[count(Extra::PIECES_ARRAY) - 1]
                                ."' />". Extra::PIECES_ARRAY[count(Extra::PIECES_ARRAY) - 1] ."+</li>\n");
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter pieces -->
                </form>
            </div> <!-- end sideMenu -->
            <div id="setsContent">
                <?php
                    $ExtraArray = Extra::getProducts($connection);
                    $shoppingBag = (isset($_SESSION['role'])? true : false);
                    for ($i = 0; $i < count($ExtraArray); $i++)
                    {
                        $ExtraArray[$i]->print($shoppingBag, NULL);
                        $counter++;
                    }
                    if ($counter == 0)
                    {
                        echo("\t\t\t\t<p class='message'>There are no extras available</p>");
                    }
                ?>
            </div> <!-- end setsContent -->
            <p class="spacer"></p>
        </div> <!-- end center -->
<?php
    // close database connection
    $connection->close();

    createFooter(true);
?>