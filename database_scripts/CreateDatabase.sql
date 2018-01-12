/*Specifies the database to be used */
USE t8005t06;


/*Creates a table of stations*/
CREATE TABLE Stations (
    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    mnemonic VARCHAR (4) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (mnemonic)
    ) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table of existing stations.';

/*Creates a table of railway lines*/
CREATE TABLE RailwayLines (
	id MEDIUMINT UNSIGNED AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    PRIMARY KEY (id),
    UNIQUE (name)
    ) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table of existing railway lines.';

CREATE TABLE Trains (
    id INT UNSIGNED AUTO_INCREMENT NOT NULL ,
    railwaylines_id MEDIUMINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (railwaylines_id)
  		REFERENCES RailwayLines (id)
        ON DELETE CASCADE
    ) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table of existing trains.';

/*Creates the TrainSchedules table: stores train schedule data which attributes a route to each station in the StationTrainSchedules table
Different trains may change schedules so this is a more flexible solution than assigning trains to stop at stations.
This solution also allows us to identify the whole route of a single train in a single journey (and minimizes routing issues of trains travelling to/from stations bi-directionally).*/
CREATE TABLE TrainSchedules (
	/*The id of the trains schedule*/
    id INT UNSIGNED AUTO_INCREMENT NOT NULL ,
    /*The id of the train to assign to a schedule.*/
    train_id INT UNSIGNED NOT NULL,
    /*Guarentees uniqueness that trains cannot have the same schedule.*/
    PRIMARY KEY (id, train_id),
    FOREIGN KEY (train_id)
         REFERENCES Trains (id)
        ON DELETE CASCADE
    ) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table assigning each train to an schedule, a schedule defines the route of a train.';


/*Creates the StationTrainSchedules table: stores schedule datetime data and joins the tables stations and a trains schedule as it travels along its route.
Allows for two trains to arrive/depart at the same time i.e. different Train Lines. */
CREATE TABLE StationTrainSchedules (
    /*The id of the station that the schedule belongs to.*/
    station_id INT UNSIGNED NOT NULL,
	/*The id of the trains schedule that is scheduled to stop at the station.*/
	trainschedule_id INT UNSIGNED NOT NULL,
    /*The arrival time of the train by that schedule at that station*/
    arrive_time DATETIME NOT NULL,
	/*The departure time of a train by that schedule at that station*/
    departure_time DATETIME NOT NULL,
    /*Primary key candidate is given by the uniqueness of the station and uniqueness of arriving/departing train schedule.*/
    PRIMARY KEY (station_id, trainschedule_id),
	FOREIGN KEY (station_id)
        REFERENCES Stations (id)
        ON DELETE CASCADE,
	FOREIGN KEY (trainschedule_id)
        REFERENCES TrainSchedules (id)
        ON DELETE CASCADE
	) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table assigning each trains schedule to an arrival/departure time at a station and each station to a schedule of trains with unique arrival/departure time for each train schedule.';
    
/*Creates the RailwayLinesStations table: assigns stations to railway lines at a relative position.*/
CREATE TABLE RailwayLinesStations (
	railwayline_id MEDIUMINT UNSIGNED NOT NULL,
    relative_position INT UNSIGNED NOT NULL,  
    station_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (railwayline_id, relative_position),
   FOREIGN KEY (railwayline_id)
        REFERENCES RailwayLines (id)
        ON DELETE CASCADE,
    FOREIGN KEY (station_id)
        REFERENCES Stations (id)
        ON DELETE CASCADE
    ) ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='Table of railway lines assigned to stations and stations assigned to railway lines.';


/*Creates the users table: stores user data (designed by Umit)..*/
CREATE TABLE users
(
    id INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    hash VARCHAR(32) NOT NULL,
    active BOOL NOT NULL DEFAULT 0,
PRIMARY KEY (id) 
);