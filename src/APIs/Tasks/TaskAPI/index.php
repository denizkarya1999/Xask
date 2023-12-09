<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Connect to the database
$servername = "localhost";
$username = "dacikbas";
$password = "karya99da";
$dbname = "taskmanagerdatabase";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Check if it's a POST request to create a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newTaskData = json_decode($post_data, true);

    $name = $newTaskData['Name'];
    $description = $newTaskData['Description'];
    $difficultyLevel = $newTaskData['DifficultyLevel'];
    $completionStatus = $newTaskData['CompletionStatus'];
    $userID = $newTaskData['UserID'];
    $groupID = $newTaskData['GroupID'];

    $query = "INSERT INTO task (Name, Description, DifficultyLevel, CompletionStatus, UserID, GroupID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssii", $name, $description, $difficultyLevel, $completionStatus, $userID, $groupID);

    if ($stmt->execute()) {
        $insertedId = $mysqli->insert_id;
        $query = "SELECT * FROM task WHERE TaskID = $insertedId";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a GET request to fetch tasks by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['TaskID'])) {
    $taskID = $_GET['TaskID'];
    $query = "SELECT * FROM task WHERE TaskID = $taskID";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $task = $result->fetch_assoc();
        echo json_encode($task);
    } else {
        echo json_encode(['error' => 'Task not found']);
    }
    exit;
}

// Check if it's a GET request to fetch tasks
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM task";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No tasks found']);
    }
    exit;
}

// Check if it's a PUT request to update a task
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['TaskID'])) {
    $put_data = file_get_contents("php://input");
    $updatedTaskData = json_decode($put_data, true);

    $taskID = $updatedTaskData['TaskID'];
    $name = $updatedTaskData['Name'];
    $description = $updatedTaskData['Description'];
    $difficultyLevel = $updatedTaskData['DifficultyLevel'];
    $completionStatus = $updatedTaskData['CompletionStatus'];
    $userID = $updatedTaskData['UserID'];
    $groupID = $updatedTaskData['GroupID'];

    $query = "UPDATE task SET Name=?, Description=?, DifficultyLevel=?, CompletionStatus=?, UserID=?, GroupID=? WHERE TaskID=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssiiii", $name, $description, $difficultyLevel, $completionStatus, $userID, $groupID, $taskID);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode($updatedTaskData);
        } else {
            echo json_encode(['error' => 'Error updating the database']);
        }
    } else {
        echo json_encode(['error' => 'Error preparing the statement']);
    }
    exit;
}

// Check if it's a DELETE request to delete a task
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['TaskID'])) {
    $id = $_GET['TaskID'];
    $query = "DELETE FROM task WHERE TaskID = $id";
    $result = $mysqli->query($query);

    if ($result) {
        echo json_encode(['message' => 'Task deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the task']);
    }
    exit;
}

$mysqli->close();
?>