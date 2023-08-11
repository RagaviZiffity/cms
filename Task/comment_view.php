<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $servername = "localhost";
    $dbName = "root";
    $dbPassword = "Admin@123";
    $dbname = "userDetails";

    $conn = new mysqli($servername, $dbName, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $page_id = $_GET['page_id'];

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
</body>

</html>