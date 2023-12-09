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

        /* Updated button styles */
        .pushable {
            position: relative;
            background: transparent;
            padding: 0px;
            border: none;
            cursor: pointer;
            outline-offset: 4px;
            outline-color: deeppink;
            transition: filter 250ms;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        .shadow {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: hsl(226, 25%, 69%);
            border-radius: 8px;
            filter: blur(2px);
            will-change: transform;
            transform: translateY(2px);
            transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
        }

        .edge {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: 8px;
            background: linear-gradient(
                to right,
                hsl(248, 39%, 39%) 0%,
                hsl(248, 39%, 49%) 8%,
                hsl(248, 39%, 39%) 92%,
                hsl(248, 39%, 29%) 100%
            );
        }

        .front {
            display: block;
            position: relative;
            border-radius: 8px;
            background: #1a6ebd;
            padding: 16px 32px;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
            Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 1rem;
            transform: translateY(-4px);
            transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
        }

        .pushable:hover {
            filter: brightness(110%);
        }

        .pushable:hover .front {
            transform: translateY(-6px);
            transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
        }

        .pushable:active .front {
            transform: translateY(-2px);
            transition: transform 34ms;
        }

        .pushable:focus:not(:focus-visible) {
            outline: none;
        }

        /* End updated button styles */

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
        <button class="pushable" type="submit" name="create_course">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front">
                Create Course
            </span>
        </button>
    </form>

    <!-- HTML form for reading courses -->
    <form method="post">
        <h2>Read Courses</h2>
        <button class="pushable" type="submit" name="read_courses">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front">
                View
            </span>
        </button>
    </form>
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
        <button class="pushable" type="submit" name="update_course">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front">
                Update
            </span>
        </button>
    </form>

    <!-- HTML form for deleting a course -->
    <form method="post">
        <h2>Delete Course</h2>
        <label for="course_id_delete">Course ID to Delete:</label>
        <input type="text" name="course_id_delete" required>
        <button class="pushable" type="submit" name="delete_course">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front">
                Delete
            </span>
        </button>
    </form>

</body>
</html>
