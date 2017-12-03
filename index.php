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
    $_SESSION['userID'] = -1;
    $_SESSION['role'] = "unregistered";

    require_once("php/functions.php");
    createHead(false, "Legoshop", NULL, NULL);
    createHeader(false, NULL);
?>
<p>
    <?php
    if (is_string("gdhdfiLBCLD")) echo "true";
    else echo "false";
    ?>
</p>
<?php
    createFooter(false);
?>