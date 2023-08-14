<?php
require_once 'connection.php';
class SignupPage
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

    public function handleSignup()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["Login"])) {
                header("Location: LoginPage.php");
                exit;
            }
            $username = $this->sanitizeInput($_POST["username"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $newpassword = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);

            if ($_POST["password"] !== $_POST["newpassword"]) {
                echo "Error: Passwords do not match. Please re-enter the passwords.";
            } else {
                $sql = "INSERT INTO users (username, password, new_password) VALUES ('$username', '$password', '$newpassword')";

                if ($this->conn->query($sql) === TRUE) {
                    $this->conn->close();
                    header("Location: LoginPage.php");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $this->conn->error;
                }

                $this->conn->close();
            }
        }
    }
}
$database = new DatabaseConnection();
$signupPage = new SignupPage($database);

$signupPage->handleSignup();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup Page</title>
    <link rel="stylesheet" href="css/signupPage.css">
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Signup Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="form-label" for="username">Username:</label>
            <input class="form-input" type="text" id="username" name="username" required>

            <label class="form-label" for="password">Password:</label>
            <input class="form-input" type="password" id="password" name="password" required>

            <label class="form-label" for="newpassword">Confirm Password:</label>
            <input class="form-input" type="password" id="newpassword" name="newpassword" required>

            <div class="form-buttons">
                <input class="form-button" type="submit" value="Sign Up">
                <a class="login-link" href="LoginPage.php">Already have an account? Login</a>
            </div>
        </form>
        <form action="AdminLogin.php">
            <label class="form-label">Admin Login:</label>
            <input class="form-button" type="submit" value="Admin Login" name="AdminLogin">
        </form>
    </div>
</body>

</html>