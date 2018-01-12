<?php

class RailwayLine
{
    private $lineID;
    private $lineName;

    /**
     * RailwayLine constructor.
     * @param $lineID
     * @param $lineName
     */
    function __construct($lineID, $lineName)
    {
        $this->lineID=$lineID;
        $this->lineName=$lineName;
    }
    
    function getNameByID($lineID,$database)
    {
		$QueryResults = $database->query("select name from RailwayLines where id='$lineID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getIDByName($lineName,$database)
    {
		$QueryResults = $database->query("select id from RailwayLines where name='$lineName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getNameByName($lineName,$database)
    {
		$QueryResults = $database->query("select name from RailwayLines where name='$lineName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    
    function getAll($lineID,$database)
    {
		$QueryResults = $database->query("select * from RailwayLines");
		$Row = $QueryResults->fetchAll(PDO::FETCH_NUM);
		var_dump($expression);
		return $Row;
    }
    

    function addRailwayLine($database)
    {
    	$database->query("insert into RailwayLines values(null,'$this->lineName')");
    }
    
    function deleteRailwayLine($database)
    {
    	$database->query("delete from RailwayLines where id = '$this->lineID'");
    }
}
?>