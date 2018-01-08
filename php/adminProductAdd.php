<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Homepage of administrator
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/Product.php");
    require_once("../classes/BuildingSet.php");
    require_once("../classes/Extra.php");

    // create database connection
    $connection = new Connection();    
    
    // Define variables and set to empty values
    $productno = $pName = $price = $minAge = $description = $category = $pieces = $themeID = $sortID = $labelID = "";
    $productnoErr = $pNameErr = $priceErr = $minAgeErr = $descriptionErr
        = $categoryErr = $piecesErr = $themeIDErr = $sortIDErr = $labelIDErr = "";
    $themeArraySets = BuildingSet::getTheme($connection);
    $themeArrayExtras = Extra::getTheme($connection);
    $sortArray = BuildingSet::getSort($connection);
    $labelArray = BuildingSet::getLabel($connection);

    // Form validation
    if (isset($_POST['add']))
    {
        // check productno
        $productno = cleanInput($_POST['productno']);
        if (!empty($productnoErr = Product::check("m_productno", $productno)))
        {
            $productno = "";
        }
        // check pName
        $pName = cleanInput($_POST['pName']);
        if (!empty($pNameErr = Product::check("m_pName", $pName)))
        {
            $pName = "";
        }
        // check price
        $price = cleanInput($_POST['price']);
        if (!empty($priceErr = Product::check("m_price", $price)))
        {
            $price = "";
        }
        // check minAge
        $minAge = cleanInput($_POST['minAge']);
        if (!empty($minAgeErr = Product::check("m_minAge", $minAge)))
        {
            $minAge = "";
        }
        // check description
        $description = cleanInput($_POST['description']);
        if (!empty($descriptionErr = Product::check("m_description", $description)))
        {
            $description = "";
        }
        // check minAge
        $minAge = cleanInput($_POST['minAge']);
        if (!empty($minAgeErr = Product::check("m_minAge", $minAge)))
        {
            $minAge = "";
        }
        $pieces = cleanInput($_POST['pieces']);
        $themeID = cleanInput($_POST['themeID']);
        $sortID = cleanInput($_POST['sortID']);
        $labelID = cleanInput($_POST['labelID']);
        if (isset($_POST['category']) && ($category = cleanInput($_POST['category'])) == 'sets')
        {
            // check pieces
            if (!empty($piecesErr = Product::check("m_pieces", $pieces)))
            {
                $pieces = "";
            }
            // check themeID
            if (!empty($themeIDErr = Product::check("m_themeID", $themeID)))
            {
                $themeID = "";
            }
            // check sortID
            if (!empty($sortIDErr = Product::check("m_sortID", $sortID)))
            {
                $sortID = "";
            }
            // check labelID
            if ($labelID === 'na')
            {
                $labelID = NULL;
                $labelIDErr = "";
            }
            elseif (!empty($labelIDErr = Product::check("m_labelID", $labelID)))
            {
                $labelID = "";
            }
        }
        else
        {
            if ($pieces === 0)
            {
                $pieces = NULL;
                $piecesErr = "";
            }
            if ($themeID === 'na')
            {
                $themeID = NULL;
                $themeIDErr = "";
            }
            elseif (!empty($themeIDErr = Product::check("m_themeID", $themeID)))
            {
                $themeID = "";
            }
            if ($sortID === 'na')
            {
                $sortID = NULL;
                $sortIDErr = "";
            }
            if ($labelID === 'na')
            {
                $labelID = NULL;
                $labelIDErr = "";
            }
        }
        unset($_POST['add']);

        // If there are no errors, add product to database
        if (empty($productnoErr) && empty($pNameErr) && empty($priceErr) && empty($minAgeErr)
            && empty($descriptionErr) && empty($categoryErr) && empty($piecesErr) && empty($themeIDErr)
            && empty($sortIDErr) && empty($labelIDErr))
        {
            if ($category == 'sets')
            {
                $product = new BuildingSet($productno, $pName, $price, $minAge,
                    $description, true, $pieces, $themeID, $sortID, $labelID);
            }
            else
            {
                $product = new Extra($productno, $pName, $price, $minAge, $description,
                    true, $pieces, $themeID);
            }
            list($errMessage, $primaryKey) = $product->addToDB($connection);
            if (empty($errMessage))
            {
                // Show message page
                createMessagePage(["The product has been added to the database.", "Please add the image to the images folder."],
                    null, false, "../php/admin.php", "Back to admin page");
                die();
            }
            else
            {
                // show error page
                createErrorPage([$errMessage]);
                die();
            }
        }
    }

    // Check user role and show form
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin")
    {
        createHead(true, "Legoshop | admin", ['admin'], ['adminProductAdd']);
        createHeader(true, $_SESSION['firstname'], true);
?>
        <div class="center">
            <h1>Administrator: add product</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF']))?>" method="post" onSubmit="return checkProduct()">
                <p><label for="productno">Product number:</label></p>
                <p>
                    <input class="textinput" id="productno" type="number" name="productno" value="<?php echo($productno); ?>" autofocus />
                    <span id="productnoErr" class="red">* <?php echo($productnoErr); ?></span>
                </p>
                <p class="topmargin"><label for="pName">Product name:</label></p>
                <p>
                    <input class="textinput" id="pName" type="text" name="pName" value="<?php echo(htmlspecialchars($pName)); ?>" />
                    <span id="pNameErr" class="red">* <?php echo($pNameErr); ?></span>
                </p>
                <p class="topmargin"><label for="price">Price:</label></p>
                <p>
                    <input class="textinput" id="price" type="text" name="price" value="<?php echo(htmlspecialchars($price)); ?>" />
                    <span id="priceErr" class="red">* <?php echo($priceErr); ?></span>
                </p>
                <p class="topmargin"><label for="minAge">Minimum age:</label></p>
                <p>
                    <input class="textinput" id="minAge" type="number" name="minAge" value="<?php echo($minAge); ?>" />
                    <span id="minAgeErr" class="red">* <?php echo($minAgeErr); ?></span>
                </p>
                <p class="topmargin"><label for="description">Description:</label></p>
                <p>
                    <textarea class="textinput" id="description" name="description"><?php echo(htmlspecialchars($description)); ?></textarea>
                    <!-- removed newlines -->
                    <span id="descriptionErr" class="red">* <?php echo($descriptionErr); ?></span>
                </p>
                <p class="topmargin"><label for="category">Category:</label></p>
                <p>
                    <select class="textinput" name="category" id="category">
                        <option value="sets">Sets</option>
                        <option value="extras">Extras</option>
                    </select>
                    <span id="categoryErr" class="red">* <?php echo($categoryErr); ?></span>
                </p>
                <p class="topmargin"><label for="pieces">Pieces:</label></p>
                <p>
                    <input class="textinput" id="pieces" type="number" name="pieces" value="<?php echo($pieces); ?>" />
                    <span id="piecesErr" class="red"> <?php echo($piecesErr); ?></span>
                </p>
                <p class="smallfont">Set to 0 if not applicable</p>
                <p class="topmargin"><label for="themeID">Theme:</label></p>
                <p>
                    <select class="textinput" name="themeID" id="themeID">
                    <?php
                        echo("\t\t\t\t\t\t<option value='na'>Not applicable</option>\n");
                        for ($i = 0; $i < count($themeArraySets['themeID']); $i++)
                        {
                            echo("\t\t\t\t\t\t<option value='". $themeArraySets['themeID'][$i] ."'>". $themeArraySets['tName'][$i]."</option>\n");
                        }
                        for ($i = 0; $i < count($themeArrayExtras['themeID']); $i++)
                        {
                            if (!in_array($themeArrayExtras['themeID'][$i], $themeArraySets['themeID']))
                            {
                                echo("\t\t\t\t\t\t<option value='". $themeArrayExtras['themeID'][$i] ."'>". $themeArrayExtras['tName'][$i]."</option>\n");
                            }
                        }
                    ?>
                    </select>
                    <span id="themeIDErr" class="red"> <?php echo($themeIDErr); ?></span>
                </p>
                <p class="topmargin"><label for="sortID">Interest:</label></p>
                <p>
                    <select class="textinput" name="sortID" id="sortID">
                    <?php
                        echo("\t\t\t\t\t\t<option value='na'>Not applicable</option>\n");
                        for ($i = 0; $i < count($sortArray['sortID']); $i++)
                        {
                            echo("\t\t\t\t\t\t<option value='". $sortArray['sortID'][$i] ."'>". $sortArray['sName'][$i]."</option>\n");
                        }
                    ?>
                    </select>
                    <span id="sortIDErr" class="red"> <?php echo($sortIDErr); ?></span>
                </p>
                <p class="topmargin"><label for="labelID">Label:</label></p>
                <p>
                    <select class="textinput" name="labelID" id="labelID">
                    <?php
                        echo("\t\t\t\t\t\t<option value='na'>Not applicable</option>\n");
                        for ($i = 0; $i < count($labelArray['labelID']); $i++)
                        {
                            echo("\t\t\t\t\t\t<option value='". $labelArray['labelID'][$i] ."'>". $labelArray['lName'][$i]."</option>\n");
                        }
                    ?>
                    </select>
                    <span id="labelIDErr" class="red"> <?php echo($labelIDErr); ?></span>
                </p>
                <div class='btnBox'>
                    <a class="button" href="admin.php">Cancel</a>
                    <input class="button" type="reset" value="Reset">
                    <input class="button" type="submit" name="add" value="Add product" />
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