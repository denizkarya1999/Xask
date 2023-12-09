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
    $query = "SELECT * FROM GroupUsers WHERE GroupID = ?";
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
        echo json_encode(['error' => 'No group users found for the given GroupID']);
    }
    exit;
}

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM GroupUsers";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No records found']);
    }
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newGroupUserData = json_decode($post_data, true);

    $groupID = $newGroupUserData['GroupID'];
    $userID = $newGroupUserData['UserID'];

    $query = "INSERT INTO GroupUsers (GroupID, UserID) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $groupID, $userID);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'GroupUser record created successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $put_data = file_get_contents("php://input");
    $updatedGroupUserData = json_decode($put_data, true);

    $groupUserID = $updatedGroupUserData['GroupUserID'];
    $groupID = $updatedGroupUserData['GroupID'];
    $userID = $updatedGroupUserData['UserID'];

    $query = "UPDATE GroupUsers SET GroupID=?, UserID=? WHERE GroupUserID=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("iii", $groupID, $userID, $groupUserID);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(['message' => 'GroupUser record updated successfully']);
        } else {
            echo json_encode(['error' => 'Error updating the GroupUser record']);
        }
    } else {
        echo json_encode(['error' => 'Error preparing the statement']);
    }
    exit;
}

// Check if it's a DELETE request and contains 'GroupUserID'
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['GroupUserID'])) {
    $groupUserID = $_GET['GroupUserID'];
    $query = "DELETE FROM GroupUsers WHERE GroupUserID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $groupUserID);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['message' => 'GroupUser record deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the GroupUser record']);
    }
    exit;
}

$mysqli->close();
?>
