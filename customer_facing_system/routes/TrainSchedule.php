<?php

// The TrainSchedule class models a trains route (as it goes through its schedule). Please see the readme for more details on this.
class TrainSchedule extends SplDoublyLinkedList
{

    public $toString;
    private $trainScheduleId;

    /**
     * TrainSchedule constructor.
     * @param $trainScheduleId
     */
    public function __construct($trainScheduleId)
    {
        $this->$trainScheduleId = $trainScheduleId;
        $this->toString = 'TrainSchedule ID: ' . $this->getTrainScheduleId();
    }


    /**
     * Returns the train schedule ID.
     * @return mixed
     */
    function getTrainScheduleId()
    {
        return $this->trainScheduleId;
    }


    /**
     * Offset set override.
     * @param mixed $key
     * @param mixed $val
     */
    public function offsetSet($key, $val)
    {
        if ($val instanceof StationStop) {
            return parent::offsetSet($key, $val);
        }
        throw new InvalidArgumentException('Value must be a StationStop');
    }

    /**
     * Returns the first event of the schedule.
     * @return mixed|null
     */
    function getFirstItem()
    {
        if ($this->offsetExists(0)) {
            return $this[0];
        } else {
            echo "Error, called $this getFirstItem (but the list is empty)";
            return null;
        }
    }

    /**
     * Returns the next connection of the train (the next time-expanded station stop the train will visit if at all).
     * @param $inStationStop
     * @return mixed|null
     */
    function getStationConnection($inStationStop)
    {
        /*In our case all the station connections available are the trains ahead*/
        $neighborUp = null;
        foreach ($this as $key => $stationStop) {
            /*Objects are equal if and only if they are the same instance of the same class in PHP, which is fine.*/
            if ($inStationStop == $stationStop) {
                /*Stations connect to the train above*/
                if ($this->offsetExists($key + 1)) {
                    $neighborUp = $this->offsetGet($key + 1);
                }
            }
        }
        return $neighborUp;
    }

    /**
     * Given a station ID will return whether or not the train is scheduled to visit that station (identifiable by its ID).
     * @param $stationId
     * @return bool
     */
    function hasStationId($stationId)
    {
        foreach ($this as $stationStop) {
            $searchId = $stationStop->getStationId();
            if ($stationId == $searchId) {
                return true;
            }
        }
        return false;
    }

    /**
     * Given a station ID returns the station schedule object when the train is due to arrive at that station if at all.
     * @param $stationId
     * @return mixed|null
     */
    function getStationById($stationId)
    {
        foreach ($this as $stationStop) {
            if ($stationId == $stationStop->getStationId()) {
                return $stationStop;
            }
        }
        print "Station ID " . $stationId . " not found";
        return null;
    }

    /**
     * Given a station scheduled, identifies whether that station scheduled (if it exists in the schedule) has any connecting stations scheduled.
     * In other words whether a train is due to arrive at one station at a particular time, and if so does it have any neighboring connections.
     * @param $inStationStop
     * @return bool
     */
    function hasStationConnection($inStationStop)
    {
        foreach ($this as $key => $stationStop) {
            /*Objects are equal if and only if they are the same instance of the same class in PHP, which is fine.*/
            if ($inStationStop == $stationStop) {
                /*Stations connect to the train above*/
                if ($this->offsetExists($key + 1)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Overrides the toString method.
     * @return string
     */
    function __toString()
    {
        return $this->toString;
    }
}