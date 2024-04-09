<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'manager_id' is set in the POST data
    if (isset($data['manager_id'])) {
        $managerId = $data['manager_id'];
        $notificationStatus = $data['notificationStatus'];

        // Update the 'notification' field in the 'admin' table to '1'
        $updateSql = "UPDATE `admin` SET `notification`='$notificationStatus' WHERE `manager_id`='$managerId'";

        if ($conn->query($updateSql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating record: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'manager_id not provided']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
