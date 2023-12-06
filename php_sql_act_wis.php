<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "PHPScriptDemo";


$conn = new mysqli($serverName, $userName, $password);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE DATABASE $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}


$conn->select_db($dbName);


$sql = "CREATE TABLE Student (
    StudentID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    DateOfBirth DATE,
    Email VARCHAR(100),
    Phone VARCHAR(20)
    -- add other attributes
)";
if ($conn->query($sql) === TRUE) {
    echo "Student table created successfully\n";
} else {
    echo "Error creating Student table: " . $conn->error . "\n";
}


$sql = "CREATE TABLE Course (
    CourseID INT PRIMARY KEY,
    CourseName VARCHAR(100),
    Credits INT
    -- add other attributes
)";
if ($conn->query($sql) === TRUE) {
    echo "Course table created successfully\n";
} else {
    echo "Error creating Course table: " . $conn->error . "\n";
}


$sql = "CREATE TABLE Instructor (
    InstructorID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    Phone VARCHAR(20)
    -- add other attributes
)";
if ($conn->query($sql) === TRUE) {
    echo "Instructor table created successfully\n";
} else {
    echo "Error creating Instructor table: " . $conn->error . "\n";
}


$sql = "CREATE TABLE Enrollment (
    EnrollmentID INT PRIMARY KEY,
    StudentID INT,
    CourseID INT,
    EnrollmentDate DATE,
    Grade VARCHAR(5),
    FOREIGN KEY (StudentID) REFERENCES Student(StudentID),
    FOREIGN KEY (CourseID) REFERENCES Course(CourseID)
    -- add other attributes
)";
if ($conn->query($sql) === TRUE) {
    echo "Enrollment table created successfully\n";
} else {
    echo "Error creating Enrollment table: " . $conn->error . "\n";
}

$conn->close();
?>
