<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Create Enrollment
    if (isset($_POST["create_enrollment"])) {
        $studentId = $_POST["student_id"];
        $courseId = $_POST["course_id"];

        // Check if the student exists before creating the enrollment
        $checkStudentSql = "SELECT * FROM Student WHERE id = $studentId";
        $existingStudent = fetchData($checkStudentSql);

        if ($existingStudent) {
            // Student exists, proceed with enrollment creation
            $sql = "INSERT INTO Enrollment (student_id, course_id) VALUES ('$studentId', '$courseId')";
            performQuery($sql);
        } else {
            // Student does not exist, handle the error (display a message or redirect)
            echo "Error: Student with ID $studentId does not exist.";
        }
    }

    // Read Enrollments
    if (isset($_POST["read_enrollments"])) {
        $sql = "SELECT id, student_id, course_id FROM Enrollment";
        $enrollments = fetchData($sql);
    }

    // Update Enrollment
    if (isset($_POST["update_enrollment"])) {
        $newStudentId = $_POST["new_student_id"];
        $idToUpdate = $_POST["enrollment_id"];

        $sql = "UPDATE Enrollment SET student_id='$newStudentId' WHERE id=$idToUpdate";
        performQuery($sql);
    }

    // Delete Enrollment
    if (isset($_POST["delete_enrollment"])) {
        $idToDelete = $_POST["enrollment_id"];
        $sql = "DELETE FROM Enrollment WHERE id=$idToDelete";
        performQuery($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- HTML form for creating an enrollment -->
    <form method="post">
        <h2>Create Enrollment</h2>
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required>
        
        <label for="course_id">Course ID:</label>
        <input type="text" name="course_id" required>

        <button type="submit" name="create_enrollment">Check Enrollment</button>
    </form>

    <!-- Display code for enrollments -->
    <?php
    if (isset($enrollments) && is_array($enrollments)) {
        echo "<h2>Enrollments:</h2>";
        echo "<ul>";
        foreach ($enrollments as $enrollment) {
            echo "<li>Enrollment ID: {$enrollment['id']}, Student ID: {$enrollment['student_id']}, Course ID: {$enrollment['course_id']}</li>";
        }
        echo "</ul>";
    }
    ?>

</body>
</html>
