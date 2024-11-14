from os import path
import csv

csv_file = "parsed_courses.csv"

# Paths established to the excel file
parentpath = path.abspath(path.dirname(path.dirname(__file__)))
filepath = path.join(parentpath, "parser", csv_file)

# opening the file
def open_file(option_function, filepath, mode):
    try: 
        with open(filepath, mode=mode, newline='', encoding='utf-8') as file:
            option_function(file)
    except FileNotFoundError:
        print("The file does not exist in the specified path.")
    except PermissionError:
        print("You do not have the correct permissions for the file.")
    except FileExistsError:
        print("The file already exists.")
    except IOError:
        print("An I/O error occurred.")
    except UnicodeDecodeError:
        print("Unable to decode the file to Unicode.")



def name_search(file):
    # Input course they want to find
    course_name = input("Enter the full course name: ")

    if course_name == "":
        print("\nMatch not found.")
        return

    course_nameC = course_name.strip().casefold()

    # Read the data from the CSV file
    fieldnames = ["course code", "course name", "prerequisites"]
    reader = csv.DictReader(file, fieldnames=fieldnames)

    # list for displaying all rows
    matching_rows = []

    # Extract all words from user input
    user_words = course_nameC.split()

    # search iteration
    for row in reader:
        skip = False

        # Extract all words from course name
        course_words = row['course name'].casefold().split()

        # checks if all words typed from the user belong to the course name
        for word in user_words:
            if word not in course_words:
                skip = True
            
        if skip:
            continue
        
        # If match is found
        matching_rows.append(row)

    # match missing
    if not matching_rows:
        print("\nMatch not found.")
    else:
        for row in matching_rows:
            # table print                 
            for _ in range(70):
                print("-", end="")
            print("\nCourse Code:", row['course code'])
            print("Course Name:", row['course name'])
            print("Prerequisites:", row['prerequisites'])
            for _ in range(70):
                print("-", end="")
        

    file.close()

    print("\n")


def subject_search(file):
# Get the subject abbreviation from user
    subject_name = input("Enter the Subject Name (For example - \"CIS\"): ")
    sub_upper = subject_name.upper()

    # Read the data from the CSV file
    fieldnames = ["course code", "course name", "prerequisites"]
    reader = csv.DictReader(file, fieldnames=fieldnames)

    # Initialize a list to store matching rows
    matching_rows = []
    
    # Iterate through the rows in the CSV file
    for row in reader:
        # Ensure that 'course code' is a valid column name in your CSV file
        if 'course code' in row:
            # get letters without code
            course_code = row['course code']

            # Extracts only string of subject
            subject = ""
            for c in course_code:
                if c == "*":
                    break
                subject += c
            
            # Check if the course code starts with the given subject
            if sub_upper == subject.upper():
                matching_rows.append(row)


    if not matching_rows:
        print("\nSubject doesn't exist.")
    
    else:
        # matching_rows contains the rows that needs to be output
        print("\n{:^25}|{:^60}|{:^60}".format("Course Code", "Course Name", "Prerequisites"))
    
        for row in matching_rows:
            for _ in range(160):
                print("-", end="")

            prerequisite = row['prerequisites']
            
            #max length will be 60              
            max_prerequisite_length = 60

            # Split prerequisites into mult lines
            prereq_lines = [prerequisite[i:i+max_prerequisite_length]                 
            for i in range(0, len(prerequisite), max_prerequisite_length)]

            # Print the first line with Course Code and Course Name
            if prereq_lines:
                print("\n{:^25}|{:^60}|{:^60}".format(row['course code'], row['course name'], prereq_lines[0]))

            # Print additional lines with empty Course Code and Course Name
            for line in prereq_lines[1:]:
                print("\n{:^25}|{:^60}|{:^60}".format('', '', line))
                
    file.close()

    print("\n")


def code_search(file):
# Input text to search for (e.g., "CIS 1300" or "CIS1300" or "CIS*1300")
    search_text = input("Enter a course code to search for (For example - \"CIS*1500\"): ").replace(" ", "").replace("*", "")
    search_text_Upp = search_text.upper()

    fieldnames = ["course code", "course name", "prerequisites"]
    reader = csv.DictReader(file, fieldnames=fieldnames)
    
    # Initialize a list to store matching rows
    matching_rows = []

    # Iterate through the rows in the CSV file
    for row in reader:
        # Remove spaces and asterisks from user input and course code in excel
        course_code = row['course code'].replace(" ", "").replace("*", "")
        search_text_Upp = search_text_Upp.replace(" ", "").replace("*", "")
        
        # Check if the course code contains the search text
        if search_text_Upp == course_code.upper():
            matching_rows.append(row)

    if not matching_rows:
        print("\nPlease enter the correct formatted input per choice.")
    else:
        # Display the matching rows
        for row in matching_rows:
            
            for _ in range(70):
                print("-", end="")
            print("\nCourse Code:", row['course code'])
            print("Course Name:", row['course name'])
            print("Prerequisites:", row['prerequisites'])
            for _ in range(70):
                print("-", end="")

    file.close()
    
    print("\n")

### MENU LOOP
while True:
   
    print("\nWelcome to the Prerequisite Searcher! \n\nPlease type in the number of the search would you like to execute.\n")
    print("1. Course Name Search")
    print("2. Subject Search")
    print("3. Course Code Search")
    print("4. Exit")
    
    choice = input("\n\nEnter your choice: ")
    
    if choice == '1': open_file(name_search, filepath, "r")
    elif choice == '2': open_file(subject_search, filepath, "r")
    elif choice == '3': open_file(code_search, filepath, "r")
    elif choice == '4':
        print("\nThank you for searching.\n")
        break
    else:
        print("\nInvalid choice. Please select a valid option.\n")
