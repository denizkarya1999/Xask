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
    die("Failed to connect to MariaDB: " . $mysqli->connect_error);
}

// Check if it's a GET request to fetch a specific user by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['UserID'])) {
    $userID = $_GET['UserID'];
    
    $query = "SELECT * FROM useraccount WHERE UserID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No user found with the given ID']);
    }
    exit;
}

// For handling GET requests to fetch all user accounts
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM useraccount";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No user accounts found']);
    }
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $newUserData = json_decode($post_data, true);

    $userID = $newUserData['userID'];
    $FirstName = $newUserData['FirstName'];
    $LastName = $newUserData['LastName'];
    $Email = $newUserData['Email'];
    $Password = $newUserData['Password'];
    $ProductivityScore = $newUserData['ProductivityScore'];

    $query = "INSERT INTO useraccount (userID, FirstName, LastName, Email, Password, ProductivityScore) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $userID, $FirstName, $LastName, $Email, $Password, $ProductivityScore);
    
    if ($stmt->execute()) {
        $insertedId = $mysqli->insert_id;
        $query = "SELECT * FROM useraccount WHERE userID = $insertedId";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Error inserting into the database']);
    }
    $stmt->close();
    exit;
}

// Check if it's a PUT request and contains an 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['userID'])) {
    $put_data = file_get_contents("php://input");
    $updatedUserData = json_decode($put_data, true);

    $userID = $updatedUserData['userID'];
    $FirstName = $updatedUserData['FirstName'];
    $LastName = $updatedUserData['LastName'];
    $Email = $updatedUserData['Email'];
    $Password = $updatedUserData['Password'];
    $ProductivityScore = $updatedUserData['ProductivityScore'];

    $query = "UPDATE useraccount SET FirstName=?, LastName=?, Email=?, Password=?, ProductivityScore=? WHERE userID=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssss", $FirstName, $LastName, $Email, $Password, $ProductivityScore, $userID);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode($updatedUserData);
        } else {
            echo json_encode(['error' => 'Error updating the database']);
        }
    } else {
        echo json_encode(['error' => 'Error preparing the statement']);
    }
    exit;
}

// Check if it's a DELETE request and contains an 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['userID'])) {
    $id = $_GET['userID'];
    $query = "DELETE FROM useraccount WHERE userID = $id";
    $result = $mysqli->query($query);

    if ($result) {
        echo json_encode(['message' => 'User account deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting the user account']);
    }
    exit;
}

$mysqli->close();
?>