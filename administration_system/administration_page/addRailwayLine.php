<!--add railway line-->
<!--make sure userID is not null, then check whether lineID exist-->

<?php @session_start();	
	//$userID =$_SESSION['userID'];
	$userID='1';   //use it to test, delete it

	$railwayLineID = 0;
	$railwayLineName=$_POST["railwayLineName"];
	
	require_once '../static/php/PDO.Database.php';	
	try {
    	$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
        echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
    }
	
	//if user doesn't exist, link to defalut page
	//if lineID or lineName is empty, link to defalut page
	//else check whether lineID or lineName exist
	if ($userID == null) {
		?> <script>alert("permission denied");
		url="railwayLinePage.php";window.location.href=url;</script> <?php	
	} else if ($railwayLineName == null){
		?> <script>alert("invalid input");
		url="railwayLinePage.php";window.location.href=url;</script> <?php		
	} else {
		
		require_once 'CheckExists.php';
		$queryChecker = new CheckExists;
		$checkExists_railwayLineName = $queryChecker->doesRailwayLineNameExist($database, $railwayLineName);
		
		if ($checkExists_railwayLineName == true) {
			?> <script>alert("railwayLine name exist");
			url="railwayLinePage.php";window.location.href=url;</script> <?php	
		} else {
			require_once 'RailwayLine.php';
			$railwayLine = new RailwayLine($railwayLineID, $railwayLineName);

			$railwayLine->addRailwayLine($database);
		}		
	}
	$database->terminateConn();
	?> <script>	url="railwayLinePage.php";window.location.href=url;</script> <?php		
?>