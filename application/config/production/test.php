<?php
$servername = "10.10.20.122";
$username = "ginside";
$password = "FXO7T2wL2U";
$dbname = "ginside_mobo_vn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO mfb (idfb, message, type)
VALUES ('5', 'aaahello', '33')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 
