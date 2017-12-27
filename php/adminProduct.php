<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Administrator page
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/Product.php");
    require_once("../classes/BuildingSet.php");
    require_once("../classes/Extra.php");
    
    // Check user role
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin")
    {
        // create database connection
        $connection = new Connection();

        // Process changes
        if (isset($_GET['active']))
        {
            $productno = htmlspecialchars($_GET['active']);
            Product::changeStatus($productno, $connection);
        }
        $setsArray = BuildingSet::getAllProducts($connection);
        $extrasArray = Extra::getAllProducts($connection);
        if (isset($_GET['changeSet']))
        {
            $index = htmlspecialchars($_GET['changeSet']);
            if ($index >= 0 && $index < count($setsArray));
            $_SESSION['product'] = $setsArray[$index];
            header("Location: adminProductChange.php");
        }
        if (isset($_GET['changeExtra']))
        {
            $index = htmlspecialchars($_GET['changeExtra']);
            if ($index >= 0 && $index < count($extrasArray));
            $_SESSION['product'] = $extrasArray[$index];
            header("Location: adminProductChange.php");
        }

        // variables
        $themeArraySets = BuildingSet::getTheme($connection);
        $themeArrayExtras = Extra::getTheme($connection);
        $sortArray = BuildingSet::getSort($connection);
        $labelArray = BuildingSet::getLabel($connection);

        createHead(true, "Legoshop | admin", ['admin'], NULL);
        createHeader(true, $_SESSION['firstname'], true);
?>
        <div class="center">
            <h1>Administrator: change products or change status of product</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <table>
                <tr>
                    <th>Productno</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Min age</th>
                    <th>Is active</th>
                    <th>Pieces</th>
                    <th>Theme</th>
                    <th>Interest</th>
                    <th>Label</th>
                    <th>Change</th>
                    <th>(In)activate</th>
                </tr>
                <tr>
                    <td colspan='11'>Category: Sets</td>
                </tr>
                <?php
                    for ($i = 0; $i < count($setsArray); $i++)
                    {
                        $productno = $setsArray[$i]->m_productno;
                        $isActive = $setsArray[$i]->m_isActive;
                        $themeIndex = array_search($setsArray[$i]->m_themeID, $themeArrayExtras['themeID']);
                        if ($themeIndex !== false) $theme = $themeArrayExtras['tName'][$themeIndex];
                        else $theme = NULL;
                        $sortIndex = array_search($setsArray[$i]->m_sortID, $sortArray['sortID']);
                        if ($sortIndex !== false) $sort = $sortArray['sName'][$sortIndex];
                        else $sort = NULL;
                        $labelIndex = array_search($setsArray[$i]->m_labelID, $labelArray['labelID']);
                        if ($labelIndex !== false) $label = $labelArray['lName'][$labelIndex];
                        else $label = NULL;
                        echo("\t\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t\t<td>". $productno."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($setsArray[$i]->m_pName) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $setsArray[$i]->m_price ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $setsArray[$i]->m_minAge ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". ($isActive > 0 ? "true" : "false") ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $setsArray[$i]->m_pieces ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". (is_null($theme) ? "na" : $theme ) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". (is_null($sort) ? "na" : $sort ) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". (is_null($label) ? "na" : $label ) ."</td>\n");
                        echo("\t\t\t\t\t\t<td><a href='adminProduct.php?changeSet=". $i ."'>Change set</a></td>\n");
                        echo("\t\t\t\t\t\t<td><a href='adminProduct.php?active=". $productno ."'>".
                            ($isActive ? "Inactivate" : "Activate") ."</a></td>\n");
                        echo("\t\t\t\t\t</tr>\n");
                    }
                ?>
                <tr>
                    <td colspan='11'>Category: Sets</td>
                </tr>
                <?php
                    for ($i = 0; $i < count($extrasArray); $i++)
                    {
                        $productno = $extrasArray[$i]->m_productno;
                        $isActive = $extrasArray[$i]->m_isActive;
                        $themeIndex = array_search($extrasArray[$i]->m_themeID, $themeArraySets['themeID']);
                        if ($themeIndex !== false) $theme = $themeArraySets['tName'][$themeIndex];
                        else $theme = NULL;
                        $pieces = $extrasArray[$i]->m_pieces;
                        echo("\t\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t\t<td>". $productno."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($extrasArray[$i]->m_pName) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $extrasArray[$i]->m_price ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $extrasArray[$i]->m_minAge ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". ($isActive > 0 ? "true" : "false") ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". (is_null($pieces) ? "na" : $pieces) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". (is_null($theme) ? "na" : $theme ) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>na</td>\n");
                        echo("\t\t\t\t\t\t<td>na</td>\n");
                        echo("\t\t\t\t\t\t<td><a href='adminProduct.php?changeExtra=". $i ."'>Change extra</a></td>\n");
                        echo("\t\t\t\t\t\t<td><a href='adminProduct.php?active=". $productno ."'>".
                            ($isActive ? "Inactivate" : "Activate") ."</a></td>\n");
                        echo("\t\t\t\t\t</tr>\n");
                    }
                ?>
            </table>
        </div>
<?php   
        // close database connection
        $connection->close();
        
        createFooter(true);
    }
    else
    {
        // Session variable is not set or role does not comply: user should not be on this page
        header("Location: ../index.php");
    }
?>