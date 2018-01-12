<?php

class Train
{
    private $trainID;
    private $railwayLineID;

    /**
     * Train constructor.
     * @param $trainID
     * @param $railwayLineID
     */
    function __construct($trainID, $railwayLineID)
    {
        $this->trainID=$trainID;
        $this->railwayLineID=$railwayLineID;
    }
    
    function getTrainIDByTrainID($trainID,$database)
    {
		$QueryResults = $database->query("select id from Trains where id='$trainID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getTrainIDByRailwayLineID($railwayLineID,$database)
    {
		$QueryResults = $database->query("select id from Trains where railwaylines_id='$railwayLineID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getRailwayLineIDByTrainID($TrainID,$database)
    {
		$QueryResults = $database->query("select railwaylines_id from Trains where id='$TrainID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }

    function addTrain($database)
    {
    	$database->query("insert into Trains values(null,'$this->railwayLineID')");
    }
    
    function deleteTrain($database)
    {
    	$database->query("delete from Trains where id = '$this->trainID'");
    }
}
?>