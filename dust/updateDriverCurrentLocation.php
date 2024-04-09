<?php

header('Content-Type: application/json'); // Set the response content type to JSON
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Parse JSON data from the request body

    if (isset($data['lat'], $data['long'])) {

        $lat = $data['lat'];
        $long = $data['long'];


        updateDriverData($lat, $long);
    } else {
        echo json_encode(['error' => 'Invalid data provided']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

function updateDriverData($lat, $long) {
    global $conn;
       // Set the timezone to Sri Lanka
    date_default_timezone_set('Asia/Colombo');

    // Get the current date and time
    $date = date('Y-m-d H:i:s');
    // Update query
    $sql = "UPDATE `driver_data` SET `driverLat`='$lat', `driverLong`='$long', `date` = '$date' ";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'Record updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
    }
}

// Close connection (optional, as PHP will automatically close it at the end of the script)
$conn->close();

?>
