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
?>
    <div class="center">
        <h1>Create a Lego account</h1>
    </div> <!-- end center -->
    <hr />
    <div class="center">
        <form id="intputform" action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post" onSubmit="return checkRegister()">
            <p><label for="email">Email address:</label></p>
            <p>
                <input class="textinput" type="text" name="email" autofocus />
                <span class="red">*</span>
            </p>
            <p id="emailError" class="error">error message</p>
            <p class="topmargin"><label for="firstname">First name:</label></p>
            <p>
                <input class="textinput" type="text" id="firstname" name="firstname" />
                <span class="red">*</span>
            </p>
            <p id="firstnameError" class="error">error message</p>
            <p class="topmargin"><label for="surname">Surname:</label></p>
            <p>
                <input class="textinput" type="text" id="surname" name="surname" />
                <span class="red">*</span>
            </p>
            <p id="surnameError" class="error">error message</p>
            <p class="topmargin"><label for="passw">Password:</label></p>
            <p>
                <input class="textinput" type="password" name="passw" id="passw" />
                <span class="red">*</span>
            </p>
            <p id="passwError" class="error">error message</p>      
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