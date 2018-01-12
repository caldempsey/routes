<?php

// The StationStop class delivers an object oriented time-expanded node. Please see the readme for more details on this.
class StationStop
{
    public $toString;
    private $stationId;
    private $stationName;
    private $arrivalDateTime;
    // There can only be one node from since the train schedule defines a bi-lateral (one way) relationship between connecting nodes on a single schedule (trains can't go back in time).
    private $departureDateTime;
    private $nodeFrom;

    /**
     * StationStop constructor.
     * @param int $stationId
     * @param String $stationName
     * @param DateTime $arrivalDateTime
     * @param DateTime $departureDateTime
     */
    public function __construct($stationId, $stationName, $arrivalDateTime, $departureDateTime)
    {
        $this->stationId = $stationId;
        $this->stationName = $stationName;
        $this->arrivalDateTime = $arrivalDateTime;
        $this->departureDateTime = $departureDateTime;
        $this->nodeFrom = null;
        $this->toString = 'Station Name: ' . $this->getStationName() . '. Arrival DateTime: ' . $this->getArrivalDateTime()->format('Y-m-d H:i:s') . '. Departure DateTime: ' . $this->getDepartureDateTime()->format('Y-m-d H:i:s') . '.';
    }

    /**
     * Returns the name of the station.
     * @return mixed
     */
    public function getStationName()
    {
        return $this->stationName;
    }

    /**
     * Returns the arrival date and time.
     * @return DateTime
     */
    public function getArrivalDateTime()
    {
        return $this->arrivalDateTime;
    }

    /**
     * Returns the departure time and date.
     * @return string
     */
    public function getDepartureDateTime()
    {
        return $this->departureDateTime;
    }

    /**
     * Returns the station ID of the arrival event.
     * @return int
     */
    public function getStationId()
    {
        return $this->stationId;
    }

    /**
     * Overrides the toString method.
     * @return string
     */
    function __toString()
    {
        return $this->toString;
    }

    /**
     * Returns the node that this node can be reached from.
     * @return mixed
     */
    public function getNodeFrom()
    {
        return $this->nodeFrom;
    }

    /**
     * Sets the node that this event node can be reached from.
     * @param mixed $nodeFrom
     */
    public function setNodeFrom($nodeFrom)
    {
        $this->nodeFrom = $nodeFrom;
    }

}