<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function goBack(spaceId) {
            window.location.href = 'user_space_details.php?id=' + spaceId;
        }
    </script>
</head>

<body>
    <?php
    header("Access-Control-Allow-Origin: *");
    print_r($_POST["toolbox"]);
    session_start();
    $servername = "localhost";
    $dbName = "root";
    $dbPassword = "Admin@123";
    $dbname = "userDetails";

    $page_id = $_POST['page_id'];



    $conn = new mysqli($servername, $dbName, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publish'])) {
        $page_description = $_POST["toolbox"];
        $title = $_POST["page_title"];

        $sql = "INSERT INTO subpages (`content`, `title`, `page_id`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error: " . $conn->error);
        }

        $stmt->bind_param("ssi", $page_description, $title, $page_id);

        if ($stmt->execute()) {
            echo " ";
        } else {
            echo "Error: " . $stmt->error;
        }

        $sql = "SELECT spaceId FROM pages WHERE page_id= $page_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $space_id = $row['spaceId'];
            }
        }
    }
    ?>
    <div>
        <button onclick="goBack(<?php echo $space_id; ?>)">Back</button>
    </div>
</body>

</html>