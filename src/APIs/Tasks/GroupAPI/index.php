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

// Check if it's a POST request to create a new group
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newGroupData = json_decode($post_data, true);

    $name = $newGroupData['Name'];
    $productivityScore = $newGroupData['Productivity_Score'];

    $query = "INSERT INTO `group` (Name, Productivity_Score) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $name, $productivityScore);
    
    if ($stmt->execute()) {
        $insertedId = $mysqli->insert_id;
        $query = "SELECT * FROM `group` WHERE GroupID = $insertedId";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a GET request to fetch a specific group by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['GroupID'])) {
    $groupID = $_GET['GroupID'];
    $query = "SELECT * FROM `group` WHERE GroupID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $groupID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No group found with the given ID']);
    }
    exit;
}

// Check if it's a GET request to fetch groups
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM `group`";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No groups found']);
    }
    exit;
}

// Check if it's a PUT request to update a group
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['GroupID'])) {
    $put_data = file_get_contents("php://input");
    $updatedGroupData = json_decode($put_data, true);

    $groupID = $updatedGroupData['GroupID'];
    $name = $updatedGroupData['Name'];
    $productivityScore = $updatedGroupData['Productivity_Score'];

    $query = "UPDATE `group` SET Name=?, Productivity_Score=? WHERE GroupID=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sii", $name, $productivityScore, $groupID);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode($updatedGroupData);
        } else {
            echo json_encode(['error' => 'Error updating the database']);
        }
    } else {
        echo json_encode(['error' => 'Error preparing the statement']);
    }
    exit;
}

// Check if it's a DELETE request to delete a group
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['GroupID'])) {
    $id = $_GET['GroupID'];
    $query = "DELETE FROM `group` WHERE GroupID = $id";
    $result = $mysqli->query($query);

    if ($result) {
        echo json_encode(['message' => 'Group deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the group']);
    }
    exit;
}

$mysqli->close();
?>