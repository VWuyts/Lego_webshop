<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Homepage
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
    }
    else
    {
        // User is not logged on
        createHead(NULL, "Legoshop", NULL, NULL);
        createHeader(NULL, NULL, false);
    }
?>
    <div class="center">
        <p>blablabla</p>
    </div> <!-- end center -->
<?php
    createFooter(NULL);
?>