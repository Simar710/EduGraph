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

1. Log onto our server
2. Start up mysql on our server, use the password provided (pass1234)
3.  Type `USE cis3760;`. This will switch into the cis3760 database
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
4. To load data from the csv file:
```
LOAD DATA INFILE '/path/to/data.csv'
INTO TABLE your_table_name
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```
