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
    
    // Check user role
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin")
    {
        createHead(true, "Legoshop | admin", ['admin'], NULL);
        createHeader(true, $_SESSION['firstname'], true);
?>
        <div class="center">
            <h1>Administrator functions</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <div class='btnBox'>
                <p><a class="button" href="adminUsers.php">Change or delete user</a></p>
                <p><a class="button" href="register.php">Add user</a></p>
                <p><a class="button" href="adminProduct.php">Change or delete product</a></p>
                <p><a class="button" href="adminProductAdd.php">Add product</a></p>
            </div>
        </div>
<?php   
        createFooter(true);
    }
    else
    {
        // Session variable is not set or role does not comply: user should not be on this page
        header("Location: ../index.php");
    }
?>