<?php

header('Content-Type: application/json'); // Set the response content type to JSON
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Parse JSON data from the request body

    if (isset($data['managerId'])) {
        $managerId = $data['managerId'];

        // Select query
        $sql = "SELECT * FROM `manager_data` WHERE `manager_id`='$managerId'";
        
        $result = $conn->query($sql);

        if ($result) {
            // Fetch the data
            $row = $result->fetch_assoc();

            if ($row) {
                echo json_encode(['success' => 'Record retrieved successfully', 'data' => $row]);
            } else {
                echo json_encode(['error' => 'No record found for the given managerId']);
            }
        } else {
            echo json_encode(['error' => 'Error executing the query: ' . $conn->error]);
        }
    } else {
        echo json_encode(['error' => 'Invalid data provided']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

// Close connection (optional, as PHP will automatically close it at the end of the script)
$conn->close();

?>
