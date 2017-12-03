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

    require_once("logHandling.php");

	/* Set error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', true); // development: true - production: false

    /*
	 * Create error handler for caught E_WARNINGs emitted by PHP or for user triggered error conditions
     * (E_USER_ERROR, E_USER_WARNING or E_USER_NOTICE). Based on the $errstr, the error is handled differently.
	 */
    function errorHandler($errno, $errstr, $errfile, $errline)
    {
        global $activitylogger, $errorlogger;
        $messageArray = explode('@', $errstr);
        $userMessage = array();

        switch ($messageArray[0]) {
            case "001":
                $errorlogger->error($messageArray[3], ['user'=>$messageArray[2], 'errno'=>$messageArray[2],
                    'file'=>$errfile, 'line'=>$errline, 'backtrace_file'=>$messageArray[4],
                    'backtrace_line'=>$messageArray[5]]);
                $userMessage = ["The database connection failed."];
                break;
            case "002":
                $errorlogger->error("mysqli_query failed", ['errno'=>$errno, 'file'=>$errfile, 'line'=>$errline,
                    'backtrace_file'=>$messageArray[2], 'backtrace_line'=>$messageArray[3]]);
                $userMessage = ["A database query failed."];
                break;
            
            default:
                if (isset($_SESSION['userID']))
                {
                    $errorlogger->error("caught E_WARNING", ['userID'=>$_SESSION['userID'], 'errno'=>$errno,
                        'errstr'=>$errstr, 'errfile'=>$errfile, 'errline'=>$errline]);
                }
                else
                {
                    $errorlogger->error("caught E_WARNING", ['errno'=>$errno, 'errstr'=>$errstr,
                        'errfile'=>$errfile, 'errline'=>$errline]);
                }
                $userMessage = ['An unexpected error has occurred'];
                break;
        }
        // Clear session
        if (isset($_SESSION['userID']) && 
            (!isset($messageArray[1]) || (isset($messageArray[1]) && $messageArray[1] == 1)))
		{
            $activitylogger->info("logout after warning/error", ['user'=>$_SESSION['userID']]);
            session_unset();
            session_destroy();
		}
        // Redirect user to error page
		createErrorPage($userMessage);
        // Do not execute the internal PHP error handler
        return true;
    } // end function errorHandler

    /*
	 * Create exception handler for uncaught errors/exceptions thrown by PHP.
	 */
	function exceptionHandler(Throwable $ex)
	{
		global $errorlogger;
		// Log error
		if (isset($_SESSION['userID']))
		{
            $errorlogger->error("uncaught error", ['userID'=>$_SESSION['userID'], 'errno'=>$ex->getCode(),
                'errstr'=>$ex->getMessage(), 'errfile'=>$ex->getFile(), 'errline'=>$ex->getLine()]);
		}
		else
		{
            $errorlogger->error("uncaught error", ['errno'=>$ex->getCode(), 'errstr'=>$ex->getMessage(),
                'errfile'=>$ex->getFile(), 'errline'=>$ex->getLine()]);
		}
		// Redirect user to error page
		createErrorPage(["An unexpected error has occurred."]);
    } // end function exceptionHandler
    
    /*
	 * Set the default error/exception handlers
	 */
	set_error_handler('errorHandler', E_ALL); // allow errors at levels E-WARNING, E_USER_ERROR, E_USER_WARNING and E_USER_NOTICE to be caught
	set_exception_handler('exceptionHandler'); // catch uncaught errors
?>