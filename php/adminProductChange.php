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

    require_once("../classes/Product.php");
    require_once("../classes/BuildingSet.php");
    require_once("../classes/Extra.php");
    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    
    // Check user role and session variables
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin" && isset($_SESSION['product']))
    {
        createHead(true, "Legoshop | admin", ['admin'], NULL);
        createHeader(true, $_SESSION['firstname'], true);

        // create database connection
        $connection = new Connection();

        // process change
        $product = $_SESSION['product'];
        $productno = $product->m_productno;
        if (isset($_POST['change']))
        {
            if (isset($_POST['pName']) && $_POST['pName'] != $product->m_pName)
                Product::changeProperty("m_pName", $_POST['pName'], $productno, $connection);
            if (isset($_POST['price']) && $_POST['price'] != $product->m_price)
                Product::changeProperty("m_price", $_POST['price'], $productno, $connection);
            if (isset($_POST['minAge']) && $_POST['minAge'] != $product->m_minAge)
                Product::changeProperty("m_minAge", $_POST['minAge'], $productno, $connection);
            if (isset($_POST['pieces']) && $_POST['pieces'] != $product->m_pieces)
                Product::changeProperty("m_pieces", $_POST['pieces'], $productno, $connection);
            if (isset($_POST['theme']) && $_POST['theme'] != $product->m_themeID && $_POST['theme'] != 'na')
                Product::changeProperty("m_themeID", $_POST['theme'], $productno, $connection);
            if (isset($_POST['sort']) && $_POST['sort'] != $product->m_sortID)
                BuildingSet::changeProperty("m_sortID", $_POST['sort'], $productno, $connection);
            if (isset($_POST['label']) && $_POST['label'] != $product->m_labelID)
                BuildingSet::changeProperty("m_labelID", $_POST['label'], $productno, $connection);
            header("Location: adminProduct.php");
            die();
        }

        // variables
        $category = $product->getCategory();
        $themeArraySets = BuildingSet::getTheme($connection);
        $themeArrayExtras = Extra::getTheme($connection);
        $sortArray = BuildingSet::getSort($connection);
        $labelArray = BuildingSet::getLabel($connection);
        if ($category == 'sets')
        {
            $themeIndex = array_search($product->m_themeID, $themeArraySets['themeID']);
            if ($themeIndex !== false) $theme = $themeArraySets['tName'][$themeIndex];
            else $theme = NULL;
            $sortIndex = array_search($product->m_sortID, $sortArray['sortID']);
            if ($sortIndex !== false) $sort = $sortArray['sName'][$sortIndex];
            else $sort = NULL;
            $labelIndex = array_search($product->m_labelID, $labelArray['labelID']);
            if ($labelIndex !== false) $label = $labelArray['lName'][$labelIndex];
            else $label = NULL;
        }
        else
        {
            $themeIndex = array_search($product->m_themeID, $themeArrayExtras['themeID']);
            if ($themeIndex !== false) $theme = $themeArrayExtras['tName'][$themeIndex];
            else $theme = NULL;
            $sort = NULL;
            $label = NULL;
        }
        $pieces = $product->m_pieces;
?>
        <div class="center">
            <h1>Administrator: change product</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF']))?>" method="post">
            <table class="changeTable">
                <tr>
                    <th>Item</th>
                    <th>Current value</th>
                    <th>Change into</th>
                </tr>
                
                <?php
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Productno:</td>\n");
                    echo("\t\t\t\t\t<td>". $productno."</td>\n");
                    echo("\t\t\t\t\t<td>-</td>\n");
                    echo("\t\t\t\t</tr>\n");
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Product name:</td>\n");
                    echo("\t\t\t\t\t<td>". htmlspecialchars($product->m_pName) ."</td>\n");
                    echo("\t\t\t\t\t<td><input type='text' name='pName' /></td>\n");
                    echo("\t\t\t\t</tr>\n");
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Price:</td>\n");
                    echo("\t\t\t\t\t<td>". $product->m_price ."</td>\n");
                    echo("\t\t\t\t\t<td><input type='text' name='price' /></td>\n");
                    echo("\t\t\t\t</tr>\n");
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Min age:</td>\n");
                    echo("\t\t\t\t\t<td>". $product->m_minAge ."</td>\n");
                    echo("\t\t\t\t\t<td><input type='number' name='minAge' /></td>\n");
                    echo("\t\t\t\t</tr>\n");
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Pieces:</td>\n");
                    echo("\t\t\t\t\t<td>". (is_null($pieces) ? "na" : $pieces) ."</td>\n");
                    echo("\t\t\t\t\t<td><input type='number' name='pieces' /></td>\n");
                    echo("\t\t\t\t</tr>\n");
                    echo("\t\t\t\t<tr>\n");
                    echo("\t\t\t\t\t<td>Theme:</td>\n");
                    echo("\t\t\t\t\t<td>". (is_null($theme) ? "na" : $theme) ."</td>\n");
                    echo("\t\t\t\t\t<td>\n");
                    echo("\t\t\t\t\t\t<select name='theme'>\n");
                    if ($category != 'sets') echo("\t\t\t\t\t\t\t<option value='NULL'>na</option>\n");
                    for ($i = 0; $i < count($themeArraySets['themeID']); $i++)
                    {
                        echo("\t\t\t\t\t\t\t<option value='". $themeArraySets['themeID'][$i] ."'>". $themeArraySets['tName'][$i]."</option>\n");
                    }
                    for ($i = 0; $i < count($themeArrayExtras['themeID']); $i++)
                    {
                        if (!in_array($themeArrayExtras['themeID'][$i], $themeArraySets['themeID']))
                        {
                            echo("\t\t\t\t\t\t\t<option value='". $themeArrayExtras['themeID'][$i] ."'>". $themeArrayExtras['tName'][$i]."</option>\n");
                        }
                    }
                    echo("\t\t\t\t\t\t</select>\n");
                    echo("\t\t\t\t\t</td>\n");
                    echo("\t\t\t\t</tr>\n");
                    if ($category == 'sets')
                    {
                        echo("\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t<td>Interest:</td>\n");
                        echo("\t\t\t\t\t<td>". $sort ."</td>\n");
                        echo("\t\t\t\t\t<td>\n");
                        echo("\t\t\t\t\t\t<select name='sort'>\n");
                        for ($i = 0; $i < count($sortArray['sortID']); $i++)
                        {
                            echo("\t\t\t\t\t\t\t<option value='". $sortArray['sortID'][$i] ."'>". $sortArray['sName'][$i]."</option>\n");
                        }
                        echo("\t\t\t\t\t\t</select>\n");
                        echo("\t\t\t\t\t</td>\n");
                        echo("\t\t\t\t</tr>\n");
                        echo("\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t<td>Label:</td>\n");
                        echo("\t\t\t\t\t<td>". (is_null($label) ? 'na' : $label) ."</td>\n");
                        echo("\t\t\t\t\t<td>\n");
                        echo("\t\t\t\t\t\t<select name='label'>\n");
                        for ($i = 0; $i < count($labelArray['labelID']); $i++)
                        {
                            echo("\t\t\t\t\t\t\t<option value='". $labelArray['labelID'][$i] ."'>". $labelArray['lName'][$i]."</option>\n");
                        }
                        echo("\t\t\t\t\t\t</select>\n");
                        echo("\t\t\t\t\t</td>\n");
                        echo("\t\t\t\t</tr>\n");
                    }
                ?>
            </table>
            <div class="btnBox floatR marginTop marginRight">
                <a class="button" href="admin.php">Cancel</a>
                <input class="button" type="reset" value="Reset">
                <input class="button" type="submit" name="change" value="Add product" />
            </div>
            <p class="spacer"></p>
            </form>
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