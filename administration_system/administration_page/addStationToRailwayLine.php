<!--add station to railway line-->

<?php @session_start();	
	//$userID =$_SESSION['userID'];
	$userID='1';   //use it to test, delete it

	$railwayLineName=$_POST["railwayLineName"];
	$stationID=$_POST["stationID"];
	$position=$_POST["position"];
	require_once '../static/php/PDO.Database.php';
	require_once 'CheckExists.php';	
	
	try {
   		$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
        echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
    }	
    
	//if user doesn't exist, link to defalut page
	if ($userID == null) {
		?> <script>alert("permission denied");
		url="railwayLinePage.php";window.location.href=url;</script> <?php	
	} else if ($railwayLineName == null || $stationID == null || $position == null){
		?> <script>alert("invalid input");
		url="railwayLinePage.php";window.location.href=url;</script> <?php		
	} else {
		$queryChecker = new CheckExists;
		$checkExist_position = $queryChecker->doesRailwayLinePositionExistAtRailwayLineName($database, $railwayLineName, $position);
		$checkExist_railwayName = $queryChecker->doesRailwayLineNameExist($database, $railwayLineName);
		$checkExist_stationID = $queryChecker->doesStationIDExist($database, $stationID);
		
		if($checkExist_position == true) {
			?> <script>alert("this position is occupied"); </script> <?php			
		} else if ($checkExist_railwayName == false) {
			?> <script>alert("this railway name isn't exist"); </script> <?php	
		} else if ($checkExist_stationID == false) {
			?> <script>alert("this stationID isn't exist"); </script> <?php	
		}	
		else {
			$QueryResults_railwayLineID = $database->query("select id from RailwayLines where name='$railwayLineName'");
			$Row_railwayLineID = $QueryResults_railwayLineID->fetchAll(MYSQLI_BOTH);		
			$SQL_railwayLineID = $Row_railwayLineID[0][0];	
			
			$database->query("insert into  RailwayLinesStations values('$SQL_railwayLineID','$position','$stationID')");
		}		
	}
	$database->terminateConn();
	?> <script>	url="railwayLinePage.php";window.location.href=url;</script> <?php		
?>