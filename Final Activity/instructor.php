<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add Instructor
    if (isset($_POST["add_instructor"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $specialty = $_POST["specialty"];

        // Find the first available (unused) ID
        $availableId = findAvailableId('Instructor');

        $sql = "INSERT INTO Instructor (id, name, email, specialty) VALUES ('$availableId', '$name', '$email', '$specialty')";
        performQuery($sql);
    }

    // Delete Instructor
    if (isset($_POST["delete_instructor"])) {
        $idToDelete = $_POST["instructor_id"];
        $sql = "DELETE FROM Instructor WHERE id=$idToDelete";
        performQuery($sql);

        // Fill gaps in IDs
        fillIdGaps('Instructor');
    }
}

// Function to find the first available (unused) ID
function findAvailableId($tableName) {
    $sql = "SELECT id FROM $tableName";
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

// Function to fill gaps in IDs caused by deletions
function fillIdGaps($tableName) {
    $sql = "SELECT id FROM $tableName ORDER BY id";
    $existingIds = fetchData($sql);

    $expectedId = 1;
    foreach ($existingIds as $existingId) {
        if ($existingId['id'] != $expectedId) {
            // Gap found, update the ID
            $updateSql = "UPDATE $tableName SET id=$expectedId WHERE id={$existingId['id']}";
            performQuery($updateSql);
        }
        $expectedId++;
    }
}

// Fetch and display the table
$sql = "SELECT id, name, email, specialty FROM Instructor";
$instructors = fetchData($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructors View</title>
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

        .delete-btn:hover {
            background-color: #15598a;
        }
        .update-btn {
            cursor: pointer;
            padding: 8px 12px;
            background-color: #1a6ebd;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-right: 8px;
            transition: background-color 0.3s;
        }

        .update-btn:hover {
            background-color: #15598a;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Add Instructor Form -->
        <div class="form-container">
            <h2>Add Instructor</h2>
            <form method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="specialty">Specialty:</label>
                <input type="text" id="specialty" name="specialty" required>
                <button class="pushable" type="submit" name="add_instructor">
                    <span class="shadow"></span>
                    <span class="edge"></span>
                    <span class="front">
                        Add
                    </span>
                </button>
            </form>
        </div>

        <!-- View Instructors Table -->
        <div class="form-container">
            <h2>Instructors</h2>
            <!-- Display the table -->
            <?php
            if (!empty($instructors)) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>";
                foreach ($instructors as $instructor) {
                    echo "<tr>
                            <td>{$instructor['id']}</td>
                            <td>{$instructor['name']}</td>
                            <td>{$instructor['email']}</td>
                            <td>{$instructor['specialty']}</td>
                            <td>
                                <button class='update-btn' onclick='updateInstructor({$instructor['id']})'>Update</button>
                                <form style='display: inline;' method='POST' action=''>
                                    <input type='hidden' name='instructor_id' value='{$instructor['id']}'>
                                    <button class='delete-btn' type='submit' name='delete_instructor'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No instructors found.</p>";
            }
            ?>
        </div>
    </div>

    <script>
    function updateInstructor(instructorId) {
        window.location.href = "update_instructor.php?instructor_id=" + instructorId;
    }
    </script>

</body>
</html>
