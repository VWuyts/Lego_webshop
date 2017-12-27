<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Building sets page
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/Product.php");
    require_once("../classes/BuildingSet.php");

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

    createHead(true, "Legoshop | Sets", ['products'], ['buildingSets']);
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
    $labelArray = BuildingSet::getLabel($connection);
    $counter = 0;
    $exclLabelID = array_search("Exclusives", $labelArray['lName']);
    if ($exclLabelID !== false)
    {
        $exclLabelID = $labelArray['labelID'][$exclLabelID];
    }
    $htfLabelID = array_search("Hard to find", $labelArray['lName']);
    if ($htfLabelID !== false)
    {
        $htfLabelID = $labelArray['labelID'][$htfLabelID];
    }
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
                            $ageArray = BuildingSet::getAge($connection);
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
                                . BuildingSet::PRICE_ARRAY[0] ."' />0 &euro; - ". BuildingSet::PRICE_ARRAY[0] ." &euro;</li>\n");
                            for ($i = 1; $i < count(BuildingSet::PRICE_ARRAY); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='price' value='"
                                    . BuildingSet::PRICE_ARRAY[$i] ."' />". BuildingSet::PRICE_ARRAY[$i - 1] ." &euro; - "
                                    . BuildingSet::PRICE_ARRAY[$i] ." &euro;</li>\n");
                            }
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='price' 
                                value='". BuildingSet::PRICE_ARRAY[count(BuildingSet::PRICE_ARRAY) - 1]
                            ."' />". BuildingSet::PRICE_ARRAY[count(BuildingSet::PRICE_ARRAY) - 1] ."+ &euro;</li>\n");
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter price -->
                    <?php
                        if (!isset($_GET['filter']) || (htmlspecialchars($_GET['filter']) !== "exclusives"
                            && htmlspecialchars($_GET['filter']) !== "hardToFind"))
                        {
                            echo("\t\t\t\t\t<div class='filter'>\n");
                            echo("\t\t\t\t\t\t<p class='filterLabel'>FEATURED</p>\n");
                            echo("\t\t\t\t\t\t<ul>\n");
                            for ($i = 0; $i < count($labelArray['lName']); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='label' 
                                    value='". $labelArray['labelID'][$i] ."' />". $labelArray['lName'][$i] ."</li>\n");
                            }
                            echo("\t\t\t\t\t\t</ul>\n");
                            echo("\t\t\t\t\t</div> <!-- end filter featured -->\n");
                        }
                    ?>
                    <div class="filter">
                        <p class="filterLabel">THEME</p>
                        <?php
                            $themeArray = BuildingSet::getTheme($connection);
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
                        <p class="filterLabel">INTEREST</p>
                        <?php
                            $sortArray = BuildingSet::getSort($connection);
                            echo("\t\t\t\t\t\t<ul>\n");
                            for ($i = 0; $i < count($sortArray['sName']); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='sort' 
                                    value='". $sortArray['sortID'][$i] ."' />". $sortArray['sName'][$i] ."</li>\n");
                            }
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter interest -->
                    <div class="filter">
                        <p class="filterLabel">PIECE COUNT</p>
                        <?php
                            echo("\t\t\t\t\t\t<ul>\n");
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' value='". BuildingSet::PIECES_ARRAY[0]
                                ."' />1 - ". BuildingSet::PIECES_ARRAY[0] ."</li>\n");
                            for ($i = 1; $i < count(BuildingSet::PIECES_ARRAY); $i++)
                            {
                                echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' value='"
                                    . BuildingSet::PIECES_ARRAY[$i] ."' />". BuildingSet::PIECES_ARRAY[$i - 1] ." - "
                                    . BuildingSet::PIECES_ARRAY[$i] ." </li>\n");
                            }
                            echo("\t\t\t\t\t\t\t<li><input class='filterCheckbox' type='checkbox' name='pieces' 
                                value='". BuildingSet::PIECES_ARRAY[count(BuildingSet::PIECES_ARRAY) - 1]
                                ."' />". BuildingSet::PIECES_ARRAY[count(BuildingSet::PIECES_ARRAY) - 1] ."+</li>\n");
                            echo("\t\t\t\t\t\t</ul>\n");
                        ?>
                    </div> <!-- end filter pieces -->
                    <?php
                        $exclValue = -1;
                        $htfValue = -1;
                        if(isset($_GET['filter']))
                        {
                            if(htmlspecialchars($_GET['filter']) == "exclusives")
                            {
                                $exclValue =  $exclLabelID;
                            }
                            if(htmlspecialchars($_GET['filter']) == "hardToFind")
                            {
                                $htfValue = $htfLabelID;
                            }
                        }
                        echo("\t\t\t\t<input type='hidden' id='exclLabelID' value='". $exclValue."'>\n");
                        echo("\t\t\t\t<input type='hidden' id='htfLabelID' value='". $htfValue ."'>\n");
                    ?>
                </form>
            </div> <!-- end sideMenu -->
            <div id="setsContent">
                <?php
                    $buildingSetArray = BuildingSet::getProducts($connection);
                    $shoppingBag = (isset($_SESSION['role'])? true : false);
                    for ($i = 0; $i < count($buildingSetArray); $i++)
                    {
                        if (!isset($_GET['filter']))
                        {
                            $buildingSetArray[$i]->print($shoppingBag, $labelArray);
                            $counter++;
                        }
                        else
                        {
                            if (htmlspecialchars($_GET['filter']) == "exclusives" 
                                && $buildingSetArray[$i]->m_labelID == $exclLabelID)
                            {
                                $buildingSetArray[$i]->print($shoppingBag, $labelArray);
                                $counter++;
                            }
                            if (htmlspecialchars($_GET['filter']) == "hardToFind"
                                && $buildingSetArray[$i]->m_labelID == $htfLabelID)
                            {
                                $buildingSetArray[$i]->print($shoppingBag, $labelArray);
                                $counter++;
                            }
                        }
                    }
                    if ($counter == 0)
                    {
                        echo("\t\t\t\t<p class='message'>There are no sets available</p>");
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