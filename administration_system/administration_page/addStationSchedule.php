<!--add station schedule-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
//$userID =$_SESSION['userID'];
$userID = '1';

//We need validation
require_once 'CheckExists.php';
$queryChecker = new CheckExists();
$trainScheduleID = $_POST["trainScheduleID"];
$stationID = $_POST["stationScheduleID"];
$arriveTime = $_POST["arrivalTime"];
$arriveDate = $_POST["arrivalDate"];
$departureTime = $_POST["departureTime"];
$departureDate = $_POST["departureDate"];

//Convert into database friendly format.
$departureDateTime = $departureDate . " " . $departureTime . ":00";
$arriveDateTime = $arriveDate . " " . $arriveTime . ":00";

require_once '../static/php/PDO.Database.php';
try {
    $database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
} catch (PDOException $e) {
    echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
}

//if user doesn't exist, link to defalut page
if ($userID == null) {
    ?>
    <script>alert("permission denied");
        url = "scheduleStationPage.php";
        window.location.href = url;</script> <?php
} else if ($stationID == null || $trainScheduleID == null || $arriveTime == null || $departureTime == null) {
    ?>
    <script>alert("invalid input");
        url = "scheduleStationPage.php";
        window.location.href = url;</script> <?php
} else {
    //Check input Station ID and input Train Schedule ID

    $isValidStationID = $queryChecker->doesStationIDExist($database, $stationID);
    $isValidSchedule = $queryChecker->doesTrainScheduleExist($database, $trainScheduleID);

    if(!$isValidSchedule){
        ?>
        <script>alert("The schedule selected does not exist.");
            url = "scheduleStationPage.php";
            window.location.href = url;</script> <?php
    }
    if(!$isValidStationID){
        ?>
        <script>alert("The station selected does not exist.");
            url = "scheduleStationPage.php";
            window.location.href = url;</script> <?php
    }

    $checkExists_schedule = $queryChecker->doesScheduleContainTrainAtStation($database, $stationID, $trainScheduleID);

    if ($checkExists_schedule == true) {
        ?>
        <script>alert("A train cannot be scheduled to arrive at the same station multiple times in a single journey.");
            url = "scheduleStationPage.php";
            window.location.href = url;</script> <?php
    } else {

        //Get train ID from train schedule
        $trainID = $queryChecker->getTrainIdOfTrainSchedule($database, $trainScheduleID);
        //Get railwayline id from train id
        $trainRailwayLine = $queryChecker->getRailwayLineOfTrain($database, $trainID);

        //Get all railway lines for the station.
        $stationRailwayLines = $queryChecker->getRailwayLinesOfStation($database, $stationID);


        //If the train railway line is the same as one of the station railway lines continue.
        $foundStationLine = false;
        foreach ($stationRailwayLines as $row) {
            foreach ($row as $railwayLine) {
                if ($trainRailwayLine == $railwayLine) {
                    $foundStationLine = true;
                }
            }
        }
        //Otherwise stop.
        if (!$foundStationLine) {
            ?>
            <script>alert("Cannot assign a train to stop at a station on a different railway line.");
                url = "scheduleStationPage.php";
                window.location.href = url;</script> <?php
        } else {

            $database->query("INSERT INTO StationTrainSchedules VALUES
    		('$stationID', '$trainScheduleID', '$arriveDateTime', '$departureDateTime')");
        }
    }
}
$database->terminateConn();
?>
<script>    url = "scheduleStationPage.php";
    window.location.href = url;</script> <?php
?>