<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $requestData = json_decode(file_get_contents('php://input'), true);
    $courseCode = isset($requestData['courseCode']) ? $requestData['courseCode'] : null;

    if ($courseCode === null) {
        // Handle the case where the courseCode is missing
        http_response_code(400);
        echo json_encode(["error" => "Missing courseCode parameter"]);
        exit;
    }

    $apiUrl = "http://34.201.123.35/courses/getCourseByCode/";
    $postData = json_encode(["courseCode" => $courseCode]);

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => $postData
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response !== false) {
        // Return the course data as a JSON response
        echo $response;
    } else {
        // Handle the case where the API request fails
        http_response_code(500); // Internal Server Error
        echo "Failed to fetch course data";
    }

} else {
    // Handle the case where the request method is not GET
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed";
    exit;
}
?>

