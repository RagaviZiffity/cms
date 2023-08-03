<?php
$servername = "localhost"; 
$dbName = "root";
$dbPassword = "Admin@123";
$dbname = "userDetails";

$conn = new mysqli($servername, $dbName, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve values from the "pages" table
$sql = "SELECT * FROM pages";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $page_id = $row["page_id"];
        $content = $row["content"];
        $title= $row["title"];

        // Display the retrieved values
        echo "<h2>Page ID: $page_id</h2>";
        echo "<div>$content</div>";
        echo "<hr>";
    }
} else {
    echo "No pages found.";
}
?>
