<?php

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');

require 'db_connection.php';

function handleHttpError($errorCode, $errorMessage)
{
    http_response_code($errorCode);
    echo json_encode(array('error' => $errorMessage));
}


$conn = open_con();

if (!$conn) {
    handleHttpError(500, 'Failed to connect to the database');
} else {
    $databaseName = 'cis3760';
    if (mysqli_select_db($conn, $databaseName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $json_data = file_get_contents('php://input');
            $course_data = json_decode($json_data, true);
            if (isset($course_data['courseCode'])) {
                if (empty($course_data['courseCode'])) {
                    handleHttpError(404, 'Array cannot be empty');
                }
                $courseCodes = $course_data['courseCode'];
            } else {
                handleHttpError(404, 'courseCode property not found');
            }

            $quotedCourseCodes = array_map(function ($code) {
                return "'\"" . $code . "\"'";
            }, $courseCodes);

            // Construct the SQL query with multiple course codes using IN clause
            $placeholders = implode(",", $quotedCourseCodes);
            $sql = "SELECT * FROM coursesDB WHERE courseCode IN ($placeholders)";

            try {
                $result = $conn->query($sql);
                if ($result) {
                    $data = array();

                    while ($row = $result->fetch_assoc()) {
                        // Remove quotation marks from the values
                        foreach ($row as $key => $value) {
                            $row[$key] = str_replace('"', '', $value);
                        }
                        $data[] = $row;
                    }

                    close_con($conn);

                    if (empty($data)) {
                        handleHttpError(404, 'Course not found');
                    } else {
                        echo json_encode($data);
                    }
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
