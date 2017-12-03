<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Account page
 */

    session_start();
    require_once("php/functions.php");

    // Check user role
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer"))
    {
        createHead(NULL, "Legoshop", NULL, NULL);
        createHeader(NULL, $_SESSION['firstname'], false);
    }
    elseif (isset($_SESSION['role']) && ($_SESSION['role'] === "admin"))
    {
        createHead(NULL, "Legoshop", NULL, NULL);
        createHeader(NULL, $_SESSION['firstname'], true);
?>
    <div class="center">
        <p>blablabla</p>
    </div> <!-- end center -->
<?php
    createFooter(NULL);
    }
    else
    {
        // User is not logged on and should not be on this page
        header("Location: ../index.php");
    }
?>