<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tamondong";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute queries
function performQuery($sql) {
    global $conn;
    return $conn->query($sql);
}

// Function to fetch data
function fetchData($sql) {
    global $conn;
    $result = $conn->query($sql);
    
    $data = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return $data;
}

?>
