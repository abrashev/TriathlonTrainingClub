TriathlonTrainingClub

Web application for triathlon athletes who need to train by themselves. 
The final version of the project is an easy to use, good looking web page with a lot of functionality. 
All members have access to the system all the times and athletes are notified for new club information 
regarding their tasks. 

The most important which make this project worthwhile is the technology that has been used.
Most of the functionalities are executed client-side, but some things are processed on the server. 
The training system is implemented using jQuery libraries, Ajax and basic Javascript have been used
very efficiently and are well implemented in the web page as well as the HTML5 language.
I used JSON for storing and exchanging session information.
The PHP language has been used to execute all commands needed to insert or 
read some information from the MySQL database.
This file explaines how you can run this project on your own machine.

I installed XAMPP and made a new database called "club".
Then I copied the project folder into XAMPP htdocs folder.

Then I selected the new database and imported the file clubfinal.sql from into the database with button import and browse the file.
After that the database was fully populated with all the table structures and an administrator user.

Of course You have to edit the start of rows(4th in index.php, 5th in enter.php and 69th in admin.php )which contains host location(in the case is localhost 
but is supposed to be the IP of the host), 
username and password of your server, and database name which is what you created before("club").
