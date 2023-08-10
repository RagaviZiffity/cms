<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}

$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $space_id = $_GET['id'];

    // Retrieve space details from the database based on the space ID
    $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $space_name = $row["spaceName"];
        $space_description = $row["DESCRIPTION"];
    } else {
        echo "Space not found.";
    }

    $sql = "SELECT * FROM pages where spaceId='$space_id'";
    $result = $conn->query($sql);
    $pages = array();

    // Initialize an array to store all pages
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $page_id = $row["page_id"];
            $title = $row["title"];
            
            // Store the page details in the array
            $pages[] = array("id" => $page_id, "title" => $title);
        }
    }
} else {
    echo "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script>
    function loadPageContent(pageId) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("content-container").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "view_content.php?space_id=<?= $space_id ?>&id=" + pageId, true);
        xhr.send();
    }
</script>
<body>
<div class="topnav">
    <a class="active" href="#"><?php echo "User: {$user}"; ?></a>
    <a class="active" href="#"><?= $space_name; ?></a>
</div>
<div style="margin-top: 100px;">
    <div>
        <h2>Space Details</h2>
        <h3>Space name: <?= $space_name; ?></h3>
        <h3>Description: <?= $space_description; ?></h3>
    </div>
    <?php
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $page_id = $page["id"];
            $title = $page["title"];
            // Create a clickable link for each page title with a button
            echo '<div class="page-title-container">';
            echo '<h2 class="page-link" onclick="loadPageContent(' . $page_id . ')">' . $title . '</h2>';
            echo '</div>';
            echo "<hr>";
        }
    } else {
        echo "No pages found.";
    }
    ?>
    <div id="content-container" style="flex: 2; padding-left: 20px;">
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
            echo "No sub pages found.";
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
        </div>
</div>
</body>
</html>
