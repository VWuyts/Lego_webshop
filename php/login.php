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
    createHead(true, "Legoshop login", ["login"], ["login"]);
    createHeader(true, NULL);
?>
    <div class="center">
        <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" onSubmit="return checkRegister()">
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" />
                <span class="red">*</span>
            </p>
            <p>
                <label for="firstname">First name:</label>
                <input type="text" id="firstname" name="firstname" />
                <span class="red">*</span>
            </p>
            <p>
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" />
                <span class="red">*</span>
            </p>
            <p>
                <label for="passw">Password:</label>
                <input type="password" name="passw" id="passw" />
                <span class="red">*</span>
            </p>        
            <p>
                <input type="submit" name="register" value="Register" />
            </p>
        </form>
    </div>
<?php
    createFooter(true);
?>