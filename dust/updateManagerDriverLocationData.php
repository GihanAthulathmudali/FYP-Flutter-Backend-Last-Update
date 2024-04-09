<?php

header('Content-Type: application/json'); // Set the response content type to JSON
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Parse JSON data from the request body

    if (isset($data['managerId'], $data['lat'], $data['long'], $data['true'])) {
        $managerId = $data['managerId'];
        $lat = $data['lat'];
        $long = $data['long'];
        $true = $data['true'];

        updateManagerData($managerId, $lat, $long, $true);
    } else {
        echo json_encode(['error' => 'Invalid data provided']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

function updateManagerData($managerId, $lat, $long, $true) {
    global $conn;
       // Set the timezone to Sri Lanka
    date_default_timezone_set('Asia/Colombo');

    // Get the current date and time
    $date = date('Y-m-d H:i:s');
    // Update query
    $sql = "UPDATE `manager_data` SET `driverLat`='$lat', `driverLong`='$long', `driverAccepted`='$true', `date` = '$date' WHERE `manager_id`='$managerId'";
    $sq2 = "UPDATE `manager_data` SET `driverAccepted`='0' WHERE `manager_id`!='$managerId'";
    $conn->query($sq2);
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'Record updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
    }
}

// Close connection (optional, as PHP will automatically close it at the end of the script)
$conn->close();

?>
