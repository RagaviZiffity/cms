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
// $comment = $_GET['comment'];
// echo $comment;

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $user = $_SESSION["username"];
//     $page_id = $_POST['page_id'];
//     $comment = $_POST['comment'];
//     if (isset($_POST['submit'])) {

//         $sql = "INSERT INTO comments (page_id, user_cmt, cmt) values ('$page_id', '$user', '$comment')";
//         $result = $conn->query($sql);
//     } else {
//         echo "Error: ";
//         exit;
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    
    <!-- <script>
        function getContent($page_id){
            $.ajax({
            url: 'comment_view.php?page_id='+$page_id,
            cache: false,
            type: 'GET',
            success:function(response){
            $("#result").html(response);}
            });
        }
    </script> -->
</head>

<body>
    <div>
        <?php

        if ($_SERVER["REQUEST_METHOD"] === "GET" ){
            $user = $_SESSION["username"];
            $page_id = $_GET['sub_page_id'];
            $space_id= $_GET['space_id'];
            $sub_id= $_GET['sub_id'];
            
            // $comment = $_GET['comment'];
            if(isset($_GET['space_id'])){
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
        }
         else {
            echo "Error:wqwq ";
            exit;
        }
    }

        // $get_row = "SELECT * FROM subpages where page_id='$page_id'";
        // $result1 = $conn->query($get_row);
        // $subpages = array();

        // if ($result1->num_rows > 0) {
        //     while ($row = $result1->fetch_assoc()) {
        //         $sub_page_id = $row["page_id"];
        //         $sub_title = $row["title"];
        //         $sub_id = $row['sub_id'];

        //         // Store the page details in the array
        //         $subpages[] = array("id" => $sub_id, "title" => $sub_title);
        //     }
        // }

        ?>

        <div>
            <!-- <h2><?= $page_title; ?></h2> -->
            <div><?= $content; ?></div>
        </div>

        <!-- <div>
            <form action="subpage_form.php" method="post">
                <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
                <input type="submit" name="subpages" value="Create sub-pages">
            </form>
        </div> -->
        <br><br><br><br><br>
        <div>
            <form method="post">
                <input type="hidden" id="hid-val1" name="page_id" value="<?php echo $page_id; ?>">
                <input type="hidden" id="hid-val2" name="page_id" value="<?php echo $space_id; ?>">
                <input type="hidden" id="hid-val3" name="page_id" value="<?php echo $sub_id; ?>">
                <input type="text" id="input-val" name="comment" required><br><br>

                <input type="button" id="btn-click" name="submit" value="Add Comment"><br><br>
                <!-- echo '<h2 class="page-link" onclick="getContent('.$space_id.",".$sub_page_id.",". $sub_id.')">' . $sub_title . '</h2>'; -->
                <!-- <button onclick="window.location.href='comment_view.php?page_id=<?php echo $page_id; ?>'">View comments</button> -->
                <!-- <button onclick="getContent(<?php echo $page_id; ?>)">View comments</button> -->
            </form>
        </div>
    </div>
    <!-- <div id="result"></div> -->
    <?php
    $sql = "SELECT * FROM comments where page_id='$page_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_cmt = $row['user_cmt'];
            $cmt = $row['cmt'];

            echo "<h3>$user_cmt : $cmt</h3><br/>";
            echo "<hr>";
        }
    }

    ?>
    <script>
    $(document).ready(function() {
        $("#btn-click").click(function() {
            var inputValue1 = $("#hid-val1").val();
            var inputValue2 = $("#input-val").val();
            var inputValue3 = $("#hid-val2").val();
            var inputValue4 = $("#hid-val3").val();
            $.ajax({  
                type:"POST",  
                url:"usercomment.php",  
                data: { page_id: inputValue1, comment: inputValue2 },
                success:function(response){
                    getContent1(inputValue3, inputValue1, inputValue4);
                }
            }); 
        });
    });
    </script>

</body>

</html>