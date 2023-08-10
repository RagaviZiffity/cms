<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}

$user= $_SESSION['username'];

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

    
    $pages = array(); // Initialize an array to store all pages

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $page_id = $row["page_id"];
            // echo "<br>" . $page_id;
            $title = $row["title"];

            // Store the page details in the array
            $pages[] = array("id" => $page_id, "title" => $title);
        }
    }

    $sql = "SELECT * FROM subpages";
    $result = $conn->query($sql);

    $subpages = array(); // Initialize an array to store all pages

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sub_page_id = $row["page_id"];
            // echo "<br>" . $sub_page_id;
            $sub_title = $row["title"];
            $sub_id= $row['sub_id'];

            // Store the page details in the array
            $subpages[] = array("sub_id" => $sub_id, "sub_title" => $sub_title, "sub_page_id" => $sub_page_id);
        }
    }
    // echo $page_id;
    // echo $sub_page_id;
    // echo $sub_title;
    // echo $sub_id;
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
    <link rel="stylesheet" href="user_space_details.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
    function getContent(space_id, sub_page_id, sub_id){
    $.ajax({
    url: 'view_subpage.php?space_id='+space_id+'&sub_page_id='+sub_page_id+'&sub_id='+sub_id,
    cache: false,
    type: 'GET',
    success:function(response){
    $("#result").html(response);}
    });
    }

    function getContent1(space_id, sub_page_id, sub_id){
    $.ajax({
    url: 'view_content.php?space_id='+space_id+'&sub_page_id='+sub_page_id+'&sub_id='+sub_id,
    cache: false,
    type: 'GET',
    success:function(response){
    $("#result").html(response);
    // alert("Content loaded successfully!");
    }
    });
    }

    function goToSubpageForm(pageId) {
        window.location.href = 'subpage_form.php?page_id=' + pageId;
    }
    </script>
</head>
<body>
        <div class="topnav">
            <a class="active" href="#"><?php echo "User: {$user}"; ?></a>
        </div>
        <div class="title">
            <h3>Space name: <?= $space_name; ?></h3>
            <h3>Description: <?= $space_description; ?></h3>
        <form action="page_form.php" method="post">
            <input type="hidden" name="space_id" value="<?php echo $space_id; ?>">
            <input type="submit" value="Create page" name="page">   
        </form>
        </div>
    <div class="container" style="margin-top: 100px;">
        <div>
        <?php
        // if (!empty($pages)) {
        //     foreach ($pages as $page) {
        //         $page_id = $page["id"];
        //         $title = $page["title"];

        //         // Create a clickable link for each page title
        //         echo '<h2 class="page-link" onclick="window.location.href=\'view_content.php?space_id=' . $space_id . '&id=' . $page_id . '\'">' . $title . '</h2>';
        //     }
        // } else {
        //     echo "No pages found.";
        // }

        echo '<h1>Page list:</h1><br>';
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $page_id = $page["id"];
                $title = $page["title"];

                // echo '<h2 class="page-link" onclick="window.location.href=\'view_content.php?space_id=' . $space_id . '&id=' . $page_id . '\'">' . $title . '</h2>';

                // echo '<h2 class="page-link" onclick="getContent1('.$space_id.",".$page_id.",". $sub_id.')">' . $title . '</h2>';

                echo '<div class="page-entry">';
                echo '<h2 class="page-link" onclick="getContent1('.$space_id.",".$page_id.",". $sub_id.')">' . $title . '</h2>';
                echo '<button class="add-subpage-button" onclick="goToSubpageForm('.$page_id.')">+</button>';
                echo '</div>';

                foreach($subpages as $subpage)
                {
                    
                    $sub_id= $subpage["sub_id"];
                    $sub_title= $subpage["sub_title"];
                    $sub_page_id= $subpage["sub_page_id"];

                    // echo $subpage["sub_page_id"];
                    // echo "<br>" . $page_id;
        
                    if ($subpage["sub_page_id"] == $page_id) {
                        $sub_id = $subpage["sub_id"];
                        $sub_title = $subpage["sub_title"];
    
                        // echo '<li class="page-link" onclick="window.location.href=\'view_subpage.php?sub_page_id=' . $sub_page_id . '&sub_id=' . $sub_id . '\'">' . $sub_title . '</li>';

                        echo '<h2 class="subpage-link" onclick="getContent('.$space_id.",".$sub_page_id.",". $sub_id.')">' . $sub_title . '</h2>';
                    }
                }
            }
        } else {
            echo "No pages found.";
        }
        ?>
        </div>
    </div>
    <div id="result">

    </div>
</body>
</html>