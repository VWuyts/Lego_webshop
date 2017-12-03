<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Setup log handling
 */

$config = include('../conf/config.php');

spl_autoload_register(function ($class) {
    $file = '../classesExternal/'.$class.'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

// Create the loggers
$activitylogger = new Logger('activityLogger');
$errorlogger = new Logger('errorLogger');

// Add the handlers
$activitylogger->pushHandler(new RotatingFileHandler($config['activityLog'].'/activity.log', $config['maxLogFiles'], Logger::INFO, false));
$errorlogger->pushHandler(new RotatingFileHandler($config['errorLog'].'/error.log', $config['maxLogFiles'], Logger::ERROR, false));

?>