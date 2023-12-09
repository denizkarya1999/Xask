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

// Check if it's a GET request and contains 'GroupID'
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['GroupID'])) {
    $groupID = $_GET['GroupID'];
    
    $query = "SELECT * FROM GroupTasks WHERE GroupID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $groupID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No tasks found for the given GroupID']);
    }
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newGroupTaskData = json_decode($post_data, true);

    $groupID = $newGroupTaskData['GroupID'];
    $taskID = $newGroupTaskData['TaskID'];

    $query = "INSERT INTO GroupTasks (GroupID, TaskID) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $groupID, $taskID);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'GroupTask record created successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $put_data = file_get_contents("php://input");
    $updatedGroupTaskData = json_decode($put_data, true);

    $groupTaskID = $updatedGroupTaskData['GroupTaskID'];
    $groupID = $updatedGroupTaskData['GroupID'];
    $taskID = $updatedGroupTaskData['TaskID'];

    $query = "UPDATE GroupTasks SET GroupID=?, TaskID=? WHERE GroupTaskID=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("iii", $groupID, $taskID, $groupTaskID);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(['message' => 'GroupTask record updated successfully']);
        } else {
            echo json_encode(['error' => 'Error updating the GroupTask record']);
        }
    } else {
        echo json_encode(['error' => 'Error preparing the statement']);
    }
    exit;
}

// Check if it's a DELETE request and contains 'GroupTaskID'
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['GroupTaskID'])) {
    $groupTaskID = $_GET['GroupTaskID'];
    $query = "DELETE FROM GroupTasks WHERE GroupTaskID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $groupTaskID);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['message' => 'GroupTask record deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the GroupTask record']);
    }
    exit;
}

$mysqli->close();
?>