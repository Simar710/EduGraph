- Link to website: [EduGraph](http://34.201.123.35/) 
*NOTE*: The above link may not work in the future. I may terminate the deployment on AWS depending on the resource consumption as I have acount with basic plan only on AWS.

# Intro and Set Up on local and on AWS.
### Have a look at other branches as well for progressive development of the project. The branches are named as sprint1, sprint2,... There were 9 sprints. All the sprints have their particular tasks and description. The main branch should have the final set up and all the necessary info.

### Project: EduGraph

   ### Summary:
   -   Created a full stack web application.
   -   Parsed the data into csv using python, developed a Python-based CLI and Excel UI using VBA scripts.
   -   Designed and Stored the data in a MySQL database.
   -   Architect the PHP REST APIs, establishing secure HTTP protocols for data exchanges between the client and server, featuring PHP full stack web applications for course recommendations,
   -   Vis.js is used to generate graphs and trees.
   -   Application is hosted using Nginx in AWS EC2 Instance as well as on local enviroment
   -   CI/CD pipeline is also set up using GitHub Action for GitHub and Gitlab CI/CD for Gitlab, with proper testing.
   -   Created and executed detailed test plans using TDD principles and Selenium for front-end automation.
   -   Implemented accessibility features (keyboard navigation, high-contrast theme) and ensured WCAG 2.1 compliance.
   -   Later on the whole application was configured to work AWS EC2 Instance. Details to setup on both, local and AWS, are mentioned in sections below.

  ### 1. **Course Data Management:**
  - Developed a Python-based CLI for parsing and searching course information, generating Excel outputs, and documenting sprint progress (Sprint 1 & 2).
  - Designed an Excel UI with VBA scripts to assess student eligibility for courses based on completed coursework (Sprint 2).

  ### 2. **Web and Database Integration:**
  - Created a web interface for downloading course data and viewing team member pages; enhanced with a MySQL database and PHP REST API for course data manipulation (Sprint 3 & 4).
  - Improved API endpoints, refactored code, and enhanced UI responsiveness and accessibility using Bootstrap; implemented automated testing (Sprint 5 & 7).

  ### 3. **Advanced Features and Optimization:**
  - Developed a full stack web application for course recommendations based on past sprints, utilizing self designed APIs (Sprint 6).
  - Implemented course prerequisite graphs and trees using Vis.js (Sprint 8).
  - Implemented dark mode, included and optimized website performance; established a CI/CD pipeline for continuous integration and testing (Sprint 8 & 9).

     ## Directory Structure Info:
  - *parser*: This directory contains python script to parse the data from txt file. Detailed info is in the README inside parser directory. Watch Demo to see how it works.
  - *searcher*: This directory contains the python script to perform search based on different criteria after parsing. Detailed info in the README in the search directtory. Wtach demo to see how it works.
  - *VBASprint2*: This directory contains the code to make make VBA UI. The UI is present in this folder. Detailed info in the README in the search directtory. Wtach demo to see how it works.
  - *sprint9*: All the final PHP, CSS scripts, detailed API and MySQL documentaion, Selenium Tests are written in this directory.

  *Note*: "All_course_Tree.side" will take around 2-3 min Safari to work and 5 min to work on Chrome as the script has to go through all the data ses and make connections and generate trees and graphs. In the demo the waiting part is skipped for the demo purposes.
     
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

# Running the Project on Cloud server.
## Deploying a PHP Website on AWS

Deploying a PHP website on AWS involves several steps, from setting up the infrastructure to configuring the web and database servers. Here’s a step-by-step guide to deploying your PHP website on AWS:

### 1. **Set Up an AWS EC2 Instance**

AWS EC2 (Elastic Compute Cloud) is a scalable compute resource that will host your website.

#### 1.1 **Create an EC2 Instance:**
- **Login to AWS Console** and navigate to **EC2**.
- **Launch an Instance** by selecting an Amazon Machine Image (AMI) like **Ubuntu Server**.
- Choose an **instance type**.
- Create or select a **Key Pair** (you will use this key to SSH into your instance).
- Configure security groups to allow inbound traffic on HTTP (port 80) and HTTPS (port 443), as well as SSH (port 22) for access.
- Launch the instance.

#### 1.2 **Get the Public IP or DNS of the Instance:**
After the EC2 instance is up, get the **public IP** or **public DNS** from the EC2 dashboard to access the instance.

#### 1.3 **Connect to Your EC2 Instance:**
Use SSH to connect to your instance:

```bash
ssh -i /path/to/your-key.pem ubuntu@your-instance-public-ip
```

### 2. Install Web Server (Nginx), PHP and MySQL
Now, you need to install Nginx to serve your PHP website and PHP-FPM to process PHP scripts.

1. Update the System:
```bash
sudo apt update && sudo apt upgrade -y
```
2. Install Nginx:
```bash
sudo apt install nginx -y
```
3. Install PHP and PHP-FPM:
```bash
sudo apt install php-fpm php-mysql php-cli -y
```
4. Install MySQL (or other database):
If you want to install MySQL on the same instance, you can do:
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```
Alternatively, you can use Amazon RDS (relational database service) for a managed database service.

5. Start Nginx and PHP-FPM Services:
```bash
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php7.4-fpm  # Adjust PHP version as necessary
sudo systemctl enable php7.4-fpm
```
6. Configure Nginx for PHP, using the following steps.

7. Create a Website Directory:
```bash
sudo mkdir -p /var/www/html/
```
8. Configure Nginx:
Create a new configuration file in /etc/nginx/sites-available/3760website (Copy from 3760website in sites-available folder from git repo):
```nginx
# AWS EC2 nginx config for website
server {
	listen 80;  # Change to port 80 for standard HTTP access
	server_name 34.201.123.35;  # Replace with your domain or public IP

	root /var/www/html;  # Replace with the actual path where you cloned your repo
	index index.php index.html index.htm;

	# Define location for each endpoint (similar to your macOS config)

	location /courses/getAllCourses/ {
		try_files $uri $uri/ /get_all_courses.php;
	}

	location /course_generator {
		try_files $uri $uri/ /404/index.php;
	}

	location /course_generator/genTree {
		try_files $uri $uri/ /404/index.php;
	}

	location /simar {
		try_files $uri $uri/ /404/index.php;
	}

	location /sara {
		try_files $uri $uri/ /404/index.php;
	}

	location /emily {
		try_files $uri $uri/ /404/index.php;
	}

	location /feekim {
		try_files $uri $uri/ /404/index.php;
	}

	location /maneesh {
		try_files $uri $uri/ /404/index.php;
	}

	location / {
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
		fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Adjust PHP version and socket path as needed
	}

	location ~ /courses/update/ {
		try_files $uri $uri/ /put_dbInfo.php;
		fastcgi_param REQUEST_METHOD $request_method;
		include fastcgi_params;
		fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Adjust PHP version and socket path as needed
	}

	location ~ /courses/delete/ {
		try_files $uri $uri/ /delete_course_by_code.php;
		fastcgi_param REQUEST_METHOD $request_method;
		include fastcgi_params;
		fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Adjust PHP version and socket path as needed
	}

	location /apidocs {
		try_files $uri $uri/ /apidocs.php;
	}

	# PHP Processing Block
	location ~ \.php$ {
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		fastcgi_index index.php;
		include fastcgi_params;
		fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Adjust PHP version and socket path as needed
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
	}
}
```
9. Enable the Nginx Configuration and Restart:
```bash
sudo ln -s /etc/nginx/sites-available/your_website_name /etc/nginx/sites-enabled/
sudo nginx -t  # Test the Nginx configuration
sudo systemctl restart nginx
```
10. Deploy Your Website Files (open the public ip address, which is mentioned in the EC2 instance)
11. Upload Your PHP Website Files:
You can use SFTP, SCP, or FTP to upload your website files to /var/www/html.
Alternatively, clone your website repository from GitHub and copy the html to /var/www/html/ directory:
```bash
git clone https://github.com/Simar710/EduGraph.git
sudo cp -r EduGraph/sprint9/sprint9-files/html /var/www
```


4.2 Set Correct Permissions:
Make sure the Nginx user has access to the files:
```bash
sudo chown -R www-data:www-data /var/www/html/your_website_directory
sudo chmod -R 755 /var/www/html/your_website_directory
```

12. After installing MySQL, follow the same steps as mentioned above to create the database and table. Make sure the php files, have the correct url where your website is deployed.