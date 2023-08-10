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
        /* Login Container */
.login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
    margin: 0;
}

/* Login Title */
.login-title {
    font-size: 24px;
    margin-top: 20px;
    margin-bottom: 30px;
    color: #333;
    text-align: center;
}

/* Login Form */
.login-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 300px;
}

/* Form Elements */
.login-label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #555;
}

.login-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.login-input:focus {
    border-color: #007bff;
}

.login-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-button:hover {
    background-color: #0056b3;
}


    </style>
</head>
<body>
<div class="login-container">
    <h2 class="login-title">Login</h2>
    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label class="login-label" for="user">Username: </label>
        <input class="login-input" type="text" id="user" name="user" required>
        
        <label class="login-label" for="password">Password:</label>
        <input class="login-input" type="password" id="password" name="password" required>
        
        <input class="login-button" type="submit" value="Login">
    </form>
</div>


</body>
</html>
