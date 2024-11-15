import re
import csv

class Course:
    def __init__(self, code, name, prerequisites, restrictions):
        self.code = code
        self.name = name
        self.prerequisites = prerequisites
        self.restrictions = restrictions

    def __str__(self):
        return f"Course Code: {self.code}\nCourse Name: {self.name}\nPrerequisites: {self.prerequisites}\nRestrictions: {self.restrictions}"

def parse_courses(input_file_path, output_csv_file):
    try:
        with open(input_file_path, "r", encoding="ISO-8859-1") as file:
            file_contents = file.read()
            file_contents = file_contents.strip()
            if not file_contents:
              print("ERROR: Empty File. Please Try Another File")
              exit()
        # This is where the first course starts
        start = file_contents.split("Accounting (ACCT)")[3].strip()

        courses = []

        # Split the text into course blobs using "Location(s):" as the delimiter since every course has a location at the end
        course_blobs = re.split(r"Location\(s\):", start)

        # Define a regular expression pattern to match course codes and course names combined and prerequisites separately
        course_pattern = r"([A-Z]{2,4}\*\d{4})\s+(.*?)\s+\[[\d.]+\]"
        prerequisite_pattern = r"Prerequisite\(s\):(.*?)(Restriction\(s\)|Location\(s\)|Co-requisite\(s\)|Equate\(s\)|Offering\(s\)|Department\(s\))"
        restriction_pattern = r"Restriction\(s\):(.*?)(Location\(s\)|Department\(s\))"
        
        # Loop through each course blob and extract the first course code
        for blob in course_blobs:
            blob = blob.strip()
            # DOTALL flag will allow us to span multiple lines
            matches = re.search(course_pattern, blob, re.DOTALL)
            
            if not matches:
                continue
            
            course_code = matches.group(1)
            course_name = matches.group(2)
            # Since some course names span two lines and contain other useless info, we split on double space so we can take the first element in that array
            course_name = course_name.split("  ")[0].strip()
            prerequisites = re.findall(prerequisite_pattern, blob, re.DOTALL)
            restrictions = re.findall(restriction_pattern, blob, re.DOTALL)
            
            prerequisites_str = ""
            restriction_data = ""
            null_prereqs = ""
            
            if prerequisites:
                prerequisites_str = prerequisites[0][0].strip()
                
                # Define regular expression patterns
                patternOne = r'Completion of (\d+\.\d+ credits) including \((.*?)\)'
                
                #for all the prereqs that are in the format of (<#> of ..)
                patternTwo = r'1 of (.+)$'
                patternThree = r'(2+) of (.+)$'
                patternFour = r'(3+) of (.+)$'
                patternFive = r'(4+) of (.+)$'
                
                #for the prereqs that have an OR but no bracket around the expression
                patternSix = r'([^()]*)\b(or)\b([^()]*)'
                
                #remove nested brackets
                patternSeven = re.compile(r'\(([^()]+)\)')
                # Use re.sub to transform the input string
                prerequisites_str = re.sub(patternOne, r'(\1), (\2)', prerequisites_str)
                prerequisites_str = re.sub(r' credits including ', ' credits, ', prerequisites_str)
                prerequisites_str = re.sub(patternSix, r'(\1\2\3)', prerequisites_str)
                prerequisites_str = re.sub(patternTwo, lambda match: f'({match.group(1).replace(", ", " or ")})', prerequisites_str)
                prerequisites_str = re.sub(patternThree, lambda match: f'{match.group(1)} of ({match.group(2).replace(", ", " or ")})', prerequisites_str)
                prerequisites_str = re.sub(patternFour, lambda match: f'{match.group(1)} of ({match.group(2).replace(", ", " or ")})', prerequisites_str)
                prerequisites_str = re.sub(patternFive, lambda match: f'{match.group(1)} of ({match.group(2).replace(", ", " or ")})', prerequisites_str)
                prerequisites_str = patternSeven.sub(lambda match: f'({match.group(1)})' if re.match(r'\d+ of .+', match.group(1)) else match.group(1), prerequisites_str)
                
                # Replace 'or' with ' OR ' and ',' with ' AND '
                prerequisites_str = prerequisites_str.replace(" or ", " OR ").replace(", ", " AND ")
                
            else:
                prerequisites_str = ()
            
            if restrictions:
                restriction_data = re.findall(r"([A-Z]{3,4}\*\d{4})+", restrictions[0][0].strip())
                restriction_data = '{' + ','.join(restriction_data) + '}'
            else:
                 restriction_data = {}
            
            
            courses.append(Course(course_code, course_name, prerequisites_str, restriction_data))

        # If we added duplicated courses, make sure to remove them before exporting to csv
        seen_codes = set()
        non_dupe_courses = []
        for course in courses:
            if course.code not in seen_codes:
                non_dupe_courses.append(course)
                seen_codes.add(course.code)

        # Create a list of dictionaries for the data
        data = [{"course code": course.code, "course name": course.name, "prerequisites": course.prerequisites, "restrictions": course.restrictions} for course in non_dupe_courses]

        # Write the data to a CSV file
        with open(output_csv_file, mode='w', newline='', encoding='utf-8') as file:
            fieldnames = ["course code", "course name", "prerequisites", "restrictions"]
            writer = csv.DictWriter(file, fieldnames=fieldnames)

            # Write the header row
            writer.writeheader()

            # Write the data rows
            writer.writerows(data)
        # error handling
        return True, "Successfully parsed and saved to CSV."
    except FileNotFoundError:
        return False, "Input file not found."
    except Exception as e:
        return False, f"An error occurred: {str(e)}"

# Hardcoded input and output file names
input_file_path = "../f23_courses1.txt"
output_csv_file = "parsed_courses.csv"


if input_file_path.endswith(".txt"):
  result, message = parse_courses(input_file_path, output_csv_file)
  print(message)
else:
    print("ERROR: Please provide .txt file format")
