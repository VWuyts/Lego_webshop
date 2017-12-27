<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Logout script
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");

    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin"))
    {
        session_unset();
        session_destroy();
        createMessagePage(["You have been logged out."], null, false, '../index.php', 'Back to home page');
    }
    else
    {
        // Session variable is not set or role does not comply: user should not be on this page
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
?>