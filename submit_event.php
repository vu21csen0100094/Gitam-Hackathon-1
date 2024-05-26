<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "event_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape user inputs for security
$eventName = $conn->real_escape_string($_POST['eventName']);
$clubName = $conn->real_escape_string($_POST['clubName']);
$eventDate = $conn->real_escape_string($_POST['eventDate']);
$eventDescription = $conn->real_escape_string($_POST['eventDescription']);

// Insert event into database
$sql = "INSERT INTO events (event_name, club_name, event_date, event_description) VALUES ('$eventName', '$clubName', '$eventDate', '$eventDescription')";
if ($conn->query($sql) === TRUE) {
    // Redirect to confirmation page with data
    header("Location: confirmation.html?eventName=$eventName&clubName=$clubName&eventDate=$eventDate&eventDescription=" . urlencode($eventDescription));
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
