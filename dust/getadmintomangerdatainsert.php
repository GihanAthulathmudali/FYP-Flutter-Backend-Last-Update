<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['managerId'])) {
        $managerId = $data['managerId'];

        // Select query to retrieve records based on manager_id
        $selectSql = "SELECT * FROM admin WHERE manager_id = '$managerId'";
        $selectResult = $conn->query($selectSql);

        if ($selectResult) {
            if ($selectResult->num_rows > 0) {
                // Fetch the first row as an associative array
                $insertedRecord = $selectResult->fetch_assoc();

                // You can perform additional actions with the fetched data here
                // For example, you might want to manipulate the data or send it as JSON response

                // Send the fetched data as a JSON response
                echo json_encode(['success' => true, 'data' => $insertedRecord]);
            } else {
                // No matching records found
                echo json_encode(['success' => false, 'message' => 'No records found']);
            }
        } else {
            // Error in the query
            echo json_encode(['success' => false, 'message' => 'Query execution failed']);
        }
    } else {
        // 'managerId' is not set in the input data
        echo json_encode(['success' => false, 'message' => 'Manager ID is not provided']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
