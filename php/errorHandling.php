<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Setup error handling
 */

require_once((basename(getcwd()) == "Lego_webshop" ? "php/" : "") ."functions.php");
require_once((basename(getcwd()) == "Lego_webshop" ? "" : "../") ."classes/ErrorLog.php");

    // create error handler for uncaught errors
    function handleErrors($errno, $errMsg, $errFile, $errLine)
    {
        $log = new ErrorLog($errno, "Uncaught error: ". $errMsg, $errFile, $errLine);
        $log->WriteError();
        if (isset($_SESSION['role']))
        {
            session_unset();
            session_destroy();
        }
        createErrorPage(["An unexpected error has occurred.", "Please contact the Lego Shop administrator."]);
    } // end function handleErrors

    // set the defined error handler
    set_error_handler('handleErrors');
?>