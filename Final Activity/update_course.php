<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if the course_id parameter is set in the URL
    if (isset($_GET["course_id"])) {
        $courseId = $_GET["course_id"];

        // Fetch course details based on the provided course_id
        $sql = "SELECT id, name, description FROM Course WHERE id=$courseId";
        $course = fetchData($sql);

        // Check if the course is found
        if (!empty($course)) {
            $course = $course[0]; // Extract the first (and only) course from the result
        } else {
            // Redirect to the courses page if the course is not found
            header("Location: course.php");
            exit();
        }
    } else {
        // Redirect to the courses page if the course_id parameter is not set
        header("Location: course.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Update Course
    if (isset($_POST["update_course"])) {
        $newName = $_POST["new_name"];
        $newDescription = $_POST["new_description"];
        $idToUpdate = $_POST["course_id"];

        $sql = "UPDATE Course SET name='$newName', description='$newDescription' WHERE id=$idToUpdate";
        performQuery($sql);

        // Redirect to the courses page after updating
        header("Location: course.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
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
            width: 400px;
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
        <h2>Update Course</h2>
        <form method="POST" action="">
            <label for="new_name">New Course Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?= $course['name'] ?>" required>
            <label for="new_description">New Course Description:</label>
            <input type="text" id="new_description" name="new_description" value="<?= $course['description'] ?>" required>
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
            <button class="pushable" type="submit" name="update_course">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front">
                    Update Course
                </span>
            </button>
        </form>
    </div>
</body>
</html>
