<?php
class CheckExists {
	function doesRailwayLinePositionExistAtRailwayLineName($database,$railwayLineName, $position){
		$QueryResults = $database->query("select relative_position from RailwayLinesStations where (railwayline_id in 
				(select id from RailwayLines where name = '$railwayLineName') && relative_position = '$position')");		
			$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			if (count($Row)>1){
				echo "A error has occured, please contact the system administrator with the following details";
				echo "RailwayLinesStations names exceeds limit.";
				var_dump($Row);
				die();
			}
			return true;
	}
		
	function doesTrainExist($database,$trainID){
		$QueryResults = $database->query("select id from Trains where id='$trainID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			return true;
	}
	function doesStationExist($database,$stationName){
		$QueryResults = $database->query("select id from Stations where name='$stationName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			return true;
	}
	
	function doesStationMnemonicExist($database,$mnemonic) {
		$QueryResults = $database->query("select id from Stations where mnemonic='$mnemonic'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			return true;	
	}

	function doesRailwayLineNameExist($database,$railwayLineName) {
		$QueryResults = $database->query("select name from RailwayLines where name='$railwayLineName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			return true;	
	}		
	
	function doesStationIDExist($database,$stationID) {
		$QueryResults = $database->query("select id from Stations where id='$stationID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			return true;	
	}

		function doesScheduleContainTrainAtStation($database,$stationID, $trainScheduleID){
		$QueryResults = $database->query("SELECT station_id FROM StationTrainSchedules WHERE station_id = '$stationID' && trainschedule_id = '$trainScheduleID'");		
			$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
			     return false;
			}
			if (count($Row)>1){
				echo "A error has occured, please contact the system administrator with the following details";
				echo "RailwayLinesStations names exceeds limit.";
				var_dump($Row);
				die();
			}
			return true;
	}

	function getTrainIdOfTrainSchedule($database,$trainScheduleID){
		$QueryResults = $database->query("SELECT train_id FROM TrainSchedules WHERE id = '$trainScheduleID'");
			$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
				echo "A error has occured, please contact the system administrator with the following details";
				echo "Train schedule assigned without train.";
				var_dump($Row);
				die();
			}
			return $Row[0][0];
	}

	function getRailwayLineOfTrain($database, $trainID){
		$QueryResults = $database->query("SELECT railwaylines_id FROM Trains WHERE id = '$trainID'");
			$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
				echo "A error has occured, please contact the system administrator with the following details";
				echo "Train assigned without railway line.";
				var_dump($Row);
				die();
			}
			return $Row[0][0];
	}

	function getRailwayLinesOfStation($database, $stationID){
		$QueryResults = $database->query("SELECT  * FROM RailwayLinesStations WHERE station_id = '$stationID'");
			$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		    if (empty($Row)) {
				echo "A error has occured, please contact the system administrator with the following details";
				echo "Train assigned without railway line.";
				var_dump($Row);
				die();
			}
			return $Row;
	}


    function doesTrainScheduleExist($database,$scheduleId) {
        $QueryResults = $database->query("select id from TrainSchedules where id='$scheduleId'");
        $Row = $QueryResults->fetchAll(MYSQLI_BOTH);
        if (empty($Row)) {
            return false;
        }
        return true;
    }

}