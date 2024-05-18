<?php
header("Content-Type: application/json");

require 'db_connection.php';
$conn = open_con();

function handleHttpError($code, $message) {
    http_response_code($code);
    echo json_encode(array('error' => $message));
    exit();
}

if (!$conn) {
    handleHttpError(500, 'Failed to connect to the database');
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $json = file_get_contents('php://input');
        $putData = json_decode($json, true);

        if ($putData === null) {
            handleHttpError(400, 'Invalid JSON data in the request body');
        }

        $courseCode = isset($putData['courseCode']) ? $putData['courseCode'] : null;
        $courseName = isset($putData['courseName']) ? $putData['courseName'] : null;
        $prerequisites = isset($putData['prerequisites']) ? $putData['prerequisites'] : null;
        $restrictions = isset($putData['restrictions']) ? $putData['restrictions'] : null;

        $databaseName = "cis3760";

        if (mysqli_select_db($conn, $databaseName)) {
            if (!is_null($courseCode)) {
                $courseCode = '"' . addslashes($courseCode) . '"';
                $selectOriginalRowSql = "SELECT * FROM coursesDBCopy WHERE courseCode = '$courseCode'";
                $originalResult = $conn->query($selectOriginalRowSql);
                $originalRow = $originalResult->fetch_assoc();

                if ($originalRow) {
                    $updateStatements = array();

                    if (!is_null($courseName)) {
                        $updateStatements[] = "courseName = '$courseName'";
                    }

                    if (!is_null($prerequisites)) {
                        $updateStatements[] = "prerequisites = '$prerequisites'";
                    }

                    if (!is_null($restrictions)) {
                        $updateStatements[] = "restrictions = '$restrictions'";
                    }

                    if (!empty($updateStatements)) {
                        $updateSql = implode(', ', $updateStatements);
                        $sql = "UPDATE coursesDBCopy SET $updateSql WHERE courseCode ='$courseCode'";

                        try {
                            if ($conn->query($sql)) {
                                http_response_code(200);
                                $selectUpdatedRowSql = "SELECT * FROM coursesDBCopy WHERE courseCode = '$courseCode'";
                                $result = $conn->query($selectUpdatedRowSql);

                                if ($result) {
                                    $updatedRow = $result->fetch_assoc();
                                    $outputJSON = array(
                                        'message' => 'Current Info',
                                        'originalRow' => $originalRow,
                                        'updatedRow' => $updatedRow
                                    );
                                    echo json_encode($outputJSON);
                                } else {
                                    handleHttpError(500, 'Failed to retrieve the updated row from the database');
                                }
                            } else {
                                handleHttpError(500, 'Failed to update data in the database');
                            }
                        } catch (Exception $e) {
                            handleHttpError(500, $e->getMessage());
                        }
                    } else {
                        handleHttpError(400, 'No valid update data provided');
                    }
                } else {
                    handleHttpError(400, 'Course Code not found!');
                }
            } else {
                handleHttpError(400, 'Missing courseCode in the request, required');
            }
        } else {
            handleHttpError(500, 'Failed to select the database');
        }
    } else {
        handleHttpError(405, 'Invalid request method');
    }

    close_con($conn);
}
?>

