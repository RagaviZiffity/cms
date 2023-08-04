<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user=$_SESSION["username"];
    $page_id = $_GET['id'];
    $comment= $_GET['comment'];

    $sql = "SELECT * FROM pages WHERE page_id='$page_id'";
    $result = $conn->query($sql);
    $get_row = "INSERT INTO comments (page_id, user_cmt, comments) values ('$page_id', '$user', '$comment');";
    $result1 = $conn->query($get_row);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $content = $row["content"];
    } else {
        echo "Page not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>
<body>
    <div>
        <h2><?= $title; ?></h2>
        <div><?= $content; ?></div>
    </div>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <input type="text" name="comment">
        <input type="submit" name="submit" value="Add Comment">
        </form>
    </div>
</body>
</html>
