<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add Course
    if (isset($_POST["add_course"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];

        // Find the first available (unused) ID
        $availableId = findAvailableId();

        $sql = "INSERT INTO Course (id, name, description) VALUES ('$availableId', '$name', '$description')";
        performQuery($sql);
    }

    // Delete Course
    if (isset($_POST["delete_course"])) {
        $idToDelete = $_POST["course_id"];
        $sql = "DELETE FROM Course WHERE id=$idToDelete";
        performQuery($sql);
    }
}

// Function to find the first available (unused) ID
function findAvailableId() {
    $sql = "SELECT id FROM Course";
    $existingIds = fetchData($sql);

    $id = 1;
    foreach ($existingIds as $existingId) {
        if ($id != $existingId['id']) {
            // Gap found, use this ID
            return $id;
        }
        $id++;
    }

    // No gap found, use the next ID
    return $id;
}

// Fetch and display the table
$sql = "SELECT id, name, description FROM Course";
$courses = fetchData($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses View</title>
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

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
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

        .pushable:hover .shadow {
            transform: translateY(4px);
            transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
        }

        .pushable:active .shadow {
            transform: translateY(1px);
            transition: transform 34ms;
        }

        .pushable:focus:not(:focus-visible) {
            outline: none;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
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

        .update-btn,
        .delete-btn {
            cursor: pointer;
            padding: 8px 12px;
            background-color: #1a6ebd;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-right: 8px;
            transition: background-color 0.3s;
        }

        .update-btn:hover,
        .delete-btn:hover {
            background-color: #15598a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Add Course</h2>
            <form method="POST" action="">
                <label for="name">Course Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <button class="pushable" type="submit" name="add_course">
                    <span class="shadow"></span>
                    <span class="edge"></span>
                    <span class="front">
                        Add
                    </span>
                </button>
            </form>
        </div>

        <!-- View Courses Table -->
        <div class="form-container">
            <h2>Courses</h2>
            <!-- Display the table -->
            <?php
            if (!empty($courses)) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>";
                foreach ($courses as $course) {
                    echo "<tr>
                            <td>{$course['id']}</td>
                            <td>{$course['name']}</td>
                            <td>{$course['description']}</td>
                            <td>
                                <button class='update-btn' onclick='updateCourse({$course['id']})'>Update</button>
                                <form style='display: inline;' method='POST' action=''>
                                    <input type='hidden' name='course_id' value='{$course['id']}'>
                                    <button class='delete-btn' type='submit' name='delete_course'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No courses found.</p>";
            }
            ?>
        </div>
            <!-- Button to go back to the home page -->
            <form method="GET" action="home_page.php">
                <button class="pushable" type="navigate" name="home_page">
                    <span class="shadow"></span>
                     <span class="edge"></span>
                    <span class="front">
                        Go Back to Home 
                    </span>
                </button>
            </form>
    </div>

    <script>
        function updateCourse(courseId) {
            window.location.href = "update_course.php?course_id=" + courseId;
        }
    </script>
</body>
</html>
