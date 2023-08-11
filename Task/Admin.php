<?php

class AdminPage {
    private $conn;

    public function __construct($database) {
        $this->conn = $database->getConnection();
    }

    // public function redirectToAdminLoginPage() {
    //     if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    //         header("Location: AdminLogin.php");
    //         exit();
    //     }
    // }

    public function handleSpaceCreation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_space'])) {
            function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $space_name = sanitize_input($_POST["space_name"]);
            $space_description = sanitize_input($_POST["space_description"]);

            $sql = "INSERT INTO spaces (spaceName, DESCRIPTION) VALUES ('$space_name', '$space_description')";
            if ($this->conn->query($sql) === TRUE) {
                echo "Space created successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }
    }

    public function renderSpacesList() {
        echo '<h2 style="text-align: center;">Spaces list:</h2>
                <div class="folder-container">';

        $sql = "SELECT * FROM spaces";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $space_id = $row["spaceId"];
                $space_name = $row["spaceName"];
                echo '<div class="folder" onclick="window.location.href=\'Admin_space_details.php?id=' . $space_id . '\'">';
                echo "<strong>{$space_name}</strong>" . '<br>';
                echo '</div>';
            }
        } else {
            echo "No spaces created yet.";
        }

        echo '</div><br><br>';
    }

    public function renderPage() {
        echo '<!DOCTYPE html>
                <html>
                <head>
                    <title>Admin Page</title>
                    <link rel="stylesheet" href="css/Admin.css">
                    <script>
                        function goLogout() {
                            window.location.href = \'signupPage.php\';
                        }
                    </script>
                </head>
                <body>';
        // $this->redirectToAdminLoginPage();
        echo '<div class="spaces-container">
                <h2 style="text-align: center;">Create Spaces</h2>
                <form class="create-spaces-form" action="Admin.php" method="post">
                    <label>Space Name: </label>
                    <input type="text" name="space_name" required>
                    <br><br>
                    <label>Space Description:</label>
                    <textarea name="space_description" rows="4" required></textarea>
                    <br><br>
                    <input class="create-spaces-button" type="submit" name="create_space" value="Create Space">
                </form>
                <br><br>';

        $this->handleSpaceCreation();
        $this->renderSpacesList();

        echo '<div>
                <button id="Logout-btn" onclick="goLogout()">Logout</button>
            </div>
        </div>
    </body>
    </html>';
    }
}

// Usage
require_once 'connection.php'; // Assuming you have the database connection class defined here
$database = new DatabaseConnection();
$adminPage = new AdminPage($database);

$adminPage->renderPage();

?>
