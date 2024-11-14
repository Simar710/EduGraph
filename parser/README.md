# Course Parser

### Compiling and Running

-   Ensure you have python3 installed on your machine
-   Navigate to the parser directory and run the script by typing `python3 main.py` in your terminal
-   A new file will be generated called `parsed_courses.csv` which you can open in any preferred spreadsheet editor

### Initial Approach

Our initial approach for this sprint was to use the parser created from sprint 1 using the following logic:

The steps were as follows:

1. Start reading from the first course character by character
2. Separate out "course blobs" which were done by splitting on the word "Location(s):"
3. Define a regular expression that captures the course code and everything after until square brackets which denotes the end of course name
    - `r"([A-Z]{3,4}\*\d{4})\s+(.*?)\s+\[[\d.]+\]"`
4. Define a regular expression that captures the prerequisite and ensures to stop capturing once hitting a new colon separated word
    - `r"Prerequisite\(s\):(.*?)(Restriction\(s\)|Location\(s\)|Co-requisite\(s\)|Equate\(s\)|Offering\(s\)|Department\(s\))"`
5. Loop through the course blobs and apply the course details regex and prerequisite regex making sure to use the DOTALL flag which ensures multiline capturing as certain prerequisites and course names spanned two lines
6. Parse out only the course title by splitting the course name by double space as the delimiter and taking the first element in the array
7. Since some courses do not have prerequisites, handle that case separately by assigning prerequisite and empty array
8. In case the file has duplicated courses, filter those courses out
9. Create respective column names, write our data into rows, and export the entirety as a csv

However, we quickly realized that since we parsed the prerequisites as one string, we needed to break it down in order to successfully complete the functionality of this sprint.

We needed to think of a new approach.

### New Approach

We decided to break down the prerequisite portion of the parser even further:

If prerequisites exist for the course:
* Process the prerequisites_str:
* Replace 'or' with '|' and 'and' with ',' to modify the logical operators.
* Transform X.Y credits including "course" to "X.Y credits, "course"
* Transform Completion of X.Y credits, 1 of ..." to "X.Y credits, 1 of ..."

