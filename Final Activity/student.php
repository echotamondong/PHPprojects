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

// Fetch and display the table
$sql = "SELECT id, name, email, address FROM Student";
$students = fetchData($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students View</title>
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
        <!-- Add Student Form -->
        <div class="form-container">
            <h2>Add Student</h2>
            <form method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address">
                <button class="pushable" type="submit" name="add_student">
                    <span class="shadow"></span>
                    <span class="edge"></span>
                    <span class="front">
                        Add
                    </span>
                </button>
            </form>
        </div>

        <!-- View Students Table -->
        <div class="form-container">
            <h2>Students</h2>
            <!-- Display the table -->
            <?php
            if (!empty($students)) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>";
                foreach ($students as $student) {
                    echo "<tr>
                            <td>{$student['id']}</td>
                            <td>{$student['name']}</td>
                            <td>{$student['email']}</td>
                            <td>{$student['address']}</td>
                            <td>
                                <button class='update-btn' onclick='updateStudent({$student['id']})'>Update</button>
                                <form style='display: inline;' method='POST' action=''>
                                    <input type='hidden' name='student_id' value='{$student['id']}'>
                                    <button class='delete-btn' type='submit' name='delete_student'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No students found.</p>";
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
        function updateStudent(studentId) {
            window.location.href = "update_student.php?student_id=" + studentId;
        }
    </script>
</body>
</html>
