<?php
session_start();
include 'connection.php';

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
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .folder-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
        }

        .folder {
            width: 200px;
            height: 150px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .folder:hover {
            background-color: #e0e0e0;
        }

        .folder strong {
            font-size: 18px;
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
<div class="folder-container">
        <?php
        // Retrieve and display all the spaces from the database
        $sql = "SELECT * FROM spaces";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $space_id = $row["spaceId"];
                $space_name = $row["spaceName"];
                echo '<div class="folder" onclick="window.location.href=\'user_space_details.php?id=' . $space_id . '\'">';
                echo "<strong>{$space_name}</strong>" . '<br>';
                echo '</div>';
            }
        } else {
            echo "No spaces created yet.";
        }
        ?>
    </div>
</body>
</html>
