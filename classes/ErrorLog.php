<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * class ErrorLog
 */

class ErrorLog
{
    // member variables
    private $errno;
    private $errMsg;
    private $errFile;
    private $errLine;

    // constant
    private const LOG_FILE = "./../errorLog/error.log";

    // constructor
    public function __construct($errno = 0, $errMsg = "", $errFile = "", $errLine = "")
    {
        $this->errno = $errno;
        $this->errMsg = $errMsg;
        $this->errFile = $errFile;
        $this->errLine = $errLine;
    } // end constructor

    // write error to log file
    public function writeError() {
        $error = date("Y-m-d H:i:s - ");
        $error .= "[" . $this->errno . "] ";
        $error .= $this->errMsg . " | file: " . $this->errFile . " | line: " . $this->errLine ."\n";
        
        // Log details of error in a file
        // Message_type = 3 = message is appended to the file destination.
        error_log($error, 3, self::LOG_FILE);
    } // end function writeError
} // end class ErrorLog
?>
