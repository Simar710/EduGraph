<?php
// Set the content type to JSON
header("Content-Type: application/json");

// Include the database connection file
require 'db_connection.php';

// Function to handle HTTP errors
function handleHttpError($code, $message) {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and parse the JSON data from the request body
    $json_data = file_get_contents('php://input');
    $course_data = json_decode($json_data, true);

    // Validate and sanitize the input data as needed

    // Ensure that all required fields are present
    if (!isset($course_data['courseCode']) || !isset($course_data['courseName'])) {
        handleHttpError(400, 'Incomplete course data in the request');
    }

    // Assign values to variables
    $courseCode = $course_data['courseCode'];
    $courseName = $course_data['courseName'];
    $prerequisites = isset($course_data['prerequisites']) ? $course_data['prerequisites'] : '()';
    $restrictions = isset($course_data['restrictions']) ? $course_data['restrictions'] : '{}';

    // Connect to the database
    $conn = open_con();

    // Check for database connection success
    if (!$conn) {
        handleHttpError(500, 'Failed to connect to the database');
    }

    // Select the appropriate database
    mysqli_select_db($conn, "cis3760");

    // Escape special characters in variables
    $courseCode = mysqli_real_escape_string($conn, $courseCode);
    $courseName = mysqli_real_escape_string($conn, $courseName);
    $prerequisites = mysqli_real_escape_string($conn, $prerequisites);
    $restrictions = mysqli_real_escape_string($conn, $restrictions);

    // Check if the courseCode already exists
    $check_query = "SELECT COUNT(*) FROM coursesDBCopy WHERE courseCode = '$courseCode'";
    $result = mysqli_query($conn, $check_query);

    // Check for database query success
    if (!$result) {
        close_con($conn);
        handleHttpError(500, 'Database query error');
    }

    // Fetch the count from the result
    $count = mysqli_fetch_array($result)[0];

    // Check if the course code already exists
    if ($count > 0) {
        close_con($conn);
        handleHttpError(400, 'Course code already exists');
    }

    // Insert the new course data into the database
    $sql = "INSERT INTO coursesDBCopy (courseCode, courseName, prerequisites, restrictions) VALUES ('$courseCode', '$courseName', '$prerequisites', '$restrictions')";

    // Check for successful database insertion
    if (mysqli_query($conn, $sql)) {
        close_con($conn);
        http_response_code(201); // 201 Created
        echo json_encode(['message' => 'Course added successfully']);
    } else {
        close_con($conn);
        handleHttpError(500, 'Failed to add course to the database');
    }
} else {
    // Incorrect request method
    handleHttpError(405, 'Incorrect request method');
}
?>

