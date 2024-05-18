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

$conn = open_con();

if (!$conn) {
    http_response_code(500);
    echo json_encode(array('error' => 'Failed to connect to the database'));
} else {
    $databaseName = 'cis3760';
    if (mysqli_select_db($conn, $databaseName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = "SELECT * FROM coursesDB";

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

                    http_response_code(200);
                    echo json_encode($data);
                } else {
                    handleError(500, 'Failed to fetch data from the database');
                }
            } catch (Exception $e) {
                handleError(500, $e->getMessage());
            }
        } else {
            handleError(405, 'Incorrect request method');
        }
    } else {
        handleError(500, 'Failed to select the database');
    }
}

function handleError($code, $message) {
    http_response_code($code);
    echo json_encode(array('error' => $message));
}
?>

