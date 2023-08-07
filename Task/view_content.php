<?php
session_start();
$servername = "localhost"; 
$dbName = "root";
$dbPassword = "Admin@123";
$dbname = "userDetails";

$conn = new mysqli($servername, $dbName, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}
$comment = $_GET['comment'];
echo $comment;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body {
  font-family: sans-serif;
  margin: 0;
  padding: 0;
}

h2 {
  font-size: 24px;
  margin-top: 0;
}

div {
  width: 500px;
  margin: 0 auto;
}

.page-link {
  cursor: pointer;
  text-decoration: none;
  color: #000;
  font-size: 16px;
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #fff;
}

.page-link:hover {
  background-color: #ccc;
}

form {
  margin-top: 20px;
}

input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
}


button {
    cursor: pointer;
  text-decoration: none;
  color: #000;
  padding: 10px 20px;
  border-radius: 5px;
  
  width: 100%;
  padding: 10px;
  border-radius: 5px;
}

button:hover {
  background-color: #cccccc;
}

    </style>
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user=$_SESSION["username"];
    $page_id = $_GET['id'];
    $comment= $_GET['comment'];

    $sql = "SELECT * FROM pages WHERE page_id='$page_id'";
    $result = $conn->query($sql);
   

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $page_title = $row["title"];
        $content = $row["content"];
    } else {
        echo "Page not found.";
        exit;
    }
} else {
    echo "Error: ";
    exit;
}

    $get_row = "SELECT * FROM subpages where page_id='$page_id'";
    $result1 = $conn->query($get_row);
    $subpages = array();

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $sub_page_id = $row["page_id"];
            $sub_title = $row["title"];
            $sub_id= $row['sub_id'];

            // Store the page details in the array
            $subpages[] = array("id" => $sub_id, "title" => $sub_title);
        }
    }

    ?>
    <div>
        <!-- <h2><?= $page_title; ?></h2> -->
        <div><?= $content; ?></div>
    </div>
   
    <?php
        if (!empty($subpages)) {
            foreach ($subpages as $page) {
                $sub_id = $page["id"];
                $sub_title = $page["title"];

                // Create a clickable link for each page title
                echo '<h2 class="page-link" onclick="window.location.href=\'view_subpage.php?sub_page_id=' . $sub_page_id . '&sub_id=' . $sub_id . '\'">' . $sub_title . '</h2>';
                echo "<hr>";
            }
        } else {
            echo "No pages found.";
        }
        ?>
        <div>
        <div>
        <form action="subpage_form.php" method="post">
            <input type="hidden" name="page_id" value="<?php echo $page_id;?>">
            <input type="submit" name="subpages" value="Create sub-pages">
        </form>
    </div><br><br><br><br><br>
        <form action="usercomment.php" method="post">
            <input type="hidden" name="page_id" value="<?php echo $page_id;?>">
            <input type="text" name="comment" required><br><br>
            <input type="submit" name="submit" value="Add Comment"><br><br>
            <button onclick="window.location.href='comment_view.php?page_id=<?php echo $page_id; ?>'">View comments</button>
        </form>
    </div>
</body>
</html>