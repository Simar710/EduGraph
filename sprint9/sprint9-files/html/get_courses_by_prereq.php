<?php

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require 'db_connection.php';

function handleHttpError($errorCode, $errorMessage) {
    http_response_code($errorCode);
    echo json_encode(array('error' => $errorMessage));
    close_con($GLOBALS['conn']);
}

function check_valid($course_code, $course_num) {
    if (isset($course_num) && (strlen($course_num) == 3 || strlen($course_num) == 4 || ($course_num == "" && $course_code == ""))) {
        return true;
    } else {
        handleHttpError(404, 'Malformed prerequisite array');
        return false;
    }
}

$conn = open_con();

if (!$conn) {
    handleHttpError(500, 'Failed to connect to the database');
} else {
    $databaseName = 'cis3760';

    if (mysqli_select_db($conn, $databaseName)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json_data = file_get_contents('php://input');
            $prerequisite_data = json_decode($json_data, true);
            $data = array();

            if (!isset($prerequisite_data['type'])) {
                handleHttpError(404, 'Missing type property');
                return;
            }
            if (!isset($prerequisite_data['prerequisites'])) {
                handleHttpError(404, 'Missing prerequisites property');
                return;
            }

            $type = $prerequisite_data['type'];
            $prerequisitesArr = $prerequisite_data['prerequisites'];

            // if empty array, return courses with no prereqs
            if (empty($prerequisitesArr)) {
                $sql = "SELECT * FROM coursesDB WHERE prerequisites = '\"()\"' ";
                $result = $conn->query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        // Remove quotation marks from the values
                        foreach ($row as $key => $value) {
                            $row[$key] = str_replace('"', '', $value);
                        }
                        $data[] = $row;
                    }
                }
                http_response_code(200);
                echo json_encode($data);
                return;
            }

            if (strtoupper($type) == 'OR') {
                $data = array();

                foreach ($prerequisitesArr as $prerequisite) {
                    // Check if the prerequisite has 3 or 4 numbers after the letters

                    $parts = explode('*', $prerequisite);
                    $courseCode = $parts[0];
                    $courseNumber = $parts[1];

                    if (!check_valid($courseCode, $courseNumber)) {
                        handleHttpError(404, 'Prerequisites are malformed');
                    }
                    $escapedPrerequisite = mysqli_real_escape_string($conn, trim($prerequisite));
                    $sql = "SELECT * FROM coursesDB WHERE prerequisites LIKE '%$escapedPrerequisite%'";                    $result = $conn->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            // Remove quotation marks from the values
                            foreach ($row as $key => $value) {
                                $row[$key] = str_replace('"', '', $value);
                            }
                            $data[] = $row;
                        }
                    }
                    if (empty($data)) {
                        // handleHttpError(200, 'No matching prerequisites found');
                        http_response_code(200);
                    } else {
                        http_response_code(200);
                    }
                }
                $data = removeDuplicates($data, "courseCode");

                // create an array to store the valid course
                $matchingCourses = array();
                foreach ($data as $course) {
                    $prerequisites = $course['prerequisites'];
                    $isPrerequisiteMet = evaluatePrerequisites($prerequisites, $prerequisitesArr);

                    if ($isPrerequisiteMet) {
                        $matchingCourses[] = $course;
                    }
                }
                echo json_encode($matchingCourses);
                http_response_code(200);

            } elseif (strtoupper($type) == 'AND') {

                $condition = array();
                $combined  = "";

                foreach ($prerequisitesArr as $prerequisite) {
                    // Check if the prerequisite has 3 or 4 numbers after the letters
                    $parts = explode('*', $prerequisite);
                    $courseCode = $parts[0];
                    $courseNumber = $parts[1];

                    if (check_valid($courseCode, $courseNumber)) {
                        $escapedPrerequisite = mysqli_real_escape_string($conn, trim($prerequisite));
                        // Build each AND case
                        $condition[] = "prerequisites LIKE '%$escapedPrerequisite%'";
                    } else {
                        return;
                    }

                    // Combine all conditions with AND
                    $combined = implode(' AND ', $condition);
                }

                $sql = "SELECT * FROM coursesDB WHERE $combined";

                $result = $conn->query($sql);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        // Remove quotation marks from the values
                        foreach ($row as $key => $value) {
                            $row[$key] = str_replace('"', '', $value);
                        }
                        $data[] = $row;
                    }
                }

                if (empty($data)) {
                    // handleHttpError(404, 'No matching prerequisites found');
                    http_response_code(200);
                    echo json_encode($data);
                } else {
                    http_response_code(200);
                    echo json_encode($data);
                }
            } else {
                handleHttpError(404, 'Invalid option for type, must be AND or OR');
            }
        } else {
            handleHttpError(405, 'Incorrect request method');
        }
    } else {
        handleHttpError(500, 'Failed to select the database');
    }
    close_con($conn);
}

// Helper function to remove duplicates based on a specific key
function removeDuplicates($array, $key) {
    $tempArray = array();
    $uniqueArray = array();
    foreach ($array as $val) {
        if (!in_array($val[$key], $tempArray)) {
            $tempArray[] = $val[$key];
            $uniqueArray[] = $val;
        }
    }
    return $uniqueArray;
}

// recursive function to evaluate prerequisites logic
function evaluatePrerequisites($prerequisitesStr, $prerequisitesArr) {

    // removes all spaces in the prerequisites string
    $prerequisitesStr = str_replace(' ', '', $prerequisitesStr);

    //this if statement checks if the prerequisites starts with a ( and ends with a )
    // to determine if it has ()

    while (strpos($prerequisitesStr, '(') !== false) {
        $start = strrpos($prerequisitesStr, '(');
        $end = strpos($prerequisitesStr, ')', $start);
        $insideParentheses = substr($prerequisitesStr, $start + 1, $end - $start - 1);
        $insideResult = evaluatePrerequisites($insideParentheses, $prerequisitesArr);
        $prerequisitesStr = substr_replace($prerequisitesStr, $insideResult ? '1' : '0', $start, $end - $start + 1);
    }

    if (preg_match('/(\d+)\sof/i', $prerequisitesStr, $matches)) {
        // Extract the numeric requirement
        $requiredCount = (int)$matches[1];

        // Split the string into components
        $components = explode($matches[0], $prerequisitesStr);

        // Extract the conditions within parentheses
        $parenthesesConditions = explode('(', $components[1]);
        $parenthesesConditions = str_replace(')', '', $parenthesesConditions);

        // Count how many conditions are specified
        $numConditions = count($parenthesesConditions);

        // Count how many of these conditions are satisfied
        $satisfiedConditions = 0;
        foreach ($parenthesesConditions as $condition) {
            if (evaluatePrerequisites($condition, $prerequisitesArr)) {
                $satisfiedConditions++;
            }
        }
        $prerequisitesStr = substr_replace($prerequisitesStr, $insideResult ? '1' : '0', $start, $end - $start + 1);
    }

    // Evaluate OR conditions
    // use strpos to check if there is an OR statement in the prerequisites string
    //if found evaluate to TRUE
    if (strpos($prerequisitesStr, 'OR') !== false) {


        //Splits the string into an array of conditions using the "OR" operator.
        $orConditions = explode('OR', $prerequisitesStr);

        //it loops through each OR condition 
        //Calls the evaluatePrerequisites function recursively to evaluate each condition. 
        foreach ($orConditions as $condition) {
            // this should work if any or is found
            if ($condition == '1'){
                return true;
            }
            if (evaluatePrerequisites($condition, $prerequisitesArr)) {
                return true;
            }

            //echo "Evaluating condition: $condition\n";
        }
        return false;
    }

    // Evaluate AND conditions
    if (strpos($prerequisitesStr, 'AND') !== false) {

        //Splits the string into an array of conditions using the "OR" operator.
        $andConditions = explode('AND', $prerequisitesStr);

        //it loops through each OR condition 
        //Calls the evaluatePrerequisites function recursively to evaluate each condition. 
        foreach ($andConditions as $condition) {
            if ($condition == '1'){
                continue;
            }

            if (!evaluatePrerequisites($condition, $prerequisitesArr)) {
                return false;
            }
        }
        return true;
    }

    // Handle single condition
    foreach ($prerequisitesArr as $prerequisite) {
        if (strcasecmp($prerequisitesStr, $prerequisite) === 0) {
            return true;
        }
    }

    return false;
}



