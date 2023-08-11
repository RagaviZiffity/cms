<?php
class UserSpaceDetailsPage {
    private $conn;
    private $user;
    private $space_id;
    private $space_name;
    private $space_description;
    private $pages = array();
    private $subpages = array();

    public function __construct($database) {
        $this->conn = $database->getConnection();
        $this->user = $_SESSION['username'];
        $this->fetchSpaceDetails();
    }

    private function redirectToLoginPage() {
        if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
            header("Location: LoginPage.php");
            exit();
        }
    }

    private function fetchSpaceDetails() {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $this->space_id = $_GET['id'];

            // Fetch space details
            $sql = "SELECT * FROM spaces WHERE spaceId='$this->space_id'";
            $result = $this->conn->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $this->space_name = $row["spaceName"];
                $this->space_description = $row["DESCRIPTION"];
            } else {
                echo "Space not found.";
            }

            // Fetch pages
            $sql = "SELECT * FROM pages where spaceId='$this->space_id'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $page_id = $row["page_id"];
                    $title = $row["title"];
                    $this->pages[] = array("id" => $page_id, "title" => $title);
                }
            }

            // Fetch subpages
            $sql = "SELECT * FROM subpages";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sub_page_id = $row["page_id"];
                    $sub_title = $row["title"];
                    $sub_id = $row['sub_id'];

                    $this->subpages[] = array("sub_id" => $sub_id, "sub_title" => $sub_title, "sub_page_id" => $sub_page_id);
                }
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function renderPage() {
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link rel="stylesheet" href="css/user_space_details.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                    <script src="user_space_details.js"></script>
                </head>
                <body>';
                
        $this->redirectToLoginPage();
        $this->renderTopnav();
        $this->renderTitle();
        $this->renderPagesAndSubpages();
        $this->renderLogoutButton();
        $this->renderResultContainer();
                
        echo '</body>
                </html>';
    }

    private function renderTopnav() {
        echo '<div class="topnav">
                <a class="active" href="#">' . "User: {$this->user}" . '</a>
            </div>';
    }

    private function renderTitle() {
        echo '<div class="title">
                <h3>Space name: ' . $this->space_name . '</h3>
                <h3>Description: ' . $this->space_description . '</h3>
                <form action="page_form.php" method="post">
                    <input type="hidden" name="space_id" value="' . $this->space_id . '">
                    <input type="submit" value="Create page" name="page">
                </form>
            </div>';
    }

    private function renderPagesAndSubpages() {
        echo '<div class="container" style="margin-top: 100px;">
                <div>';
        
        echo '<h1>Page list:</h1><br>';
        
        if (!empty($this->pages)) {
            foreach ($this->pages as $page) {
                $page_id = $page["id"];
                $title = $page["title"];

                echo '<div class="page-entry">';
                echo '<h2 class="page-link" onclick="getContent1(' . $this->space_id . "," . $page_id . "," . $page_id . ')">' . $title . '</h2>';
                echo '<button class="add-subpage-button" onclick="goToSubpageForm(' . $page_id . ')">+</button>';
                echo '</div>';

                foreach ($this->subpages as $subpage) {
                    $sub_id = $subpage["sub_id"];
                    $sub_title = $subpage["sub_title"];
                    $sub_page_id = $subpage["sub_page_id"];

                    if ($subpage["sub_page_id"] == $page_id) {
                        echo '<h2 class="subpage-link" onclick="getContent(' . $this->space_id . "," . $sub_page_id . "," . $sub_id . ')">' . $sub_title . '</h2>';
                    }
                }
            }
        } else {
            echo "No pages found.";
        }

        echo '</div></div>';
    }

    private function renderLogoutButton() {
        echo '<div class="log-div">
                <button id="Logout-btn" onclick="goBack()">Back</button>
            </div>';
    }

    private function renderResultContainer() {
        echo '<div id="result"></div>';
    }
}
?>
<?php
session_start();
include 'connection.php';
include 'UserSpaceDetailsPage.php';

$database = new DatabaseConnection();
$userSpaceDetails = new UserSpaceDetailsPage($database);
$userSpaceDetails->renderPage();
?>
