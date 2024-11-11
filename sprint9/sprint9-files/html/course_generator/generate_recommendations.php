<?php
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered courses from the POST request and decode it
    $enteredCoursesJSON = isset($_POST['enteredCourses']) ? $_POST['enteredCourses'] : '[]';
    $enteredCourses = json_decode($enteredCoursesJSON, true);
 
    if ($enteredCourses === null) {
        // Handle the case where enteredCourses is not valid JSON
        http_response_code(400); // Bad Request
        echo "Invalid enteredCourses data";
        exit;
    }
 
    // Function to generate recommendations based on entered courses
    function generateRecommendations($enteredCourses) {


        if (empty($enteredCourses)) {
            // Send a POST request to the API endpoint to get available courses with no prerequisites
            $apiUrl = "http://localhost:8082/courses/getCoursesByPrereq/";

            $postData = json_encode(["prerequisites" => $enteredCourses,"type" => 'AND']);
 
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $postData
            ]
        ];
            
        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);
        } 

        else {
        // Send a POST request to the API endpoint to get available courses 
      
        $apiUrl = "http://localhost:8082/courses/getCoursesByPrereq/";
  
        $postData = json_encode(["prerequisites" => $enteredCourses,"type" => 'OR']);
 
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $postData
            ]
        ];
 
        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);
    }
    
 
        if ($response === false) {
            throw new Exception("Failed to fetch recommended courses.");
        }
 
        $recommendations = json_decode($response, true);
 
        if ($recommendations === null) {
            throw new Exception("Error decoding recommended courses data.");
        }
 
        return $recommendations;
    }
 
    // Generate recommendations based on enteredCourses
    $recommendations = generateRecommendations($enteredCourses);
 
    // Create a response object
    $response = [
        "enteredCourses" => $enteredCourses,
        "recommendedCourses" => $recommendations,
    ];
 
    // Send the response as JSON
    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed";
    exit;
}
?>