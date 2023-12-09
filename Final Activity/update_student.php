<?php
include_once 'db.php';

// Fetch student information based on the provided student_id
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["student_id"])) {
        $studentId = $_GET["student_id"];
        $sql = "SELECT id, name, email, address FROM Student WHERE id = $studentId";
        $student = fetchData($sql);
    }
}

// Handle form submission for updating student information
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["update_student"])) {
        $idToUpdate = $_POST["student_id"];
        $newName = $_POST["new_name"];
        $newEmail = $_POST["new_email"];
        $newAddress = $_POST["new_address"];

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

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE Student SET " . implode(", ", $updateFields) . " WHERE id=$idToUpdate";
            performQuery($updateQuery);

            // Redirect back to student.php after successful update
            header("Location: student.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Information</title>
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
    </style>
</head>
<body>
<div class="container">
        <h2>Update Student Information</h2>
        <?php
        if (isset($student) && !empty($student)) {
            foreach ($student as $studentData) {
        ?>
               
                        <form method="POST" action="">
            <input type="hidden" name="student_id" value="<?php echo $studentData['id']; ?>">
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo $studentData['name']; ?>" required>
            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email" value="<?php echo $studentData['email']; ?>" required>
            <label for="new_address">New Address:</label>
            <input type="text" id="new_address" name="new_address" value="<?php echo $studentData['address']; ?>">
            <button class="pushable" type="submit" name="update_student">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front">
                    Update
                </span>
            </button>
        </form>

        <?php
            }
        } else {
            echo "<p>Update Successful. You will be redirected back to the student list.</p>";
            // Include a JavaScript redirection fallback in case header() fails
            echo "<script>setTimeout(function() { window.location.href = 'student.php'; }, 3000);</script>";
        }
        ?>
    </div>
</body>
</html>
