<?php
session_start();
require_once 'connection.php';
class UserPage
{
    private $conn;
    public function __construct($database)
    {
        $this->conn = $database->getConnection();
    }
    public function redirectToLoginPage()
    {
        if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
            header("Location: LoginPage.php");
            exit();
        }
    }
    public function getUser()
    {
        return $_SESSION["username"];
    }
    public function renderTopNav()
    {
        $user = $this->getUser();
        echo '<div class="topnav">
                <a class="active" href="#">' . "User: {$user}" . '</a>
            </div>';
    }
    public function renderFolderContainer()
    {
        $user = $this->getUser();
        $get_row = "SELECT * FROM users WHERE username= '$user'";
        $result1 = $this->conn->query($get_row);
        
        if ($result1->num_rows === 1) {
            $row = $result1->fetch_assoc();
            $user_id = $row['id'];
            $space_access = $row['space_access'];

            $space_access_array = explode(',', $space_access);
            $space_access_array = array_map('intval', $space_access_array);
        }
        $sql = "SELECT * FROM spaces";
        $result = $this->conn->query($sql);

        echo '<div class="folder-container">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $space_id = $row["spaceId"];
                $space_name = $row["spaceName"];
                if (in_array($space_id, $space_access_array)) {
                    echo '<div class="folder" onclick="window.location.href=\'user_space_details.php?id=' . $space_id . '\'">';
                    echo "<strong>{$space_name}</strong>" . '<br>';
                    echo '</div>';
                }
            }
        } else {
            echo "No spaces created yet.";
        }

        echo '</div>';
    }

}
$database = new DatabaseConnection();
$userPage = new UserPage($database);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="css/userPage.css">
    <script>
        function goLogout() {
            window.location.href = 'signupPage.php';
        }
    </script>
</head>
<body>
    <?php
    $userPage->redirectToLoginPage();
    $userPage->renderTopNav();
    ?>
    <div>
        <h1 style="text-align: center;">Available Spaces:</h1>
    </div>
    <?php 
    $userPage->renderFolderContainer();
    ?>
    <div class="log-div">
        <button id="Logout-btn" onclick="goLogout()">Logout</button>
    </div>
</body>
</html>