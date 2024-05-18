<?php
header("Content-Type: application/json");
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400"); // 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require 'db_connection.php';

function handleHttpError($errorCode, $errorMessage = '') {
    http_response_code($errorCode);
    echo json_encode(array('error' => $errorMessage));
    exit;
}

$conn = open_con();

if (!$conn) {
    handleHttpError(500, 'Failed to connect to the database');
} else {
    $databaseName = 'cis3760';
    if (mysqli_select_db($conn, $databaseName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = "SELECT courseCode FROM coursesDB";

            try {
                $result = $conn->query($sql);
                if ($result) {
                    $subjects = array();

                    while ($row = $result->fetch_assoc()) {
                        $courseCode = $row['courseCode'];
                        // Extract the subject by splitting the course code
                        $subject = explode('*', $courseCode)[0];
                        // Remove double quotes
                        $subject = trim($subject, "\"");
                        $subjects[] = $subject;
                    }

                    // Remove duplicates
                    $uniqueSubjects = array_unique($subjects);

                    close_con($conn);

                    http_response_code(200);
                    echo json_encode(array_values($uniqueSubjects));
                } else {
                    handleHttpError(500, 'Failed to fetch data from the database');
                }
            } catch (Exception $e) {
                handleHttpError(500, $e->getMessage());
            }
        } else {
            handleHttpError(405, 'Incorrect request method');
        }
    } else {
        handleHttpError(500, 'Failed to select the database');
    }
}
?>
