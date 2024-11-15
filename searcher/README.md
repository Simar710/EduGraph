### Compiling and Running

-   Ensure you have python3 installed on your machine
-   Navigate to the search directory and run the script by typing `python3 search.py` in your terminal
-   Make sure to have run the `main.py` script inside the parser directory as we are reading the csv file that gets generated from it
-   A menu will be displayed to select the option you want to go for

### Approach

-   The approach we took for the Search CLI is to get the csv file from the parser directory where the text file has been parsed
-   We wrote the command line UI search as a menu where the user can have different options

-   This is our menu 

 ```Welcome to the prerequisite searcher! 

    Please type in the number of the search would you like to execute.
    1. Course Name Search
    2. Subject Search
    3. Course Code Search
    4. Exit

```
-   The first option allows you to search the course name and it will then display the course code, course name and the prerequisites.
-   The second option allows you to search the subject for e.g if you want all CIS courses, it will display all with their course code, course name and the prerequisites.
-   The third option allows you to search for course code for e.g CIS1300 , it will display all with their course code, course name and the prerequisites.
-   The fourth option allows you to exit the search menu. 


