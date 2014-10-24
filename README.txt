This file explaines how you can run this project on your own machine.

What I tried on my mother's computer to install XAMPP and make a new database called "club".
Then I copied the project folder into XAMPP htdocs folder.

Then I selected the new database and imported the file clubfinal.sql from into the database with button import and browse the file.
After that the database was fully populated with all the table structures and an administrator user.

Of course You have to edit the start of rows(4th in index.php, 5th in enter.php and 69th in admin.php )which contains host location(in the case is localhost 
but is supposed to be the IP of the host), 
username and password of your server, and database name which is what you created before("club").