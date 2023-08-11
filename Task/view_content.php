<?php
session_start();
require_once 'connection.php'; // Assuming you have the database connection class defined here
$database = new DatabaseConnection();
$conn = $database->getConnection();
if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $user = $_SESSION["username"];
            $page_id = $_GET['sub_page_id'];
            $space_id = $_GET['space_id'];
            $sub_id = $_GET['sub_id'];

            if (isset($_GET['space_id'])) {
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
                echo "Error:wqwq ";
                exit;
            }
        }
        ?>
        <div>
            <h2><?= $page_title; ?></h2>
            <div><?= $content; ?></div>
        </div>
        <br><br><br><br><br>
        <div>
            <form method="post">
                <input type="hidden" id="hid-val1" name="page_id" value="<?php echo $page_id; ?>">
                <input type="hidden" id="hid-val2" name="page_id" value="<?php echo $space_id; ?>">
                <input type="hidden" id="hid-val3" name="page_id" value="<?php echo $sub_id; ?>">
                <input type="text" id="input-val" name="comment" required><br><br>

                <input type="button" id="btn-click" name="submit" value="Add Comment"><br><br>
            </form>
        </div>
    </div>
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
                    type: "POST",
                    url: "usercomment.php",
                    data: {
                        page_id: inputValue1,
                        comment: inputValue2
                    },
                    success: function(response) {
                        getContent1(inputValue3, inputValue1, inputValue4);
                    }
                });
            });
        });
    </script>
</body>

</html>