<?php
session_start();
include 'connection.php';

$user= $_POST['adminuser'];
$password= $_POST['adminpassword'];

if ($user === 'admin' && $password === 'Admin@123') {
    // Admin login successful, set a session variable to mark as admin
    $_SESSION['is_admin'] = true;
    header("Location: Admin.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Admin Login Container */
.admin-login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
    margin: 0;
}

/* Admin Login Title */
.admin-login-title {
    font-size: 24px;
    margin-top: 20px;
    margin-bottom: 30px;
    color: #333;
    text-align: center;
}

/* Admin Login Form */
.admin-login-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 300px;
}

/* Form Elements */
.admin-login-label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #555;
}

.admin-login-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.admin-login-input:focus {
    border-color: #007bff;
}

.admin-login-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.admin-login-button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
<div class="admin-login-container">
    <h2 class="admin-login-title">Admin Login</h2>
    <form class="admin-login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label class="admin-login-label">Username: </label>
        <input class="admin-login-input" type="text" name="adminuser" required>
        
        <label class="admin-login-label">Password:</label>
        <input class="admin-login-input" type="password" name="adminpassword" required>
        
        <input class="admin-login-button" type="submit" value="Admin Login">
    </form>
</div>
</body>
</html>