<?php
include_once 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Create Course
    if (isset($_POST["create_course"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];

        $sql = "INSERT INTO Course (name, description) VALUES ('$name', '$description')";
        performQuery($sql);
    }

    // Read Courses
    if (isset($_POST["read_courses"])) {
        $sql = "SELECT id, name, description FROM Course";
        $courses = fetchData($sql);
    }

    // Update Course
    if (isset($_POST["update_course"])) {
        $newName = $_POST["new_name"];
        $newDescription = $_POST["new_description"];
        $idToUpdate = $_POST["course_id"];

        $sql = "UPDATE Course SET name='$newName', description='$newDescription' WHERE id=$idToUpdate";
        performQuery($sql);
    }

    // Delete Course
    if (isset($_POST["delete_course"])) {
        $idToDelete = isset($_POST["course_id_delete"]) ? $_POST["course_id_delete"] : null;

        if ($idToDelete !== null) {
            $sql = "DELETE FROM Course WHERE id=$idToDelete";
            performQuery($sql);
        } else {
            echo "Course ID to delete is not set.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management System</title>
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

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        button {
            background-color: #1a6ebd;
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

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1a6ebd;
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- HTML form for creating a course -->
    <form method="post">
        <h2>Create Course</h2>
        <label for="name">Course Name:</label>
        <input type="text" name="name" required>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <button type="submit" name="create_course">Create Course</button>
    </form>

    <!-- HTML form for reading courses -->
    <form method="post">
        <h2>Read Courses</h2>
        <button type="submit" name="read_courses">Read Courses</button>
    </form>

    <!-- Display code for courses -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["read_courses"])) {
        $sql = "SELECT id, name, description FROM Course";
        $courses = fetchData($sql);
        if (!empty($courses)) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>";
            foreach ($courses as $course) {
                echo "<tr>
                        <td>{$course['id']}</td>
                        <td>{$course['name']}</td>
                        <td>{$course['description']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No courses found.</p>";
        }
    }
    ?>

    <!-- HTML form for updating a course -->
    <form method="post">
        <h2>Update Course</h2>
        <label for="new_name">New Course Name:</label>
        <input type="text" name="new_name" required>
        <label for="new_description">New Course Description:</label>
        <textarea name="new_description" required></textarea>
        <label for="course_id">Course ID to Update:</label>
        <input type="text" name="course_id" required>
        <button type="submit" name="update_course">Update Course</button>
    </form>


    <!-- HTML form for deleting a course -->
    <form method="post">
        <h2>Delete Course</h2>
        <label for="course_id_delete">Course ID to Delete:</label>
        <input type="text" name="course_id_delete" required>
        <button type="submit" name="delete_course">Delete Course</button>
    </form>


</body>
</html>
