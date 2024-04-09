<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required data is set in the POST data
    if (isset($data['manager_id'], $data['visibled'])) {
        $managerId = $data['manager_id'];
        $visibled = $data['visibled'];



        // Insert a new record into the 'drivercomplete_data' table
        $insertSql = "UPDATE `drivercomplete_data` SET `visibled`='$visibled' WHERE `manager_id` = '$managerId' ";

        if ($conn->query($insertSql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Record inserted successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error inserting record: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Incomplete data provided']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

?>
