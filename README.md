Author: Team 6.
==============

What's included in this package?
==============

This package includes an administration system, a customer facing system (passengers), database scripts, and a registration system.

- The administration system is designed for any administrators to be able to administrate over the solution.
- The database scripts are designed so the backend can be implemented as easily as possible for the administrative users.
- The registration system is intended for some but not all administrators of the system. To illustrate there may be support staff using the administration system who we do not want to give access to create accounts for new users (as reserved for supervisors). This system also comes bundled with a test harness allowing you to test logons without having to swap systems.
- The customer facing system is the system intended to be designed by passengers.

How to install this package?
=============

This package is largely PHP based and such you will need to host the solution as a dedicated webserver and a local MySQL database with the following details.

Schema: t8005t06
Username: t8005t06
Password: (see PHP code [I don't want students snooping around here and discovering details]).

I would recommend XAMPP as a webserver hosting package for development (it served us very well) https://www.apachefriends.org/index.html.  

You are welcome to use the solution on our web-front http://homepages.cs.ncl.ac.uk/2016-17/csc8005_team06/.
If you do so please be advised this folder has been used as for demonstrating purposes only and whilst best effort has been made to ensure the content is apt for you to test there may be issues such as no trains or stations after the date you are marking (we would recommend you create an account or look up trains departing after April 1st).
Since we are demoinstrating the solution to both Marie and Dan we will be making changes to this folder. 
As I write this our testing directory "testing" still exists on the webserver (lots and lots of old code and old ideas) so please keep this in mind if you do decide to go this route.

Additional comments
=============

We would like to make you aware as a team we modularized the solution so that we could be responsible for working on different aspects of the solution (and testing individually before integration).
You will find we designed our solution to be as easily integratable as possible. As far is code is concerned please see the use of PHP heads to demonstrate this (we designed in such a way we would all be using the same assets as "pointed to" by the heads served by the PHP).
If you need any assistance please use the contact methods provided or see the helpful user guides we have implemented. 
We have also provided a development guide to ease understanding of how our algorithm works.

We here at Team 6 hope you enjoy our solution! 