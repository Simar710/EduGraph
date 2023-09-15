# F23_CIS3760_101
# Team

- Team Lead: 
    - Sara Adi
- Team Members:
    - Emily Kozatchiner
    - Evan Ferguson
    - Fee Kim Ah-Poa
    - Maneesh K. Wijewardhana
    - Simardeep Singh

## Suggestions for a good README
Every project is different, so consider which of these sections apply to yours. The sections used in the template are suggestions for most open source projects. Also keep in mind that while a README can be too long and detailed, too long is better than too short. If you think your README is too long, consider utilizing another form of documentation rather than cutting out information.

## Name
Sprint 1: 

## Description
F23 CIS*3760 Sprint 1:
There are two steps (with a bonus step invovled) regarding the purpose behind this sprint 1 repo:

Step 1:
- Parse the course information using Python 3 and save it to an Excel spreadsheet.

Step 2:
- Create a Python 3 command-line program, compatible with Linux, OSX, and Windows, that loads the course data from the file generated in Step 1, stores it in memory, and allows users to perform searches on it without modifying the course data. The end goal is to provide a search CLI that enables users to search the file multiple times before exiting. 

Furthermore, this repo also contains research regarding VBA and any other documentation needed to successfully complete this sprint; including a burndown chart.

## Visuals

The following is the script ran to search through the CSV files through a course code:

![run1](Photos/courseCodeSearch.png)


The following is the script ran to search through the CSV files through a course name:

![run2](Photos/courseNameSearch.png)
## Team Approach
This project involves two distinct parts: parsing course data from a text file and implementing a search functionality for the parsed data. The development process was handled by two separate teams, each focusing on their respective tasks.

Parser Functionality (Developed by Team A)

Team A was responsible for extracting course information from a text file and converting it into a CSV format. Here's an overview of the steps they followed in their script:

- Read Data from Text File: The script starts by reading data from the provided text file.
- Splitting Course Blobs: To isolate individual courses, the script splits the text on the keyword "Location(s):", creating separate course blobs.
- Regular Expressions for Course Details: Team A defined regular expressions to capture course code, name, and prerequisites. These regular expressions ensure accurate extraction of the required information.
- Loop Through Course Blobs: The script iterates through the course blobs and applies the defined regular expressions for course details and prerequisites. The DOTALL flag is used to ensure multiline capturing where needed.
- Course Title Extraction: To obtain only the course title, the script splits the course name by double space as the delimiter and takes the first element in the resulting array.
- Handling Courses without Prerequisites: For courses without prerequisites, the script assigns an empty array to the prerequisite field.
- CSV Export: Finally, the script creates column names, writes the data into rows, and exports the entire dataset as a CSV file.



Search Functionality (Developed by Team B)

Team B focused on creating a search functionality that allows users (students) to query the CSV file generated by Team A. Here's how their script works:

- User Input: The search script prompts the user to enter the course code(s) they are interested in. The user can enter a single course code (e.g., "CIS 2500") or multiple course codes (e.g., "CIS HROB").
- CSV Data Load: The script loads the course data from the previously generated CSV file.
- Search Algorithm: Team B has implemented a search algorithm that matches the user's input with course names and prerequisites in the CSV file.
- Output: The script outputs the courses that match the user's query in terms of course name or prerequisites.
## Authors and acknowledgment
    - Sara Adi
    - Emily Kozatchiner
    - Evan Ferguson
    - Fee Kim Ah-Poa
    - Maneesh K. Wijewardhana
    - Simardeep Singh


## Project status
Completed!
