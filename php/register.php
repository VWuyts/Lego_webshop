<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 */

    require("functions.php");
    createHead(true, "Legoshop register", ["register"], ["register"]);
    createHeader(true, NULL);

    // Define variables and set to empty values
    $firstname = $surname = $email = "";
    $firstnameErr = $surnameErr = $emailErr = $passwErr = "";

    // Form validation
    if (isset($_POST['register'])) {
        //TODO
    }
?>
    <div class="center">
        <h1>Create a Lego account</h1>
    </div> <!-- end center -->
    <hr />
    <div class="center">
        <form id="intputform" action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post" onSubmit="return checkRegister()">
            <p><label for="firstname">First name:</label></p>
            <p>
                <input class="textinput" id="firstname" type="text" name="firstname" value="<?php echo($firstname); ?>" autofocus />
                <span id="firstnameErr" class="red">* <?php echo($firstnameErr); ?></span>
            </p>
            <p class="topmargin"><label for="surname">Surname:</label></p>
            <p>
                <input class="textinput" id="surname" type="text" name="surname" value="<?php echo($surname); ?>" />
                <span id="surnameErr" class="red">* <?php echo($surnameErr); ?></span>
            </p>
            <p class="topmargin"><label for="email">Email address:</label></p>
            <p>
                <input class="textinput" id="email" type="text" name="email" value="<?php echo($email); ?>" />
                <span id="emailErr" class="red">* <?php echo($emailErr); ?></span>
            </p>
            <p class="topmargin"><label for="passw">Password:</label></p>
            <p>
                <input class="textinput" id="passw" type="password" name="passw" />
                <span id="passwErr" class="red">* <?php echo($passwErr); ?></span>
            </p>
            <p>
                <input class="button" type="submit" name="register" value="Register" />
                <a class="button" href="home.php">Cancel</a>
                <input class="button" type="reset" value="Reset">
            </p>
            <p class="spacer"></p>
        </form>
    </div> <!-- end center -->
<?php
    createFooter(true);
?>