<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
            text-align: center;
            height: 25vh;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .card-container {
            position: relative;
            margin-bottom: 40px;
        }

        .card {
            width: 90%; /* Adjusted to be almost as long as the container */
            max-width: 400px; /* Added max-width to limit width on larger screens */
            height: 1.5em; /* Set a fixed height */
            perspective: 1000px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .card-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.999s;
        }

        .card:hover .card-inner {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .card-front {
            background-color: #15598a;
            color: #fff;
            display: flex;
            align-items: center;
            border: 10px solid #15598a;
            border-radius: 10px;
            justify-content: center;
            font-size: 16px;
            transform: rotateY(0deg);
        }

        .card-back {
            background-color: #0e3a5e;
            color: #fff;
            display: flex;
            align-items: center;
            border: 10px solid #0e3a5e;
            border-radius: 10px;
            justify-content: center;
            font-size: 16px;
            transform: rotateY(180deg);
        }

        select {
            padding: 8px;
            font-size: 16px;
            margin-top: 30px; 
        }

        button {
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            background-color: #15598a;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0e3a5e;
        }

        .label {
        margin-top: 300px; 
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Information System</h1>
        
        <div class="card-container">
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <p>CIT17 Final Activity</p>
                    </div>
                    <div class="card-back">
                        <p>By: Jericho Tamondong</p>
                    </div>
                </div>
            </div>
        </div>

        <label for="method">Choose a method:</label>
        <select id="method">
            <option value="user">Manage Users</option>
            <option value="course">Manage Courses</option>
            <option value="student">Manage Students</option>
            <option value="instructor">Manage Instructors</option>
            
        </select>
        
        <button onclick="redirectToSelectedMethod()">Go</button>
    </div>

    <script>
        function redirectToSelectedMethod() {
            var selectedMethod = document.getElementById('method').value;
            if (selectedMethod === 'course') {
                window.location.href = 'course.php';
            } else if (selectedMethod === 'student') {
                window.location.href = 'student.php';
            } else if (selectedMethod === 'instructor') {
                window.location.href = 'instructor.php';
            } else if (selectedMethod === 'user') {
                window.location.href = 'users.php';
            }
        }
    </script>
</body>
</html>
