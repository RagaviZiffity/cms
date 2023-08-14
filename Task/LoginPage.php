<?php
session_start();
require_once 'connection.php';
class UserLogin
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database->getConnection();
    }

    public function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function handleLogin()
    {
        require_once 'connection.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->sanitizeInput($_POST["user"]);
            $password = $_POST["password"];

            $sql = "SELECT * FROM users WHERE BINARY username='$user'";
            $result = $this->conn->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row["password"];
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['is_user'] = true;
                    $_SESSION["username"] = $user;
                    header("Location: userPage.php");
                    exit();
                } else {
                    echo "Invalid password. Please try again.";
                }
            } else {
                echo "Invalid username. Please try again.";
            }
        }
    }
}
$database = new DatabaseConnection();
$userLogin = new UserLogin($database);
$userLogin->handleLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/LoginPage.css">
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