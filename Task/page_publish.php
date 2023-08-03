<?php
include 'connection.php';

    $title = $_POST['title'];

$targetDir = "uploads/";
$imageFile = $_FILES['image']['name'];
$imageTempFile = $_FILES['image']['tmp_name'];
$imageFilePath = $targetDir . basename($imageFile);

move_uploaded_file($imageTempFile, $imageFilePath);

$videoFile = $_FILES['video']['name'];
$videoTempFile = $_FILES['video']['tmp_name'];
$videoFilePath = $targetDir . basename($videoFile);
move_uploaded_file($videoTempFile, $videoFilePath);

// $servername = "localhost";
// $username = "root";
// $password = "ziffity@123";
// $dbname = 'local_test_db';

// Assuming you have the $title, $imageFilePath, and $videoFilePath variables containing the data

// Use prepared statement with parameter binding
$sql = "INSERT INTO `form_data` (`title`, `image`, `video`) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if the prepared statement is valid
if (!$stmt) {
    die("Error: " . $conn->error);
}

// Bind parameters to the prepared statement
$stmt->bind_param("sss", $title, $imageFilePath, $videoFilePath);


// Execute the prepared statement
if ($stmt->execute()) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>