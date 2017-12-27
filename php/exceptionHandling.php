<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Setup exception handling
 */

require_once((basename(getcwd()) == "Lego_webshop" ? "php/" : "") ."functions.php");
require_once((basename(getcwd()) == "Lego_webshop" ? "" : "../") ."classes/ErrorLog.php");

    // create exception handler for uncaught exceptionss
    function handleUncaughtException($e)
    {
        $log = new ErrorLog($e->getCode(), "Uncaught exception: " . $e->getMessage(), $e->getFile(), $e->getLine());
        $log->WriteError();
        if (isset($_SESSION['role']))
        {
            session_unset();
            session_destroy();
        }
        createErrorPage(["An unexpected exception has occurred.", "Please contact the Lego Shop administrator."]);
    } // end function handleUncaughtException
    
    // set the defined exception handler
    set_exception_handler('handleUncaughtException');
?>