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

function handle_error($code, $message)
{
    http_response_code($code);
    echo json_encode(array('error' => $message));
    close_con($conn);
    return;
}

$conn = open_con();

if (!$conn) {
    handle_error(500, 'Failed to connect to the database');
} else {
    $databaseName = 'cis3760';
    if (mysqli_select_db($conn, $databaseName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json_data = file_get_contents('php://input');
            $subject_data = json_decode($json_data, true);

            if (isset($subject_data['subject'])) {
                if (empty($subject_data['subject'])) {
                    handle_error(404, 'Array cannot be empty');
                }

                $subjects = $subject_data['subject'];
            } else {
                handle_error(404, 'subject property not found');
            }

            $likeConditions = array_map(function ($code) {
                return "courseCode LIKE '%" . $code . "%'";
            }, $subjects);

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
                        handle_error(404, 'No courses found for the given subject');
                    } else {
                        echo json_encode($data);
                    }
                } else {
                    handle_error(500, 'Failed to fetch data from the database');
                }
            } catch (Exception $e) {
                handle_error(500, $e->getMessage());
            }
        } else {
            handle_error(405, 'Incorrect request method');
        }
    } else {
        handle_error(500, 'Failed to select the database');
    }
}
?>
