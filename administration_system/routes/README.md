## Details about this solution ##


Title: Routes
Author: Callum Dempsey Leach (B6070824)
Summary: Routes is an object oriented solution to the routing problem. The objective of Routes is to attain the fastest route given input data (based on URL).


## Section 1: Introduction and thinking about the solution ##

As outlined in CSC8004, the classical graph for applying a shortest path algorithm defines a graph and a series of vertex's. We would say each vertex represents a station and each edge connecting vertex's represents a cost. We would implement Dijkstra's algorithm to obtain the fastest routes between these vertex's and those costs. However we have identified this solution is not entirely suitable to solve the problem. To illustrate you can't just grab a train from any moment in time from vertex A and go to vertex B.
Instead our database provides a timetable of information i.e.

```
Train | Station | Arrive | Depart 
===================================
1     | A       | 10:30  | 11:00
1     | B       | 11:30  | 12:00
```

If we think about the problem this table can be used to model the route of a train as it traverses through a route of stations on its schedule. This opens the possibility of adopting a different approach to modelling the problem. Instead of having a graph modelling stations as a series of vertex's we model the vertex's as time-event information. To illustrate using the same information above.

```
Vertex | Information
======================
1      | Station A, Arrives at 10:30, Departs at 11:00
2      | Station B, Arrives at 11:30, Departs at 12:00
```

A connection between those edges i.e. 1 and 2, similarly, represents the route of the station as it traverses the network of those events. I credit the idea to create a node network of train arrival and departure information to Matthias Muller-Hannemann Frank Schulz, Dorothea Wagner and, Christos Zaroliagis. In their excellent paper "Timetable Information: Models and Algorithms" they  posited in their "time-expanded" approach that it is possible to connect every node or vertex to a specific time and events such that any edges connecting those times and events can be used to determine a "route" (Muller-Hannemann et al., p.3, 2017). I would encourage any enthusiast about this solution to read that paper.

Let's recap. The classical approach models edges and vertex's as a graph based solution. However by adopting the time-expanded approach the solution becomes much simpler and friendly to newer programmers: instead of virtualising a graph in code (i.e. having a "graph" object as a data structure found in many approaches to solving this problem), we can represent the information more elegantly and more simply as a tuple...

```
Route A. Train 1.
==========
(1      | Station A, Arrives at 10:30, Departs at 11:00), (2      | Station B, Arrives at 11:30, Departs at 12:00).
```

So using tuples and adopting the approach outlined by Muller-Hannemann et al, similarly to the classical approach we are able to represent the information of vertex's and edges. A collection of those routes can be used to model numerous different trains and stations. Similarly this can be used to model connections between those stations by adding railway line information. To illustrate consider the following...

```
Route A. Train 1 (Railway Line A).
==========
(1      | Station A, Arrives at 10:30, Departs at 11:00), (2      | Station B, Arrives at 11:30, Departs at 12:00).

Route B. Train 2 (Railway Line B).
==========
(1      | Station B, Arrives at 11:30, Departs at 12:00), (2      | C , Arrives at 12:10, Departs at 12:15).
```

We can see that a train from Route A has event information such that we arrive at Station B at 11:30. We can also see from Route B has event information such that we arrive at Station B at 11:30. Since the train departing Route B departs at a later time than the arrival time of the train departing from Route A, we can know that it must be the case that there exists a connection between those two stations. For a more formal approach this is "modus tollens". If there are no station connections, then it cannot be true trains arrive at the station from two different routes allowing passengers to traverse from one route to another (because the stations don't connect). In the above model (Route A, and Route B) we can see that the negation of the consequent is true: we are able to arrive at Station B at 11:30 and change to a different train following a different route. Therefore it must be the case that those stations connect. 

This reasoning is useful for back end development: as long as we can know there exist trains travelling routes from different railway lines connecting passengers at a station, what stations connect what railway lines can be made arbitrary: since there exists a connection as far as routing is concerned, a back-end developer or user interface developer only needs to make sure trains and stations are on the same railway line when assigning these routes (assigning a literal "connecting station" is not necessary as it is implicit).    

The question is, then, what is the earliest time we can get to arrive at one station from another station? How do we identify the fastest time? Using the time-expanded approach the solution is simple: the fastest route from Station A at 10:30 to Station C is such that it is the earliest arrival time at Station C reachable from the time-expanded node at Station A (Muller-Hannemann et al., p.3, 2017). 

## Section 2: Algorithm Design ##

Since each connecting node representing time-event information is connected by an edge, a solution to discover what nodes can be said reachable by the edges (as defined in the tuples) is much simpler than Djekstra's. Another way of thinking about the graph of time-extended nodes and edges is to take advantage of the idea that they are bi-directional: if an edge represents the event information of a train from an originating station A at 10:00, and a destination Station C at 12:00 can be said reachable then we can know there are no possible paths which ought to connect those nodes to each other in the reverse order (or in other words it does not travel backwards in time). As a result of this another way we can think about the topology of our nodes and edges is as a tree. Conveniently, a well known available solution for traversing a pre-ordered tree to find information is a depth first search (Dept. Information & Computer Science, 2017). Therefore we are able to use a simple depth first search algorithm as a simple tool to answer this question. Based on this, some rough pseudo-code (or steps) used to traverse the topology is as following...

1. Define a stack.
2. Define a list of seen nodes.
3. Push into the stack the first node we want to traverse.
4. While the stack is not empty...
Define "vertex" = the top node of the stack.
Pop the top node from the stack.
Add to the stack all the neighbors of vertex that aren't in seen

Recall “Section 1's” illustrative example of node and edges (below). 

```
Route A. Train 1 (Railway Line A).
==========
(1      | Station A, Arrives at 10:30, Departs at 11:00), (2      | Station B, Arrives at 11:30, Departs at 12:00).

Route B. Train 2 (Railway Line B).
==========
(1      | Station B, Arrives at 11:30, Departs at 12:00), (2      | C , Arrives at 12:10, Departs at 12:15).
```

Recall the problem, how to arrive at the fastest possible route to the destination. To answer this question, using the depth first search algorithm we can know that station A has a neighbor such that it arrives at Station B. Additionally as outlined in “Section 1”, we can know that if a train arrives at Station B at 11:30, since it is at the same station as a train on another route, we can define that other train on another route as a connecting train (and thus Station B connects "Railway Line A" and "Railway Line B").

We should now raise this does not necessarily solve the problem. The problem is to find the fastest route between one station and another. But recall our definition from the closing remarks of “Section 1”: the fastest route from Station A at 10:30 to Station C is such that it is the earliest arrival time at Station C reachable from the time-expanded node at Station A. Therefore, the only simple extra step required now we have traversed the graph and identified all the nodes reachable from "Station A" is to see which of those nodes are the earliest arriving node to "Station C", and return the route travelled to achieve that. 
As a developers note, I have found (after about four weeks of trail and error) the most elegant method to return the route from "Station A" to "Station C" is as follows... For each neighbor (or connection) of the time-expanded node currently being investigated (defined "vertex" in the pseudo-code), annotate in each of those neighbors (that is "ahead of time") that we are able to arrive those time-expanded nodes from "vertex" (using list based solution trying to record the path caused some algorithmic chaos in keeping track of what the last node was in a while loop). We are then able to simply pick out the earliest arriving node from the seen nodes (if it exists at all), and trace back to the root time-expanded node. Since it is the earliest arrival node, we don't really need to concern ourselves with *how* we get back to "Station A at 10:30", because we know by definition it must be the earliest arrival time.

## Section 3: Implementation ##

Using the above algorithmic design I was able to translate this into an object oriented solution using various real world entities (train schedules and stops). Painfully, type hinting is not allowed in PHP so a best effort has been made to design the following structure using its libraries...
Beyond parsing information the algorithm conceptually makes use of three concepts (classes to be instantiated), these are...
- StationStop defines time-expanded event information: the station scheduled to arrive and depart from, the arrival time of the event, the departure time of the event.
- Train Schedule defines an single route as a tuple of Station Schedule Nodes.
- Train Schedules defines a collection of train schedule objects.
Using this approach, a train has a schedule where it travels along a route between stations, and collections of those schedules can be used to determine the connections between routes i.e. if a train arrives at a station from one route, then at that station it must connect with all proceeding routes from that time of arrival (see Section 2 for more details on this).

# Bibilography

Dept. Information & Computer Science, (2017). ICS 161: Design and Analysis of Algorithms Lecture notes for February 15, 1996. [online] Available at: https://www.ics.uci.edu/~eppstein/161/960215.html [Accessed 1 May 2017].
Muller-Hannemann, M., Schulz, F., Wagner, D. and Zaroliagis, C. (2017). Timetable Information: Models and Algorithms. [online] Available at: http://i11www.iti.kit.edu/extra/publications/mswz-tima-06.pdf [Accessed 1 May 2017].
