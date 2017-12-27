<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Index page
 */

    session_start();
    require_once("php/functions.php");
    require_once("php/errorHandling.php");
    require_once("php/exceptionHandling.php");

    createHead(NULL, "Legoshop", ['index'], NULL);
    // Check user role to create appropriate header
    if (isset($_SESSION['role']) && ($_SESSION['role'] === "customer" || $_SESSION['role'] === "admin"))
    {
        
        createHeader(NULL, $_SESSION['firstname'], $_SESSION['role'] === "admin");
    }
    else
    {
        // User is a regular, not logged on user, no need to keep session
        session_unset();
        session_destroy();
        createHeader(NULL, NULL, false);
    }
?>
        <div id="seasonal">
            <div class="center">
                <p class="info">Head home for the holidays with the Winter Village Station!</p>
                <a class="button" href="php/buildingSets.php">Check it out</a>
            </div> <!-- end center -->
        </div> <!-- end seasonal -->
        <div id="tajMahal">
            <div class="center">
                <p class="info"> Discover the architectural wonder of the Taj Mahal!</p>
                <a class="button" href="php/buildingSets.php">Check it out</a>
            </div> <!-- end center -->
        </div> <!-- end tajMahal -->
<?php
    createFooter(NULL);
?>