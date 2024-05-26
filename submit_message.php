<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "message_database"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape user inputs for security
$message = $conn->real_escape_string($_POST['message']);

// Insert message into database
$sql = "INSERT INTO messages (message) VALUES ('$message')";
if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
