The Krace Gennedy Weather mailing system is a PHP script that sends employee weather schedule updates in perpetuity
to increase the workload and efficiency of the employees at Krace Gennedy Locations

To run the application either:

1. Deploy to the public folder of a web server and navigate to the public url (or ip) for the server through a web browser.
2. navigate to the project root folder using the console on a machine with php installed, and run the command php -f index.php

The script is able to run in perpetuity if not stopped and will send emails at 4 a.m. each day after the initial start

N.B. :

1. This application though efficient is not optimized, as multi-threaded has not been enabled by default to enable multi-threading and increase efficiency of the program, the PEAR exentsion pthread should be installed and configured. Subsequenty some changes in class EmailBuilder will have to be made. Further more to increase efficiency, scheduling jobs instead of the currently implemented sleep method would be optimal. The above steps were not implemented as they'd require direct access to the environment on which the application is being deployed, thus the solution is left as is.

2. The config/config.php file of this project contains many values that in a deployment environment should be stored as encrypted environmental variables for security purposes. However for this specific usage, these are left as plain text.

3. All non it roles are indicated as non-it roles in the dataset. Therefore any role not labeled as such is regarded as an IT position in the scope of this application.


Author: emilekeith3.0@gmail.com
Date: 23/3/2017
