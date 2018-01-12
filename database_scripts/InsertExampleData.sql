/*Please be advised this example data does not reflect the example railway line provided by N.E.R.D (has many more confusing connections to test the routing algorithm).
This example data will create a series of journeys from York towards Haymarket.*/

/*Specifies the database schema to be used */
USE t8005t06;

/*Populates Stations [For Line A]*/
INSERT INTO Stations VALUES 
(NULL, 'York', 'YRK'), (NULL, 'Darlington', 'DAR'), (NULL, 'Newcastle', 'NCL'), (NULL, 'Berwick-upon-Tweed', 'BWK'),
(NULL, 'Dunbar', 'DUN'), (NULL, 'Edinburgh', 'EDB'),(NULL, 'Haymarket', 'HYM');  


/*Populates Stations [For Line B]*/
INSERT INTO Stations VALUES
(NULL, 'Northallerton', 'NTR'), (NULL, 'Durham', 'DUR'), (NULL, 'Sunderland', 'SUN'), (NULL, 'Morpeth', 'MPT'),  (NULL, 'Alnmouth', 'ALM'),
 (NULL, 'Motherwell', 'MTH'), (NULL, 'Glasgow', 'GLC');


/*Populates Stations [For Line C]*/
INSERT INTO Stations VALUES 
(NULL, 'Stirling', 'STR'), (NULL, 'Perth', 'PTH'), (NULL, 'Haymarket', 'HY'), 
(NULL, 'Kingussie', 'KIN'), (NULL, 'Aviemore', 'AVM'), (NULL, 'Inverness', 'IVR'),

/*Populates Stations [For Line D]*/
(NULL, 'Inverkeithing', 'INV'), (NULL, 'Leuchars', 'LEU'), (NULL, 'Dundee', 'DEE'), 
(NULL, 'Montrosse', 'MTS'), (NULL, 'Aberdeen', 'ABD');


/*Populates RailwayLines*/
INSERT INTO RailwayLines VALUES
(NULL, "Line A"), (NULL, "Line B"),(NULL, "Line C"),(NULL, "Line D");


/*Populate RailwayLinesStations (id, station position, station ID)*/
INSERT INTO RailwayLinesStations VALUES
#York. Station ID 1.
(1,1,1),(2,1,1),
#Darlington. StationID 2.
(1,2,2),(2,3,2),
#Newcastle. Station ID 3.
(1,3,3),(2,5,3),
#Berwick Upon Tweed.
(1,4,4), 
#Dunbar
(1,5,5),
#Edinburgh
(1,6,6),(2,9,6),
#Haymarket 
(1,7,7),(2,10,7),(3,1,7),(4,1,7),
#Northallerton
(2,2,8),
#Durham
(2,4,9),
#Sunderland 
(2,6,10),
#Morpeth
(2,7,11),
#Alnmouth
(2,8,12),
#Motherwell
(2,11,13),
#Glasgow
(2,12,14),
#Stirling
(3,2,15),
#Perth
(3,3,16),
#Haymarket
(3,4,17),
#Kingussie
(3,5,18),
#Aviemore
(3,6,19),
#Inverness
(3,7,20),
#Inverkeithing
(4,2,21),
#Leuchers
(4,3,22),
#Dundee
(4,4,23),
#Montrosse
(4,5,24),
#Aberdeen
(4,6,25);

/*Populate Trains*/
INSERT INTO Trains VALUES
(NULL, 1), (NULL, 2),(NULL,3),(NULL,4);

/*Populate TrainsSchedules*/
INSERT INTO TrainSchedules VALUES
(NULL,1),(NULL,2),(NULL,3),(NULL,4);

/*Populate StationsTrainsSchedules*/
INSERT INTO StationTrainSchedules VALUES

/*Train 1, Line A towards Haymarket[connecting] from 9:00*/
(1,1, '2017-04-23 9:00:00', '2017-04-23 9:02:00'),(2,1, '2017-04-23 9:04:00','2017-04-23 9:06:00'),
(3,1, '2017-04-23 9:08:00','2017-04-23 9:10:00'), (4,1, '2017-04-23 9:12:00', '2017-04-23 9:14:00'),
(5,1, '2017-04-23 9:16:00','2017-04-23 9:18:00'), (6,1, '2017-04-23 9:20:00','2017-04-23 9:22:00'),
(7,1, '2017-04-23 9:24:00','2017-04-23 9:26:00'),
/*Train 2, Line B towards Haymarket[connecting] from 9:00*/
(1,2, '2017-04-23 9:00:00', '2017-04-23 9:02:00'),(8,2, '2017-04-23 9:04:00','2017-04-23 9:06:00'),
(2,2, '2017-04-23 9:08:00', '2017-04-23 9:10:00'),(9,2, '2017-04-23 9:12:00','2017-04-23 9:14:00'),
(3,2, '2017-04-23 9:16:00','2017-04-23 9:18:00'), (10,2, '2017-04-23 9:20:00','2017-04-23 9:22:00'),
(11,2, '2017-04-23 9:24:00','2017-04-23 9:26:00'),(12,2, '2017-04-23 9:28:00','2017-04-23 9:30:00'),
(4,2, '2017-04-23 9:32:00','2017-04-23 9:34:00'),(5,2, '2017-04-23 9:36:00','2017-04-23 9:38:00'), 
(6,2, '2017-04-23 9:40:00','2017-04-23 9:42:00'), (7,2, '2017-04-23 9:44:00','2017-04-23 9:46:00'),
(13,1, '2017-04-23 9:48:00','2017-04-23 9:50:00'), (14,1, '2017-04-23 9:52:00','2017-04-23 9:54:00'),
/*Train 4 Line C towards Inverness */
(7, 3, '2017-04-23 9:48:00','2017-04-23 9:50:00'), (15,3, '2017-04-23 9:52:00','2017-04-23 9:54:00'), 
(16,3, '2017-04-23 9:56:00','2017-04-23 9:58:00'), (17,3, '2017-04-23 10:00:00','2017-04-23 10:02:00'),
(18,3, '2017-04-23 10:04:00','2017-04-23 10:06:00'),(19,3, '2017-04-23 10:08:00','2017-04-23 10:10:00'),
(20,3, '2017-04-23 10:12:00','2017-04-23 10:14:00'),
/*Train 4 Line D towards Aberdeen */
(7,4, '2017-04-23 9:48:00','2017-04-23 9:50:00'), (21,4, '2017-04-23 9:52:00','2017-04-23 9:54:00'), 
(22,4, '2017-04-23 9:56:00','2017-04-23 9:58:00'), (23,4 ,'2017-04-23 10:00:00','2017-04-23 10:02:00'),
(24,4, '2017-04-23 10:04:00','2017-04-23 10:06:00'),(25,4, '2017-04-23 10:08:00','2017-04-23 10:10:00');
