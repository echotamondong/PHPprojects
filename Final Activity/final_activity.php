<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tamondong";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS Tamondong";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Switch to the created database
$conn->select_db("Tamondong");

// Create Users table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully<br>";
} else {
    echo "Error creating table Users: " . $conn->error . "<br>";
}

// Create Student table
$sql = "CREATE TABLE IF NOT EXISTS Student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Student created successfully<br>";
} else {
    echo "Error creating table Student: " . $conn->error . "<br>";
}

// Create Course table
$sql = "CREATE TABLE IF NOT EXISTS Course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Course created successfully<br>";
} else {
    echo "Error creating table Course: " . $conn->error . "<br>";
}

// Create Instructor table
$sql = "CREATE TABLE IF NOT EXISTS Instructor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    specialty VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Instructor created successfully<br>";
} else {
    echo "Error creating table Instructor: " . $conn->error . "<br>";
}

// Create Enrollment table
$sql = "CREATE TABLE IF NOT EXISTS Enrollment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    FOREIGN KEY (student_id) REFERENCES Student(id),
    FOREIGN KEY (course_id) REFERENCES Course(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Enrollment created successfully<br>";
} else {
    echo "Error creating table Enrollment: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>