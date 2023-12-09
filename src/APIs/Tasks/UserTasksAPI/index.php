<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

// Connect to the database
$servername = "localhost";
$username = "dacikbas";
$password = "karya99da";
$dbname = "taskmanagerdatabase";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if it's a GET request and contains 'UserID'
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['UserID'])) {
    $userID = $_GET['UserID'];

    $query = "SELECT * FROM UserTasks WHERE UserID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No user tasks found for the given UserID']);
    }
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newUserTaskData = json_decode($post_data, true);

    $userID = $newUserTaskData['UserID'];
    $taskID = $newUserTaskData['TaskID'];

    $query = "INSERT INTO UserTasks (UserID, TaskID) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userID, $taskID);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'UserTask record created successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $put_data);
    $userID = $put_data['UserID'];
    $taskID = $put_data['TaskID'];

    $query = "UPDATE UserTasks SET TaskID = ? WHERE UserID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $taskID, $userID);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'UserTask record updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['UserID'])) {
    $userID = $_GET['UserID'];

    $query = "DELETE FROM UserTasks WHERE UserID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['message' => 'UserTask record deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the UserTask record']);
    }
    $stmt->close();
    exit;
}

$mysqli->close();
?>