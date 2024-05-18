<?php
// Set the content type to HTML
header('Content-Type: text/html; charset=UTF-8');

// Define variables for the content
$title = "F’23 CIS*3760: Group 101";
$greeting = "Greetings and welcome to our digital realm!";
$description1 = "We’re group 101! Although we’re small in size, we're mighty in effort!";
$description2 = "Prepare to embark on a journey with us as we dive into our Software Engineering project. We look forward to showcasing our collective talents and pushing the boundaries of what's achievable in the digital realm. Welcome aboard!";

$downloadFile = 'parsed_courses.xlsm';

$title2 = "Meet the Team";

// Team images
$teamMembers = array(
    array('name' => 'Sara', 'imagePath' => 'sara.jpg'), // Replace with actual paths and names
    array('name' => 'Simardeep', 'imagePath' => 'simardeep.png'),
    array('name' => 'Emily', 'imagePath' => 'emily.png'),
    array('name' => 'Maneesh', 'imagePath' => 'maneesh.png'),
    array('name' => 'FeeKim', 'imagePath' => 'feeKim.png')
);

// Generate the entire HTML page using PHP
$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
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

    <script>
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

    <title>Hero Page</title>
    
</head>
<body>

    <!-- hero page -->
    <section id = "hero-main" >
    <label class="switch">
      <input type="checkbox" class="toggle-dark-mode">
      <span class="slider">
        <span class="toggle-icons">
          <i class="fa fa-moon"></i> <!-- Moon icon -->
          <i class="fa fa-sun"></i> <!-- Sun icon -->
        </span>
      </span>
    </label>
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <div class="lc-block d-grid gap-2 d-md-flex flex-md-column justify-content-md-start">
                         <a class="btn btn-dark px-4 me-md-2" aria-label="Download File" href="parsed_courses.xlsm"  download class="download-button" role="button">Download .xlsm Course File</a>
                        <a class="btn btn-outline-secondary px-4 search-info-btn" aria-label="API Documentation" href="apidocs" role="button">API Documentation</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="lc-block mb-3">
                        <div editable="rich">
                            <h2 class = "display-5">$title</h2>
                            <p>$greeting</p>
                            <p>$description1</p>
                            <p>$description2</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- course generator -->
    <section id = "generator">
        <div class="container col-xxl-8 px-4 py-5 course-generator">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="laptop-homepage.png" class="d-block mx-lg-auto img-fluid" alt="hero image" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <div class="lc-block mb-3">
                        <div editable="rich">
                            <h2 class="fw-bold display-5">UoG Student Course Generator</h2>
                        </div>
                    </div>

                    <div class="lc-block mb-3">
                        <div editable="rich">
                            <p class="lead">Click on the button below to start planning your academic future!
                            </p>
                        </div>
                    </div>

                    <div class="lc-block d-grid gap-2 d-md-flex justify-content-md-start"><a class="btn btn-dark px-4 me-md-2" aria-label = "Start Now!" href="course_generator" role="button">Start Now!</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <hr>

    <div class="team-text">
        <h2 class = "title-team">$title2</h2>
    </div>
    <div class="row justify-content-center mx-auto">
        
HTML;

// Loop through team members and create the HTML for each
foreach ($teamMembers as $index => $member) {
    $name = $member['name'];
    $imagePath = $member['imagePath'];
    $href = strtolower($name);
    $marginLeftClass = $index === 0 ? 'ml-2' : ''; // Add margin-left to the first team member
    $html .= <<<HTML
            <div class="col-md-2 team-member $marginLeftClass">
                <a href="$href"><img src="$imagePath" alt="$name's Headshot" class="rounded-circle img-fluid" style="width: 150px; height: 150px;"></a>
                <p>$name</p>
            </div>
HTML;
}

$html .= <<<HTML
    </div>
</body>
</html>
HTML;

// Output the generated HTML
echo $html;
?>

