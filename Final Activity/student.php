<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add Student
    if (isset($_POST["add_student"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        // Find the first available (unused) ID
        $availableId = findAvailableId();
        
        $sql = "INSERT INTO Student (id, name, email, address) VALUES ('$availableId', '$name', '$email', '$address')";
        performQuery($sql);
    }

    // View Students
    if (isset($_POST["view_students"])) {
        $sql = "SELECT id, name, email, address FROM Student";
        $students = fetchData($sql);
    }

    // Update Student
    if (isset($_POST["update_student"])) {
        $newName = $_POST["new_name"];
        $newEmail = $_POST["new_email"];
        $newAddress = $_POST["new_address"];
        $idToUpdate = $_POST["student_id"];

        // Construct the update query with multiple fields
        $sql = "UPDATE Student SET ";
        $updateFields = [];

        if (!empty($newName)) {
            $updateFields[] = "name='$newName'";
        }

        if (!empty($newEmail)) {
            $updateFields[] = "email='$newEmail'";
        }

        if (!empty($newAddress)) {
            $updateFields[] = "address='$newAddress'";
        }

        $sql .= implode(", ", $updateFields);

        // Add the WHERE clause
        $sql .= " WHERE id=$idToUpdate";

        performQuery($sql);
    }

    // Delete Student
    if (isset($_POST["delete_student"])) {
        $idToDelete = $_POST["student_id"];
        $sql = "DELETE FROM Student WHERE id=$idToDelete";
        performQuery($sql);
    }
}

// Function to find the first available (unused) ID
function findAvailableId() {
    $sql = "SELECT id FROM Student";
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
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

    <!-- Add Student Form -->
    <form method="POST" action="">
        <h2>Add Student</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
        <button type="submit" name="add_student">Add Student</button>
    </form>

    <!-- View Students Table -->
    <h2>View Students</h2>
    <?php
    $sql = "SELECT id, name, email, address FROM Student";
    $students = fetchData($sql);
    if (!empty($students)) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>";
        foreach ($students as $student) {
            echo "<tr>
                    <td>{$student['id']}</td>
                    <td>{$student['name']}</td>
                    <td>{$student['email']}</td>
                    <td>{$student['address']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No students found.</p>";
    }
    ?>

    <!-- Update Student Form -->
    <form method="POST" action="">
        <h2>Update Student</h2>
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name">
        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email">
        <label for="new_address">New Address:</label>
        <input type="text" id="new_address" name="new_address">
        <button type="submit" name="update_student">Update Student</button>
    </form>

    <!-- Delete Student Form -->
    <form method="POST" action="">
        <h2>Delete Student</h2>
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <button type="submit" name="delete_student">Delete Student</button>
    </form>

</body>
</html>
