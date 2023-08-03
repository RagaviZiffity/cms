<?php
// include 'connection.php';
header("Access-Control-Allow-Origin: *");
print_r($_POST["toolbox"]);

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publish'])) {

//     $page_description = $_POST["toolbox"];
//     $publish = 1;

//     echo gettype($page_description);

//     $sql = "INSERT INTO `pages` ( `content`, `publish`) VALUES (?, ?)";
    
//     // echo $sql;
//     // Bind parppameters to the prepared statement
//     $stmt->bind_param("ss", $page_description, $publish);
//     if ($conn->query($sql) === TRUE) {
//       echo "Space created successfully!";
//   } else {
//       echo "Error: " . $sql . "<br>" . $conn->error;
//   }

// }


//require_once 'connection.php';
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
    $publish = 1;

    // Uncomment the following lines if you want to enable error reporting for debugging
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $sql = "INSERT INTO pages (`content`, `publish`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check if the prepared statement is valid
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    
    // Bind parameters to the prepared statement
    $stmt->bind_param("si", $page_description, $publish); // "si" indicates string and integer data types
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Space created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>