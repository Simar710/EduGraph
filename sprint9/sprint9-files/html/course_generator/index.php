<?php $pageTitle = "Course Generator Page"?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Merriweather:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- link bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
      <?php include "index.css" ?>
    </style>
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <div class="home">
      <a href="/" aria-label="Home"><button class="btn-home" aria-label="home button" tabindex="-1"><i class="fa fa-home"></i></button></a>
  </div>
  <label class="switch">
      <input type="checkbox" class="toggle-dark-mode">
      <span class="slider">
        <span class="toggle-icons">
          <i class="fa fa-moon"></i> <!-- Moon icon -->
          <i class="fa fa-sun"></i> <!-- Sun icon -->
        </span>
      </span>
    </label>
    <!-- hero page -->
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="images/hero.jpeg" class="d-block mx-lg-auto img-fluid" alt="hero image" loading="lazy">
            </div>
            <div class="col-lg-6">
                <div class="lc-block mb-3">
                    <div editable="rich">
                        <h2 class="fw-bold display-5">UoG Student Course Generator</h2>
                    </div>
                </div>

                <div class="lc-block mb-3">
                    <div editable="rich">
                        <p class="lead">Introducing our Student Course Generator – your ultimate tool for academic success! Seamlessly designed for students, this generator empowers you to effortlessly input your current courses, instantly generating a personalized list of recommended next steps based on your completed subjects.
                        </p>
                    </div>
                </div>

                <div class="lc-block d-grid gap-2 d-md-flex justify-content-md-start"><a class="btn btn-dark px-4 me-md-2" aria-label = "Generate Courses" href="#addCourse" role="button">Generate Courses</a>
                    <a class="btn btn-outline-secondary px-4 search-info-btn" aria-label = "Search Course Info." href="#searchCourse" role="button">Search Course Info.</a>
                </div>
              <!-- DONT FORGET TO CHANGE THE LOCALHOST BACK -->
              <div id="genTreeBtn" class="lc-block d-grid gap-2 d-md-flex justify-content-md-start"><a class="btn btn-dark px-4 me-md-2" aria-label = "Generate Course Tree" href="/course_generator/genTree" role="button">Generate Course Tree</a>
              </div>

            </div>
        </div>
    </div>

    <!-- Add Course -->
    <section id = "addCourse">
      <div class="jumbotron text-center input-course-container">
          <h1>Input Courses</h1>
          <p>Input the courses that you have taken below one at a time, clicking the “Add Course” button after each input.<br>Note: The input should be in the format of SUBJECT*COURSE NUM, for example; CIS*2500</p>
          <div class="input-group input-group-btn submit-course">
            <input type="text" class="form-control" size="50" id="course" name="course" placeholder="CIS*1500...">
          </div>
          <div class="lc-block text-center">
            <button class="btn1 btn btn-dark mx-2 add-course-btn" aria-label= "Add Course to List">Add Course to List</button>
            <button class="clear-btn btn btn-light mx-2 clear-course-btn" aria-label = "Clear Courses from List">Clear Courses from List</button>
          </div>
          <h2>Courses Inputted So Far:</h2>
          <div class="enteredCoursesList">
            <ul id="enteredCourses"></ul>
          </div>
      </div>
    </section>

    <!-- Generate Course Recommendations -->
    <section id = "courseGenerator">
      <div class="jumbotron text-center generate-course-container">
          <h1>Course Recommendations</h1>
          <p>Please confirm that all the courses you have taken are listed above. When ready, please click the button below to generate recomended courses.</p>
          <div class="generate-course recommended-heading lc-block text-center">
            <button class="btn2 btn btn-dark mx-2 generate-course-btn" aria-label= "Generate Courses">Generate Courses</button>
            <button class="gen-course-empty-btn2 btn btn-dark mx-2 generate-course-no-pre-btn" aria-label= "Generate Courses With No Prerequisites">Generate Courses With No Prerequisites</button>
            <button class="clear-btn-rec btn btn-light mx-2" aria-label= "Clear Results">Clear Results</button>
          </div>
          <div class="recommended-courses">
            <ul id="recommended-courses-list">
              <!-- Recommended courses will be displayed here -->
            </ul>
          </div>
      </div>
    </section>

    <!-- Search Course -->
    <section id = "searchCourse">
      <div class="jumbotron text-center course-data-container">
          <h1>Search Course Details</h1>
          <p>Enter a course code in the format of CIS*1500 to view its details.</p>
              <div class="input-group input-group-btn submit-course-detail">
                  <input type="text" class="form-control custom-outline" size="50" id="course-detail" name="course-detail" placeholder="CIS*1500..."><br>
                  <button type="button" class="btn3 btn btn-success search-btn" aria-label="Search">Search</button>
              </div>
          <div class="detail-heading lc-block d-grid gap-2 d-md-flex justify-content-md-start">
            <a class="btn btn-dark px-4 me-md-2 clear-btn-detail" aria-label= "Clear Results" role="button" tabindex="0">Clear Results</a>
          </div>
          <!-- display course search results -->
          <div class="container courseDetails">
              <div class="row">
                  <div class="col-md-12">
                      <div class="course-detail">
                          <p id=code-detail></p>                          
                          <p id=name-detail></p>
                          <p id=prereq-detail></p>
                          <p id=restr-detail></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>

    <script type="text/javascript">

    document.addEventListener("DOMContentLoaded", async function() {

      // all functionality buttons
      let add_course_btn = document.querySelector(".btn1");
      let display_course_btn = document.querySelector(".btn3");
      let recommendedCoursesContainer = document.querySelector('.recommended-courses');
      let courseDetailsContainer = document.querySelector('.courseDetails');

      // clear buttons
      let clear_button = document.querySelector(".clear-btn");
      let clear_button_rec = document.querySelector(".clear-btn-rec");
      let clear_btn_detail = document.querySelector(".clear-btn-detail");

      //Function 1 - course list compilation
      let courseInput = document.getElementById("course");
      let enteredCoursesList = document.getElementById("enteredCourses");
      let recommendedCoursesList = document.getElementById("recommended-courses-list");

      //Function 3 - input course detail
      let courseDetail = document.getElementById("course-detail");
      // Output
      let codeDetail = document.getElementById("code-detail");
      let nameDetail = document.getElementById("name-detail");
      let prereqDetail = document.getElementById("prereq-detail");
      let restrDetail = document.getElementById("restr-detail");

      // Collect entered courses
      let enteredCourses = [];

      // Binds input field event listener to btn click
      courseInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          // Trigger the click event on the add_course_btn button
          add_course_btn.click();
        }
      });

      // Binds input field event listener to btn click
      courseDetail.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          // Trigger the click event on the add_course_btn button
          display_course_btn.click();
        }
      });

  // Event listener for adding a course to the list
      add_course_btn.addEventListener("click", function() {
        let courseValue = courseInput.value;

        let splitCourse = courseValue.split('*');

        if (splitCourse.length === 2 && splitCourse[0] !== '' && splitCourse[1] !== '' && splitCourse[1].trim() !== '' && !isNaN(splitCourse[1])) {

        let course = splitCourse[0] + "*" + splitCourse[1];
        enteredCourses.push(course); 

        let listItem = document.createElement("li");
        listItem.textContent = course;

        // Create a delete button
        let deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.className = "btn btn-danger mx-2 delete-course-btn";
        deleteButton.style.marginTop = "0px";

        deleteButton.addEventListener("click", function () {
        enteredCourses = enteredCourses.filter(c => c !== course);
        // Remove the corresponding list item when the delete button is clicked
        enteredCoursesList.removeChild(listItem);
       });

      // Append the delete button to the list item
        listItem.appendChild(deleteButton);

        enteredCoursesList.appendChild(listItem);

        courseInput.value = "";
      } else {
      
      alert("Please enter the course in the format of SUBJECT*COURSE NUM, for example; CIS*2500");
    }
  });

      /*** FUNCTION 3: Event listener for the display of courses at the bottom.***/
      display_course_btn.addEventListener("click", function() {
        let courseValue = courseDetail.value;
        // courseDetailsContainer.style.backgroundColor = "#D9D9D9";

        let splitCourse = courseValue.split('*');

        if (splitCourse.length === 2 && splitCourse[0] !== '' && splitCourse[1] !== '' && splitCourse[1].trim() !== '' && !isNaN(splitCourse[1])) {

        let apiUrl = 'get_course_details.php';
        let requestData = {
          courseCode: [courseValue],
        };

          // call get by course ID endpoint
          fetch(apiUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData)
          })
            .then(response => {              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              // if the array is empty
              if (data.length == 0){
                alert("Error: Inputted course does not exist. Please try again")
                codeDetail.textContent = "";
                nameDetail.textContent = "";
                prereqDetail.textContent = "";
                restrDetail.textContent = "";
              }
              else{
                codeDetail.textContent = "Course Code: " + data[0].courseCode;
                nameDetail.textContent = "Course Name: " + data[0].courseName;
                prereqDetail.textContent = "Prerequisites: " + data[0].prerequisites;
                restrDetail.textContent = "Restrictions: " + data[0].restrictions;
              }
            })
            .catch(error => {
              console.error('There was a problem with the fetch operation:', error);
            });
        } else {
          alert("Please enter the course in the format of SUBJECT*COURSE NUM, for example; CIS*2500");
        }
      });

      // Event listeners for clearing list and recs
      clear_button.addEventListener("click", function() {
        enteredCourses = [];
        enteredCoursesList.innerHTML = "";
      })

      clear_button_rec.addEventListener("click", function() {
        recommendedCoursesList.innerHTML = "";
        // recommendedCoursesContainer.style.backgroundColor = null;
      })

      clear_btn_detail.addEventListener("click", function() {
        // courseDetailsContainer.style.backgroundColor = null;
        courseDetail.value = "";
        codeDetail.textContent= "";
        nameDetail.textContent = "";
        prereqDetail.textContent = "";
        restrDetail.textContent = "";
      })

      // Generate Courses button click event
      function generateAndDisplayRecommendedCourses() {
        let enteredCoursesInput = document.getElementById("enteredCourses");
        enteredCoursesInput.value = JSON.stringify(enteredCourses);

        let recommendedCoursesContainer = document.querySelector('.recommended-courses');

        // Make an AJAX request to generate_recommendations.php
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "generate_recommendations.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);

            // Check if the response contains recommended courses
            if (response.recommendedCourses) {
              response.recommendedCourses.sort((a, b) => {
                return a.courseCode.localeCompare(b.courseCode, undefined, { sensitivity: 'base' });
              });
              let recommendedCoursesList = document.getElementById("recommended-courses-list");
              recommendedCoursesList.innerHTML = ""; // Clear the list

              // Display only the course codes in the list
              response.recommendedCourses.forEach(function(course) {
                  let courseCode = course.courseCode;
                  let courseName = course.courseName;
                  let listItem = document.createElement("li");
                  listItem.textContent = courseCode + " - " + courseName;
                  recommendedCoursesList.appendChild(listItem);
              });
            }
          }
        };
        if (enteredCourses.length === 0) {
          alert("You have not inputted any courses yet, did you mean to click Generate Courses With No Prerequisites?");
          return;
        }

        xhr.send("enteredCourses=" + JSON.stringify(enteredCourses));
      }

      // Generate Courses with no prerequisites button click event
      function displayCoursesWithNoPrereq() {
        var apiUrl = "get_courses_with_no.php";
        var postData = {
            prerequisites: [],
            type: 'AND'
        };

        fetch(apiUrl, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(postData),
        })
        .then(response => response.json())
        .then(data => {

          data.sort((a, b) => {
            return a.courseCode.localeCompare(b.courseCode, undefined, { sensitivity: 'base' });
          });

          // Assuming the data is an array of course objects
          var resultElement = document.getElementById("recommended-courses-list");

          // Clear previous content
          resultElement.innerHTML = "";

          // Display each course in a new paragraph
          data.forEach(course => {
            let courseCode = course.courseCode;
            let courseName = course.courseName;
            let listItem = document.createElement("li");
            listItem.textContent = courseCode + " - " + courseName;
            resultElement.appendChild(listItem);

          });
        })
        .catch(error => {
          console.error('Error:', error);
          var resultElement = document.getElementById("recommended-courses-list");
          resultElement.innerHTML = 'Error occurred while fetching data.';
        });
      }

      let generateCourseBtn = document.querySelector(".btn2");
      let generateCourseBtnEmpty = document.querySelector(".gen-course-empty-btn2");

      generateCourseBtn.addEventListener("click", generateAndDisplayRecommendedCourses);
      generateCourseBtnEmpty.addEventListener("click", displayCoursesWithNoPrereq);
    });
    // JavaScript for toggling dark mode
    document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.querySelector('.toggle-dark-mode');
            const body = document.body;

            // Check for dark mode preference in local storage
            const darkMode = localStorage.getItem('darkMode');
            
            // If dark mode is stored in local storage, apply it
            if (darkMode === 'enabled') {
                body.classList.add('dark-mode');
                toggleSwitch.checked = true;
            }

            toggleSwitch.addEventListener('change', function() {
                if (this.checked) {
                    body.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', null);
                }
            });
        });


  </script>
</body>
</html>

