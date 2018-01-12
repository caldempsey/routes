<!--delete railway line-->
<!--make sure userID is not null, then check whether lineID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];	
	$userID='1';
	
	$railwayLineID=$_POST["railwayLineID"];
	$railwayLineName=$_POST["railwayLineName"];
	
	require_once '../static/php/PDO.Database.php';
	try {
		$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e) {
		echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
	}
	
	//if user doesn't exist, link to defalut page
	if ($userID == null) {
		?> <script>alert("permission denied");
		url="railwayLinePage.php";window.location.href=url;</script> <?php	
	} else {
		require_once 'RailwayLine.php';
		$railwayLine = new RailwayLine($railwayLineID, $railwayLineName);
		$railwayLineName = $railwayLine->getNameByID($railwayLineID, $database);
		
		if ($railwayLineName == null) {
			?> <script>alert("Error, line doesn't exist.");</script> <?php	
		} else {
			$railwayLine->deleteRailwayLine($database);
		}
	}
	$database->terminateConn();
	?> <script>	url="railwayLinePage.php";window.location.href=url;</script> <?php		
?>