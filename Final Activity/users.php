<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Create User
    if (isset($_POST["create_user"])) {
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
        performQuery($sql);
    }

    // Delete User
    if (isset($_POST["delete_user"])) {
        $usernameToDelete = $_POST["username_delete"];
        $sql = "DELETE FROM Users WHERE username='$usernameToDelete'";
        performQuery($sql);
    }
}

// Read Users
$sql = "SELECT username, password FROM Users";
$users = fetchData($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
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

        .shadow,
        .edge {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: 8px;
        }

        .shadow {
            background: hsl(226, 25%, 69%);
            filter: blur(2px);
            will-change: transform;
            transform: translateY(2px);
            transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
        }

        .edge {
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


        .update-button,
        .delete-button {
            cursor: pointer;
            padding: 8px 12px;
            background-color: #1a6ebd;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-right: 8px;
            transition: background-color 0.3s;
        }

        .update-button:hover,
        .delete-button:hover {
            background-color: #15598a;
        }

        .password-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

    </style>
</head>
<body>

    <div class="container">
        <!-- HTML form for creating a user -->
        <div class="form-container">
            <form method="POST" action="">
                <h2>Create User</h2>
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <button class="pushable" type="submit" name="create_user">
                    <span class="shadow"></span>
                    <span class="edge"></span>
                    <span class="front">
                        Add 
                    </span>
                </button>
            </form>
        </div>

        <!-- Display code for users -->
        <div class="form-container">
            <h2>Users</h2>
            <?php
            if (!empty($users)) {
                echo "<table>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>";
                foreach ($users as $user) {
                    echo "<tr>
                            <td>{$user['username']}</td>
                            <td>
                                <div class='password-cell'>{$user['password']}</div>
                            </td>
                            <td>
                                <button class='update-button' onclick=\"location.href='update_users.php?username={$user['username']}'\">Update</button>
                                <form style='display: inline;' method='POST' action=''>
                                    <input type='hidden' name='username_delete' value='{$user['username']}'>
                                    <button class='delete-button' type='submit' name='delete_user'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users found.</p>";
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
        function confirmDelete(username) {
            if (confirm('Are you sure you want to delete this user?')) {
                location.href = 'users.php?delete_user=1&username_delete=' + username;
            }
        }
    </script>

</body>
</html>
