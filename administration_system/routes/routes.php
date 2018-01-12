<?php
/*
 * ##ROUTES##
 * Rotes.php defines the main script for the routing algorithm (also generates web content).
 * The solution is object oriented and utilizes the PDO.Database object library developed by Team 6 (see root folder/static/php).
 * The solution was designed by Callum Dempsey Leach B6070824. For more information on this solution (its intricate details) please see the readme attached.
 * To see information about the head of the document please see "static/head/routes_navbar" as PHP is used to attain that information.
 * How to input data..
 *
 *The method to input that data is similar to that of National Rail. To illustrate the format is as follows.. routes.php?OriginStationMnemonic/DestinationStationMnemonic/DepartureDate [format: DDMMYY]/DepartureTime [format: HHMMSS].
 *
 */
?>
<!-- HTML Begins Here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Use PHP to compile necessary files -->
    <!--Uses PHP to get bootstrap head info-->
    <?php include 'static/head/bootstrap.html'; ?>
    <!--Uses PHP to get navbar head info-->
    <?php include 'static/head/routes_navbar.html'; ?>
    <!--Uses PHP to get index specific head info-->
    <?php include 'static/head/routes.html'; ?>
</head>

<body>
<!-- Uses PHP to get the default navbar from static directory -->

<?php include 'static/page_navbar/navbar.php'; ?>


<?php

require_once('../static/php/PDO.Database.php');
$query = explode("/", $_SERVER["QUERY_STRING"]);
if (!isset($query[0]) || !isset($query[1]) || !isset($query[2]) || !isset($query [3])) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include("../404.php");
    die();
}

//Get values.
$sourceMnemonic = $query[0];
$destinationMnemonic = $query[1];
$leavingDate = $query[2];
$leavingTime = $query[3];

//Initialize an instance of the database.
try {
    $database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
} catch (PDOException $e) {
    echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
}

//Identify if values exist in database (binding params to prevent SQL injects). If not then return 404.
$sourceStationId = $database->getStationIdFromMnemonic($sourceMnemonic);

if ($sourceStationId == null) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include("../404.php");
    die();
} else {
    $sourceStationId = $sourceStationId[0];
}
$destinationStationId = $database->getStationIdFromMnemonic($destinationMnemonic);
if ($destinationStationId == null) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include("../404.php");
    die();
} else {
    $destinationStationId = $destinationStationId[0];
}
//At this stage we have parsed station input but not parsed date-time input. Regular expression check that input.
//The format from the UI is dmyHms.
$dateTime = $leavingDate . "/" . $leavingTime;
//Use that format to try and create a datetime object.
$dateTime = DateTime::createFromFormat('dmy/Hi', $dateTime);
//Check if conversion to format was successful, if not return 404.
if ($dateTime == null) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include("../404.php");
    die();
}
//Get unix time.
$inputUnixTime = $dateTime->getTimestamp();
//If we get this far then we can freely request a route table from the application.

//Request needed classes.
require_once('DatabaseResultsParser.php');
require_once('TrainSchedule.php');
require_once('TrainSchedules.php');
require_once('StationStop.php');

//Find departures and terminate the connection to the database.
$databaseResults = $database->getAllDeparturesAfterUnixTime($inputUnixTime);
$database->terminateConn();

//Create an instance of the results parser to parse the database results to Train Schedule objects in a Train Schedules object.
$resultsParser = new DatabaseResultsParser();
$trainSchedules = $resultsParser->generateTrainSchedulesFromArray($databaseResults);

//Find the next departing train from the station.
$sourceStationNode = $trainSchedules->getNextDepartingStationStopNode($sourceStationId);
if ($sourceStationNode == null) {
    //If there are no trains departing from that station alert the user.
    ?>
    <div class="form">
        <p>There are no departing trains from the station selected at this time.</p>
    </div>
    <?php
    die(1);
}

//Otherwise try to trace a path to the destination from the source station.
$annotatedDestinations = $trainSchedules->generatePathsToStationIdFromNode($sourceStationNode, $destinationStationId);

//If the list of annotated destinations is null then the destination was not reached.
if ($annotatedDestinations->isEmpty()) {
    ?>
    <div class="form">
        <p>Unfortunately there are no possible routes to reach your destination.</p>
    </div>
    <?php
    die(1);
}

//Of those stations get the earliest arriving station with the following loop.
$earliestArrivalNode = $annotatedDestinations[0];
foreach ($annotatedDestinations as $destinationNode) {
    if (($earliestArrivalNode->getArrivalDateTime()->getTimestamp()) > ($destinationNode->getArrivalDateTime()->getTimestamp())){
        $earliestArrivalNode = $destinationNode;
    }
}

//Create a route table based on the results.
$routeArray = new SplDoublyLinkedList();
//Null was used as indicative to stop the trace so we can stop getting results at null.
$lastNode = $earliestArrivalNode;
while ($lastNode != null) {
    $lastNode = $lastNode->getNodeFrom();
    //Make sure before the loop stops we don't add the null to our route table.
    if ($lastNode != null) {
        $routeArray->add(0, $lastNode);
    }
}
//Print the results to a bootstrap table.
?>
<div id="bootstrap_table">
    <table class="table">
        <tr>
            <th>Stop No.</th>
            <th>Station Name</th>
            <th>Arriving Date and Time</th>
            <th> Departing Date and Time</th>
        </tr>
        <tbody>
        <?php

        $rowNo = 1;
        foreach ($routeArray as $station): ?>
            <tr>
                <th scope="row"><?php print $rowNo; ?></th>
                <td><?php print $station->getStationName(); ?></td>
                <td><?php print $station->getArrivalDateTime()->format('d-m-Y H:i:s'); ?></td>
                <td><?php print $station->getDepartureDateTime()->format('d-m-Y H:i:s');
                    $rowNo = $rowNo + 1; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th scope="row"><?php print $rowNo; ?></th>
            <td><?php print $earliestArrivalNode->getStationName(); ?></td>
            <td><?php print $earliestArrivalNode->getArrivalDateTime()->format('d-m-Y H:i:s'); ?></td>
            <td><?php print $earliestArrivalNode->getDepartureDateTime()->format('d-m-Y H:i:s'); ?></td>
        </tr>
        </tbody>
    </table>
</div>


