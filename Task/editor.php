<?php
header("Access-Control-Allow-Origin: *");
print_r($_POST["toolbox"]);
session_start(); 
$servername = "localhost"; 
$dbName = "root";
$dbPassword = "Admin@123";
$dbname = "userDetails";

$conn = new mysqli($servername, $dbName, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publish'])) {
    $page_description = $_POST["toolbox"];
    $title = $_POST["page_title"];
    $space_id = $_POST["space_id"]; 
  
    $sql = "INSERT INTO pages (`content`, `title`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $page_description, $title);
    
    if ($stmt->execute()) {
        echo $space_id;
        echo "Space created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
