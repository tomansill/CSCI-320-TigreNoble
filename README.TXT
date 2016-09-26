Please read documentation for more information

Setup Instructions (For MAC)
1. Install XAMPP on the computer from https://www.apachefriends.org/download.html

2. After it has installed, set up xampp security (mysql server and xampp)  by running this command in the terminal: sudo /Applications/XAMPP/xamppfiles/xampp security. The instruction will pop up on the screen once you install xampp.
  
3. Install the project folder in XAMPP’s htdocs directory.

4. Navigate to Database/databaseConfig.php and Library/config.php. Supply your xampp’s  mysql username and password in the appropriate fields. 

5. Point your browser to localhost/path_of_the_project

6. To view the data:
	GUI: localhost/phpmyadmin
	Command Line below : http://community.sitepoint.com/t/mysql-command-prompt-on-mac-osx-using-xampp/2380

7. You won’t need to worry about populating the database. The moment you fired up localhost/path_to_project, the database automatically run dbAuth.php and populate the database on its own.

If you get any errors, make sure:
1.Make sure MySQL and Apache is up and running via XAMPP

2. If you get any error regarding “contact web master about database not being properly
 set up”, then go back to step 2 of the instructions.

3. Email to ksc2650@rit.edu
