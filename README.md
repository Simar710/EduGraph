### Have a look at other branches as well for progressive development of the project. The branches are named as sprint1, sprint2,... There were 9 sprints. All the sprints have their particular tasks and description. The main branch have changes from sprint 9 only.
### Project: EduGraph

   ### Summary:
   -   Created a web application with team.
   -   Parsed the data into csv using python, developed a Python-based CLI and Excel UI using VBA.
   -   Stored the data in a MySQL database and architect the PHP REST APIs, featuring PHP web applications for course recommendations, prerequisite graphs, hosted using Nginx and a CI/CD pipeline for enhanced functionality and reliability.
  ### 1. **Course Data Management:**
     - Developed a Python-based CLI for parsing and searching course information, generating Excel outputs, and documenting sprint progress (Sprint 1 & 2).
     - Designed an Excel UI with VBA scripts to assess student eligibility for courses based on completed coursework (Sprint 2).

  ### 2. **Web and Database Integration:**
     - Created a web interface for downloading course data and viewing team member pages; enhanced with a MySQL database and PHP REST API for course data manipulation (Sprint 3 & 4).
     - Improved API endpoints, refactored code, and enhanced UI responsiveness and accessibility using Bootstrap; implemented automated testing (Sprint 5 & 7).

  ### 3. **Advanced Features and Optimization:**
     - Developed a web application for course recommendations based on past coursework, utilizing external APIs (Sprint 6).
     - Implemented course prerequisite graphs, dark mode, and optimized website performance; established a CI/CD pipeline for continuous integration and testing (Sprint 8 & 9).
     
# Setting up MySQL, PHP, and NGINX on MacOS
### Note: YOU NEED HOMEBREW FOR ALL OF THIS
### Note2: IF ON LINUX, STEPS ARE SIMILAR EXCEPT FOR THE PATHS AND PACKAGE MANAGER COMMANDS
### Note3: IF YOU ARE ON AN INTEL MAC, THE PATH `/opt/homebrew` WILL NOT EXIST, IT IS `/usr/local` INSTEAD

### Set up MySQL

# Setting up MySQL and using our database in order to retrieve course information

## Note: I used the CSV file generated from sprint 2 (modified in sprint 3), to populate the table in our database

## Note: The database name is 'cis3760', the table name is 'coursesDB'.

### Set up MySQL

1. `brew install mysql`
2. `brew services start mysql`
3. `mysql -V` to check version
4. `mysql -u root`
5. Now should be in an interactive terminal and can run sql scripts

### Accessing the populated table within the database


1. Start up mysql on local, using the above steps.
3. Type `USE cis3760;`. This will switch into the cis3760 database (Create table and database, using the steps in the sections below)
4. `SHOW TABLES;` will list all the tables within our database. Our complete tablle is called `coursesDB`. The other table `coursesToDELETE`, is the table we will use in our DELETE API calls for testing purposes. Both tables are fully populated from the CSV file.
5. In order to view our tables, you can type `SELECT * FROM <tablename>`


### Create a databse with a table
1. Type `CREATE DATABASE <database name>;`
2. To switch to the newly created database: `USE <database name>;`
3. To create the structure of the database and its columns:
```
CREATE TABLE <tablename> (
    column1_name data_type,
    column2_name data_type,
    column3_name data_type,
)
```
In our case it will be,
```
CREATE TABLE coursesDB (     
    courseCode VARCHAR(20),     
    courseName VARCHAR(255),     
    prerequisites TEXT,     
    restrictions TEXT );
```
4. To load data from the csv file:
```
LOAD DATA INFILE '/path/to/data.csv'
INTO TABLE your_table_name
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

### Set up PHP

1. `brew install php`
2. `brew services start php`
3. `php -v` to check version

### Set up NGINX

1. `brew install nginx`
2. `brew services start nginx`
3. Copy this nginx config into `/opt/homebrew/etc/nginx/nginx.conf` or `/usr/local/etc/nginx/nginx.conf`

-   NOTE: If you are on intel, anywhere you see /opt/homebrew, the path should be /usr/local in this config

```nginx
events {
    # This can be left empty or configured with additional directives
    worker_connections 1024; # Example setting for handling connections
}

http {
    server {
        listen 8082;
        root /opt/homebrew/var/www/html;

        index index.php index.html index.htm;

        location /courses/getAllCourses/ {
            try_files $uri $uri/ /get_all_courses.php;
        }

        location /course_generator {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }
        location /course_generator/genTree {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /simar {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /sara {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /emily {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /feekim {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /maneesh {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location / {
          # First attempt to serve request as file, then
          # as directory, then fall back to displaying a 404.
          try_files $uri $uri/ /404/index.php;
        }

        location /courses/getAllCoursesCopy/ {
          try_files $uri $uri/ /get_all_courses_copy.php;
        }
		
        location /courses/getSubjects/ {
          try_files $uri $uri/ /get_subjects.php;
        }

	      location /courses/getCoursesByPrereq/ {
          try_files $uri $uri/ /get_courses_by_prereq.php?$args;
        }
	
        location /courses/getCoursesByRestrictions/ {
          try_files $uri $uri/ /get_courses_by_restrict.php?$args;
        }

		    location /courses/getCoursesBySubject/ {
          try_files $uri $uri/ /get_courses_by_subject.php?$args;
        }
	
        location /courses/getCourseByCode/ {
          try_files $uri $uri/ /get_course_by_code.php?$args;
        }

        location /courses/getCourseByName/ {
          try_files $uri $uri/ /get_course_by_name.php?$args;
        }

        location ~ /courses/postCourses/ {
          try_files $uri $uri/ /post_courses.php;
          fastcgi_param REQUEST_METHOD $request_method;
          include fastcgi_params;
          fastcgi_pass 127.0.0.1:9000;
        }

	      location ~ /courses/update/ {
          try_files $uri $uri/ /put_dbInfo.php;  
          fastcgi_param REQUEST_METHOD $request_method;
          include fastcgi_params;
          fastcgi_pass 127.0.0.1:9000;
        }

	      location ~ /courses/delete/ {
          try_files $uri $uri/ /delete_course_by_code.php;
          fastcgi_param REQUEST_METHOD $request_method;
          include fastcgi_params;
          fastcgi_pass 127.0.0.1:9000;
        }
        
	      location /apidocs {
          try_files $uri $uri/ /apidocs.php;
        }
    
        location ~ \.php$ {
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
        }
    }
}
```

4. Make sure you are up to date on the main branch
5. Copy the html folder from the sprint9 files into `/opt/homebrew/var/www/` or `/usr/local/var/www/` on intel by doing `cp -r html /opt/homebrew/var/www/`
    - It contains a new file called `db_connection.php` that defines two functions, one that opens the db connection and one that closes it
    - It also contains a file called `get_all_courses.php` which just calls the open connection function inside `db_connection.php`
6. Run `sudo nginx -t` and make sure there are no errors
7. Run `brew services reload nginx`
8. You _should_ be able to navigate to and see the page
9. You _should_ also be able to navigate to http://localhost:8082/courses/getAllCourses/ and see "Connected Successfully" meaning the mysql db connection worked!

-   **NOTE**: When you create php files, use snake_case and then the corresponding endpoint in nginx should be camelCase (keeps everything consistent)
