<?php

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');

require 'db_connection.php';

function handleHttpError($errorCode, $errorMessage) {
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
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $input_data = json_decode(file_get_contents('php://input'), true);
            if (!isset($input_data['courseCode'])) {
                handleHttpError(400, 'Malformed courseCode parameter');
            }

            $courseCode = mysqli_real_escape_string($conn, $input_data['courseCode']);

            $sql = "DELETE FROM coursesDBCopy WHERE courseCode = '\"$courseCode\"'";

            try {
                $result = $conn->query($sql);
                if ($result) {
                    $affectedRows = mysqli_affected_rows($conn);
                    close_con($conn);
                    if ($affectedRows > 0) {
                        echo json_encode(array('message' => 'Course deleted successfully'));
                    } else {
                        handleHttpError(404, 'Course not found');
                    }
                } else {
                    handleHttpError(500, 'Failed to delete data from the database');
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

