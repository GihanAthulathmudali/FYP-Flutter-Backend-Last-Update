<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if all required data is set in the POST data
    if (isset($data['manager_id'], $data['manager_name'], $data['drivercompleted'], $data['visibled'])) {
        $managerId = $data['manager_id'];
        $managerName = $data['manager_name'];
        $driverCompleted = $data['drivercompleted'];
        $visibled = $data['visibled'];

        // Get the current date in Sri Lanka timezone
        $date = new DateTime('now', new DateTimeZone('Asia/Colombo'));
        $currentDate = $date->format('Y-m-d H:i:s');

        // Insert a new record into the 'drivercomplete_data' table
        $insertSql = "INSERT INTO `drivercomplete_data`(`manager_id`, `manager_name`, `drivercompleted`, `visibled`, `date`) 
                      VALUES ('$managerId', '$managerName', '$driverCompleted', '$visibled', '$currentDate')";

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
