I'm new to PHP. In this task, I used php to code for server side process.
I connected MongoDB with PHP. Using composer,pecl to integrated the MongoDB.
For Mysql, XAMPP provided the environment for the Mysql Database.

I know how to use redis for session management in ExpressJS(NodeJS).
Now, I'm learning how to implement redis with PHP for this project.


For run this project, clone this repository and use XAMPP control panel for php usage.

Put the project in htdocs folder.
Requires extensions for connecting MongoDB,Redis.
Add required extensions in the "ext" folder.
Update it in php.ini file.

Run Apache, Mysql to start the server.

For setup the database, go to http://localhost/phpmyadmin/
  (*) create db as "register_details".
  (*) create table as "users" 
  (*) Number of columns as 5
  (*) id, name, email, address, password.
  
For visiting home page, go to http://localhost/task/index.html
