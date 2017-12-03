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
    require_once("php/functions.php");
    
    // Check user role
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin")
    {
        require_once("functions.php");
        createHead(true, "Legoshop | admin", NULL, NULL);
        createHeader(true, $_SESSION['firstname'], true);

        createFooter(true);
    }
    else
    {
        // User is not an admin and should not be on this page
        header("Location: ../index.php");
    }

?>