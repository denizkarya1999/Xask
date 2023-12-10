<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addTask"])) {
    // Retrieve data from the form
    $inputData = isset($_POST["description"]) ? $_POST["description"] : "";

    // Perform any server-side processing here
    // For demonstration purposes, we'll just echo the input
    echo "Data submitted: " . htmlspecialchars($description);
} else {
    // Handle invalid request method or button not clicked
    echo "Invalid request or button not clicked";
}
?>
