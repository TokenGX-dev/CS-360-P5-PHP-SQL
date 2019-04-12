THIS FOLDER (NAME FOLDER uMovies) SHOULD BE PLACED IN HTDOCS WITHIN THE XAMPP DIRECTORY

Running the Files
 - To run the files, have the XAMPP Apache and MySQL servers running (using the XAMPP Control Panel)
 - To display a page, go to localhost/uMovies/filename.(html/php)
 - To go to the home directory, go to localhost/uMovies

Files Specifics
 - index
	- This is the home directory
	- NO CHANGES SHOULD BE MADE TO THIS FILE
	- Use as a reference for code
 - movies
	- PHP file that lists all the movies in the database
	- NO CHANGES SHOULD BE MADE TO THIS FILE
	- Use as a reference for code
 - movie
	- PHP file that provides information about a specific movie
	- NO CHANGES SHOULD BE MADE TO THIS FILE
	- Use as a reference for code
 - actors (NEEDS WORK)
	- PHP file that lists all actors in the database
	- Should display name and gender
	- Names should have hyperlinks to specific actors
 - actor (NEEDS TO BE MADE)
	- PHP file that provides information about a specific actor
	- Should display name, gender, movies, and roles
 - directors (NEEDS WORK)
	- PHP file that lists all directors in the database
	- Should display name
	- Names should have hyperlinks to specific directors
 - director (NEEDS TO BE MADE)
	- PHP file that proves information about a specific director
	- Should display name and list movies directed
 - admin (DONE)
	- HTML file that handles the password verification
	- Either admits to Administrator Menu or says "Incorrect Password"
	- Must also display message if no password is indicated
 - adminMenu (NEEDS WORK)
	- PHP file that handles the Admin Menu
	- Gives option to upload file or delete all information
	- Passes upload data to adminUpload
	- Passes data deletion to adminDelete (TODO)
 - adminUpload (NEEDS WORK)
	- PHP file that handles data upload
	- Displays the data uploaded
	- Option to return to Admin Menu
 - adminDelete (NEEDS TO BE MADE)
	- PHP file that handles data deletion
	- Option to return to Admin Menu
