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

    // View Instructors
    if (isset($_POST["view_instructors"])) {
        $sql = "SELECT id, name, email, specialty FROM Instructor";
        $instructors = fetchData($sql);
    }

    // Update Instructor
    if (isset($_POST["update_instructor"])) {
        $newName = $_POST["new_name"];
        $newEmail = $_POST["new_email"];
        $newSpecialty = $_POST["new_specialty"];
        $idToUpdate = $_POST["instructor_id"];

        // Construct the update query with multiple fields
        $sql = "UPDATE Instructor SET ";
        $updateFields = [];

        if (!empty($newName)) {
            $updateFields[] = "name='$newName'";
        }

        if (!empty($newEmail)) {
            $updateFields[] = "email='$newEmail'";
        }

        if (!empty($newSpecialty)) {
            $updateFields[] = "specialty='$newSpecialty'";
        }

        $sql .= implode(", ", $updateFields);

        // Add the WHERE clause
        $sql .= " WHERE id=$idToUpdate";

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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Management System</title>
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

    <!-- HTML form for creating an instructor -->
    <form method="post">
        <h2>Add Instructor</h2>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" required>
        <button type="submit" name="add_instructor">Add Instructor</button>
    </form>

    <!-- HTML form for reading instructors -->
    <form method="post">
        <h2>View Instructors</h2>
        <button type="submit" name="view_instructors">View Instructors</button>
    </form>

    <!-- Display code for instructors -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["view_instructors"])) {
        $sql = "SELECT id, name, email, specialty FROM Instructor";
        $instructors = fetchData($sql);
        if (!empty($instructors)) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialty</th>
                    </tr>";
            foreach ($instructors as $instructor) {
                echo "<tr>
                        <td>{$instructor['id']}</td>
                        <td>{$instructor['name']}</td>
                        <td>{$instructor['email']}</td>
                        <td>{$instructor['specialty']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No instructors found.</p>";
        }
    }
    ?>

    <!-- HTML form for updating an instructor -->
    <form method="post">
        <h2>Update Instructor</h2>
        <label for="instructor_id">Instructor ID to Update:</label>
        <input type="text" name="instructor_id" required>
        <label for="new_name">New Name:</label>
        <input type="text" name="new_name">
        <label for="new_email">New Email:</label>
        <input type="email" name="new_email">
        <label for="new_specialty">New Specialty:</label>
        <input type="text" name="new_specialty">
        <button type="submit" name="update_instructor">Update Instructor</button>
    </form>

    <!-- HTML form for deleting an instructor -->
    <form method="post">
        <h2>Delete Instructor</h2>
        <label for="instructor_id">Instructor ID to Delete:</label>
        <input type="text" name="instructor_id" required>
        <button type="submit" name="delete_instructor">Delete Instructor</button>
    </form>

</body>
</html>