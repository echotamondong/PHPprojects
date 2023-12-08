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

    // Read Users
    if (isset($_POST["read_users"])) {
        $sql = "SELECT id, username FROM Users";
        $users = fetchData($sql);
    }

// Update User
if (isset($_POST["update_user"])) {
    $newUsername = $_POST["new_username"];
    $currentUsername = $_POST["current_username"];
    $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    $sql = "UPDATE Users SET username='$newUsername', password='$newPassword' WHERE username='$currentUsername'";
    performQuery($sql);
}


    // Delete User
if (isset($_POST["delete_user"])) {
    $usernameToDelete = $_POST["username_delete"];
    $sql = "DELETE FROM Users WHERE username='$usernameToDelete'";
    performQuery($sql);
}

}
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

    <!-- HTML form for creating a user -->
    <form method="post">
        <h2>Create User</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit" name="create_user">Create User</button>
    </form>

    <!-- HTML form for reading users -->
    <form method="post">
        <h2>Read Users</h2>
        <button type="submit" name="read_users">Read Users</button>
    </form>

    <!-- Display code for users -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["read_users"])) {
        $sql = "SELECT username, password FROM Users";
        $users = fetchData($sql);
        if (!empty($users)) {
            echo "<table>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>";
            foreach ($users as $user) {
                echo "<tr>
                        <td>{$user['username']}</td>
                        <td>{$user['password']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
    }
    ?>

    <!-- HTML form for updating a user -->
    <form method="post">
        <h2>Update User</h2>
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" required>
        <label for="current_username">Current Username:</label>
        <input type="text" name="current_username" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit" name="update_user">Update User</button>
    </form>


    <!-- HTML form for deleting a user -->
    <form method="post">
        <h2>Delete User</h2>
        <label for="username_delete">Username to Delete:</label>
        <input type="text" name="username_delete" required>
        <button type="submit" name="delete_user">Delete User</button>
    </form>


</body>
</html>

