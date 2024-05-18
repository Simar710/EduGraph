<?php

header('Content-Type: application/json');

$apiUrl = "https://cis3760f23-01.socs.uoguelph.ca/courses/getCoursesByPrereq/";
$postData = json_encode(["prerequisites" => [], "type" => 'AND']);

$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/json',
        'content' => $postData,
    ],
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

?>
