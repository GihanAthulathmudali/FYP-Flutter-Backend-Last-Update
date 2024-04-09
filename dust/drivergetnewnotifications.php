<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Select query to retrieve records based on manager_id
    $selectSql = "SELECT * FROM admin WHERE status = '1' AND aproval = '1' AND notificationDriver = '0' ORDER BY date DESC";
    $selectResult = $conn->query($selectSql);

    if ($selectResult) {
        if ($selectResult->num_rows > 0) {
            $records = array();

            // Fetch all rows as associative arrays
            while ($row = $selectResult->fetch_assoc()) {
                $records[] = $row;
            }

            // You can perform additional actions with the fetched data here
            // For example, you might want to manipulate the data or send it as JSON response

            // Send the fetched data as a JSON response
            echo json_encode(['success' => true, 'data' => $records]);
        } else {
            // No matching records found
            echo json_encode(['success' => false, 'message' => 'No records found']);
        }
    } else {
        // Error in the query
        echo json_encode(['success' => false, 'message' => 'Query execution failed: ' . $conn->error]);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close connection
$conn->close();

?>
