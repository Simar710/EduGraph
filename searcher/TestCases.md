The file contains different test cases which test various scenarios and functionalities that the code should handle correctly:

# Test Cases:

**Test Case 1: A user inputs nothing for the search critera**

- Description: A user clicks "enter" or "return" without inputting anything as the search critera
- Input: Empty
- Expected Result: Prompt message to tell the user that their input is invalid and to try again.

**Test Case 2: Course code specifed by user does not yeild any results**

- Description: A user enters a course (i.e., "CI*199"), and no results are found in the csv
- Input: A course code that does not exist
- Expected Result: Output message to user that states that no results were found with that course code.

**Test Case 3: Course name specifed by user does not yeild any results**

- Description: A user enters a course name (i.e., "Introduction to Water Bottles"), and no results are found in the csv
- Input: A course name that does not exist
- Expected Result: Output message to user that states that no results were found with that course name.

**Test Case 4: A user enters a search for a course without proper captializaiton**

- Description: A user inputs a course name or code without proper captialization
- Input: Instead of "CIS" the user inputs "cis" or "Cis"
- Expected Result: The search functionality should not have any captializaiton limits, and all of these should be treated the same.

**Test Case 5: Empty reference file**

- Description: Test the code with an empty input file.
- Input: An empty input file.
- Expected Result: The code must handle empty files and output a notice stating that there are no courses to search for.

**Test Case 6: Invalid Input File Format**

- Description: Test the code with an unsupported input file format. 
- Input: An unsupported input file format. For example: Non-text file.
- Expected Result: If the file format is not supported, the function should handle the problem and provide an appropriate error message.

**Test Case 7: Valid Input File**

- Description: Test using a valid input file, which contains course information.
- Input: A valid input file with course information.
- Expected Result: The program should accurately read the input file and produce a CSV file with the data.

**Test Case 8: Missing Input File**

- Description: Test the code without input file.
- Input: A path to an invalid or missing input file.
- Expected Result: The code must gracefully handle the issue and display the proper error message.

**Test Case 9: Course code input accpets different variations for course code**

- Description: Test the code with different input for Course Code, e.g CIS1300, Cis1300, CIS 1300, Cis 1300, Cis*1300.
- Input: A course code with different variation from the csv file
- Expected result: The code should output the course description even when Cis 1300 is input


