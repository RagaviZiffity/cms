<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $user = sanitize_input($_POST["user"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE BINARY username='$user' ";
    // $sql = "SELECT * FROM users WHERE username='$user' ";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        if (password_verify($password, $hashed_password)) 
        {
            // username in a session for authentication
            $_SESSION['is_user'] = true;
            $_SESSION["username"] = $user;
            header("Location: userPage.php");
            exit();
        } 
        else 
        {
            echo "Invalid password. Please try again.";
        }
    } 
    else {
        echo "Invalid username. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        }

        h2 {
        font-size: 24px;
        margin-top: 0;
        }

        form {
        width: 500px;
        margin: 0 auto;
        }

        label {
        font-size: 16px;
        margin-bottom: 10px;
        }

        input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        }

        input[type="submit"] {
        background-color: #000;
        color: #fff;
        cursor: pointer;
        }

        .login-form {
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 20px;
        }

    </style>
</head>
<body>
    <h2 style="text-align: center; margin-top: 100px;">Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Username: </label>
        <input type="text" name="user" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
