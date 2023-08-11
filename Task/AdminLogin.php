<?php

class AdminLogin {
    private $conn;

    public function __construct($database) {
        $this->conn = $database->getConnection();
    }

    public function handleAdminLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_POST['adminuser'];
            $password = $_POST['adminpassword'];
            if ($user === 'admin' && $password === 'Admin@123') {
                // $_SESSION['is_admin'] = true;
                header("Location: Admin.php");
                exit();
            }
        }
    }

    public function renderAdminLoginForm() {
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Admin Login</title>
                    <link rel="stylesheet" href="css/AdminLogin.css">
                </head>
                <body>
                    <div class="admin-login-container">
                        <h2 class="admin-login-title">Admin Login</h2>
                        <form class="admin-login-form" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                            <label class="admin-login-label">Username: </label>
                            <input class="admin-login-input" type="text" name="adminuser" required>
            
                            <label class="admin-login-label">Password:</label>
                            <input class="admin-login-input" type="password" name="adminpassword" required>
            
                            <input class="admin-login-button" type="submit" value="Admin Login">
                        </form>
                    </div>
                </body>
                </html>';
    }

    public function renderPage() {
        $this->handleAdminLogin();
        $this->renderAdminLoginForm();
    }
}

// Usage
require_once 'connection.php'; // Assuming you have the database connection class defined here
$database = new DatabaseConnection();
$adminLogin = new AdminLogin($database);

$adminLogin->renderPage();

?>
