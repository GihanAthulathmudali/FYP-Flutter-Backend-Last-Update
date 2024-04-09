<?php

header('Content-Type: application/json'); // Set the response content type to JSON
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Parse JSON data from the request body

    if (isset($data['managerId'])) {
        $managerId = $data['managerId'];

        // Initialize status, binlevel, and approval with default values
        $status = isset($data['status']) ? $data['status'] : '0';
        $binlevel = isset($data['binlevel']) ? $data['binlevel'] : '0';
        $approval = isset($data['approval']) ? $data['approval'] : '0';

        // Set the current date and time
        $sriLankaTimeZone = new DateTimeZone('Asia/Colombo');
        $date = new DateTime('now', $sriLankaTimeZone);
        $formattedDate = $date->format('Y-m-d H:i:s');

        // Check if the record already exists
        $checkIfExistsSql = "SELECT COUNT(*) as count FROM admin WHERE manager_id = '$managerId'";
        $result = $conn->query($checkIfExistsSql);

        if ($result) {
            $row = $result->fetch_assoc();
            $recordCount = $row['count'];

            // If the record exists, update it
            if ($recordCount > 0) {
                $updateSql = "UPDATE admin SET status = '$status', binlevel = '$binlevel', aproval = '$approval', date='$formattedDate' WHERE manager_id = '$managerId'";
                if ($conn->query($updateSql) === TRUE) {
                    // Fetch the updated record
                    $selectSql = "SELECT * FROM admin WHERE manager_id = '$managerId'";
                    $selectResult = $conn->query($selectSql);

                    if ($selectResult && $selectResult->num_rows > 0) {
                        $updatedRecord = $selectResult->fetch_assoc();
                        echo json_encode(['success' => 'Record updated successfully', 'data' => $updatedRecord]);
                    } else {
                        echo json_encode(['error' => 'Error fetching updated record: ' . $conn->error]);
                    }
                } else {
                    echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
                }
            } else {
                // If the record does not exist, insert it
                $insertSql = "INSERT INTO admin (`manager_id`, `status`, `binlevel`, `aproval`, `date`)
                    VALUES ('$managerId', '$status', '$binlevel', '$approval', '$formattedDate')";
                if ($conn->query($insertSql) === TRUE) {
                    // Fetch the inserted record
                    $selectSql = "SELECT * FROM admin WHERE manager_id = '$managerId'";
                    $selectResult = $conn->query($selectSql);

                    if ($selectResult && $selectResult->num_rows > 0) {
                        $insertedRecord = $selectResult->fetch_assoc();
                        echo json_encode(['success' => 'Record inserted successfully', 'data' => $insertedRecord]);
                    } else {
                        echo json_encode(['error' => 'Error fetching inserted record: ' . $conn->error]);
                    }
                } else {
                    echo json_encode(['error' => 'Error inserting record: ' . $conn->error]);
                }
            }
        } else {
            echo json_encode(['error' => 'Error checking record existence: ' . $conn->error]);
        }

        // Close connection
        $conn->close();
    } else {
        echo json_encode(['error' => 'Invalid data provided']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
