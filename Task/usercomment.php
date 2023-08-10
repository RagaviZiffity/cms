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

echo "I am in";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user=$_SESSION["username"];
    $page_id= $_POST['page_id'];
    $comment= $_POST['comment'];

    $sql = "INSERT INTO comments (page_id, user_cmt, cmt) values ('$page_id', '$user', '$comment')";
    $result = $conn->query($sql);
} else {
    echo "Error: ";
    exit;
}

?>