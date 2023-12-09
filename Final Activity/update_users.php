<?php
include_once 'db.php';

// Fetch user data for update
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["username"])) {
    $usernameToUpdate = $_GET["username"];
    $sql = "SELECT username, password FROM Users WHERE username='$usernameToUpdate'";
    $userData = fetchData($sql);

    // Redirect if no user found
    if (empty($userData)) {
        header("Location: users.php");
        exit();
    }
}

// Update User
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_user"])) {
    $newUsername = $_POST["new_username"];
    $currentUsername = $_POST["current_username"];
    $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    $sql = "UPDATE Users SET username='$newUsername', password='$newPassword' WHERE username='$currentUsername'";
    performQuery($sql);

    // Redirect after update
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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

    <!-- HTML form for updating a user -->
    <form method="post">
        <h2>Update User</h2>
        <label for="current_username">Current Username:</label>
        <input type="text" name="current_username" required value="<?php echo $userData[0]['username']; ?>">
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button class="pushable" type="submit" name="update_user">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front">
                Update 
            </span>
        </button>
    </form>

</body>
</html>
