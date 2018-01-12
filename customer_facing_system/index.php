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
    <?php include 'static/head/navbar.html'; ?>
    <!--Uses PHP to get select head info-->
    <?php include 'static/head/select.html'; ?>
    <!--Uses PHP to get moment head info-->
    <?php include 'static/head/moment.html'; ?>
    <!--Uses PHP to get datetimepicker head info-->
    <?php include 'static/head/bootstrap_datetimepicker.html'; ?>
    <!--Uses PHP to get index specific head info-->
    <?php include 'static/head/index.html'; ?>
</head>

<body>

<!-- Uses PHP to get the default navbar -->

<?php include 'static/page_navbar/navbar.php'; ?>

<!-- End of navbar -->

<div class="form">

    <h2> Where are you headed? </h2>
    <?php
    require_once('static/php/PDO.Database.php');
    try {
        $database = new Database(
            "mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
    } catch (PDOException $e) {
        echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
    }
    $stationsArray = $database->getAllStationNameMnemonics();
    $database->terminateConn();
    ?>
    <p> Please enter a origin station </p>
    <select class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="100%"
            title="Origin station" id="originStation">
        <?php foreach ($stationsArray as $row):
        $stationName = $row[0];
        $stationMnemonic = $row[1] ?>
        <option value="<?php print $stationMnemonic; ?>" data-subtext="<?php print $stationMnemonic; ?>">
            <?php print $stationName; ?>
            <?php endforeach; ?>
    </select>
    <br>
    <br>
    <p> Please enter a destination station </p>
    <select class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="100%"
            title="Destination station" id="destinationStation">
        <?php foreach ($stationsArray as $row):
        $stationName = $row[0];
        $stationMnemonic = $row[1] ?>
        <option value="<?php print $stationMnemonic; ?>" data-subtext="<?php print $stationMnemonic; ?>">
            <?php print $stationName; ?>
            <?php endforeach; ?>
    </select>
    <br>
    <br>
    <div id="datetime_bootstrap_override">
        <div class="form-group" >
            <div class="row">
                <div class="col-md-8">
                    <div id="datetimepicker"></div>
                </div>
            </div>
        </div>
    <br>
    </div>
    <br>
    <button class="button" id="searchButton">SEARCH FASTEST ROUTE</button>

</div>

</body>
</html>
