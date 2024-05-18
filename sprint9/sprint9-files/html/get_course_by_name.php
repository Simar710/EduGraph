<?php

header("Content-Type: application/json");

require 'db_connection.php';

function handleHttpError($statusCode, $errorMessage) {
    http_response_code($statusCode);
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
            if (isset($course_data['courseName'])) {
                if (empty($course_data['courseName'])) {
                    handleHttpError(404, 'Array cannot be empty');
                }
                $courseNames = $course_data['courseName'];
            } else {
                handleHttpError(404, 'courseName property not found');
            }

            $likeConditions = array_map(function ($name) {
                return "courseName LIKE '%" . $name . "%'";
            }, $courseNames);
            // Construct the SQL query with multiple LIKE conditions joined by OR
            $conditions = implode(" OR ", $likeConditions);
            $sql = "SELECT * FROM coursesDB WHERE " . $conditions;

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

