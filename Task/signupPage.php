<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <link rel="stylesheet" href="signupPage.css">
</head>
<body>

<?php
include 'connection.php';
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Login"])) {
        // Login form submitted
        header("Location: LoginPage.php");
        exit;
    }
    $username = sanitize_input($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $newpassword = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);
    if ($_POST["password"] !== $_POST["newpassword"]) {
        echo "Error: Passwords do not match. Please re-enter the passwords.";}
    else{
    //inserting values into users tables
    $sql = "INSERT INTO users (username, password, new_password) VALUES ('$username', '$password', '$newpassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful. Welcome, " . $username . "!";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close(); 
    }
}
?>

<h2>Signup Form</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <br>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <br>
    <label for="newpassword">confirm password:</label>
    <input type="password" id="newpassword" name="newpassword" required>
    <br><br>
    <input type="submit" value="Sign Up"><br><br>
    
    
</form>
<form action="LoginPage.php">
<label>Already have account:</label>
    <input type="submit" value="Login" name="Login">
</form>
<form action="AdminLogin.php">
<label>Admin Login:</label>
    <input type="submit" value="Admin Login" name="AdminLogin">
</form>
</body>
</html>
