<?php
require_once 'connection.php';

class AdminSpaceDetails {
    private $conn;
    private $space_id;
    private $space_name;
    private $space_description;

    public function __construct($database) {
        $this->conn = $database->getConnection();
    }

    public function handleAccessGrant() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Give_access'])) {
            $this->handleGiveAccess();
        }
    }

    private function handleGiveAccess() {
        $space_access = $_POST["space_access"];
        $space_id = $_POST['space_id'];
        $sql = "SELECT * FROM users WHERE username = '$space_access'";
        $result = $this->conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $existing_space_access = $row['space_access'];
            $updated_space_access = $existing_space_access;

            //check if the space_access is empty and already space_id is present in table
            if (!empty($existing_space_access) && strpos($existing_space_access, $space_id) === false) {
                $updated_space_access .= "," . $space_id;
            } elseif (empty($existing_space_access)) {
                $updated_space_access = $space_id;
            }

            $sql = "UPDATE users SET space_access='$updated_space_access' WHERE id='$user_id'";
            
            if ($this->conn->query($sql) === TRUE) {
                $this->fetchSpaceDetails($space_id);
                $this->fetchPageDetails($space_id);
                echo "Access granted successfully!";
            } else {
                echo "Error updating record: " . $this->conn->error;
            }
        }
    }

    public function fetchSpaceDetails($space_id) {
        $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $this->space_name = $row["spaceName"];
            $this->space_description = $row["DESCRIPTION"];
        }
    }

    public function fetchPageDetails($space_id){
        $sql = "SELECT * FROM pages WHERE spaceId = '$space_id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $page_id = $row['page_id'];
                $page_title = $row["title"];
                
                $subpage_sql = "SELECT * FROM subpages WHERE page_id = '$page_id'";
                $subpage_result = $this->conn->query($subpage_sql);

                if ($subpage_result->num_rows > 0) {
                    while ($subpage_row = $subpage_result->fetch_assoc()) {
                        $subpage_title = $subpage_row["title"];
                    }
                }
            }
        }
    }

    public function AccessForm() {
        echo '<div class="access-form">
                <form action="Admin_space_details.php" method="post">
                    <label>Select user: </label>
                    <input type="hidden" name="space_id" value="' . $this->space_id . '">
                    <select class="access-input" name="space_access">';
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row["username"];
                echo "<option value='$username'>$username</option>";
            }
        }
        
        echo '</select><br><br>
            <input class="give-access-button" type="submit" name="Give_access" value="Give access">
        </form>
    </div>';
    }

    public function SpaceDetails() {
        echo '<div class="space-details">
                <h2>Space Details</h2>
                <h3>Name: ' . $this->space_name . '</h3>
                <h3>Description: ' . $this->space_description . '</h3>';

        echo '<div class="pages-list">
                <h2>Pages in this Space</h2>';

        $sql = "SELECT * FROM pages WHERE spaceId = '$this->space_id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                $page_id = $row['page_id'];
                $page_title = $row["title"];

                // Add class for main pages
                echo "<li class='page-title'>$page_title"; 

                // Retrieve subpages for the page
                $subpage_sql = "SELECT * FROM subpages WHERE page_id = '$page_id'";
                $subpage_result = $this->conn->query($subpage_sql);

                if ($subpage_result->num_rows > 0) {
                     // Add class for subpages
                    echo "<ul class='subpages-list'>"; 
                   
                    while ($subpage_row = $subpage_result->fetch_assoc()) {
                        $subpage_title = $subpage_row["title"];
                         // Add class for subpage titles
                        echo "<li class='subpage-title'>$subpage_title</li>";  
                    }
                    echo "</ul>";
                }

                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No pages found for this space.";
        }

        echo '</div>'; 
        echo '</div>'; 
    }
    
    public function renderPage() {
        $this->space_id = $_GET['id'];
        $this->handleAccessGrant();
        $this->fetchSpaceDetails($this->space_id);
        $this->fetchPageDetails($this->space_id);

        $this->AccessForm();
        $this->SpaceDetails();
    }
}

$database = new DatabaseConnection();
$adminSpaceDetails = new AdminSpaceDetails($database);
$adminSpaceDetails->renderPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Details</title>
    <link rel="stylesheet" href="css/Admin_space_details.css">
    <script>
        function goBack() {
            window.location.href = 'Admin.php';
        }
    </script>
</head>
<body>
<div class="back-button">
    <button onclick="goBack()">Back</button>
</div>
</body>
</html>

