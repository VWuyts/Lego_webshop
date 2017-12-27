<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Script to process XMLHttpRequest from buildingSets
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/BuildingSet.php");

    // create database connection
    $connection = new Connection();
    
    // variables
    $labelArray = BuildingSet::getLabel($connection);
    $shoppingBag = (isset($_SESSION['role'])? true : false);
    $query = "SELECT * FROM product" . $_REQUEST['where'];
    $result = $connection->queryResult($query);
    $buildingSetArray = BuildingSet::getProductsFromResultSet($result);
    $counter = 0;

    // create output
    for ($i = 0; $i < count($buildingSetArray); $i++)
    {
        $buildingSetArray[$i]->print($shoppingBag, $labelArray);
        $counter++;
    }
    if ($counter == 0)
    {
        echo("\t\t\t\t<p class='message'>There are no products that match your requirements</p>");
    }
 ?>