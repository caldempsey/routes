<!--delete train-->
<!--make sure userID is not null, then check whether trainID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];	
	$userID='1';
	
	$trainID=$_POST["trainID"];
	$railwayLineName=$_POST["railwayLineName"];
	
	require_once '../static/php/PDO.Database.php';
	try {
		$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
		echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
	}
	
	//if user doesn't exist, link to defalut page
	if ($userID == null) {
		?> <script>alert("permission denied");
			url="trainPage.php";window.location.href=url;</script> <?php	
	} else {
		require_once 'RailwayLine.php';
		$railway = new RailwayLine(1, $railwayLineName);
		$railwayLineID = $railway->getIDByName($railwayLineName, $database);		
		
		require_once 'Train.php';
		$train = new Train($trainID, $railwayLineID);

		$train->deleteTrain($database);
	}
	$database->terminateConn();
	?> <script>	url="trainPage.php";window.location.href=url;</script> <?php		
?>