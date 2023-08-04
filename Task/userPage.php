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
        $user=$_SESSION["username"];
        $get_row= "SELECT * FROM users WHERE username= '$user'";
        $result1 = $conn->query($get_row);

        if ($result1->num_rows === 1){
            $row = $result1->fetch_assoc();
            $user_id = $row['id'];
            $space_access= $row['space_access'];

            $space_access_array = explode(',', $space_access);
            $space_access_array = array_map('intval', $space_access_array);
        }

        $sql = "SELECT * FROM spaces";
        $result = $conn->query($sql);
        echo "Welcome: {$user}";
        //convert string to array for space access
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_assoc()) {
                //if current space_id == user access space id
                $space_id = $row["spaceId"];
                $space_name = $row["spaceName"];
                if (in_array($space_id, $space_access_array)){
                echo '<div class="folder" onclick="window.location.href=\'user_space_details.php?id=' . $space_id . '\'">';
                echo "<strong>{$space_name}</strong>" . '<br>';
                echo '</div>';
                }
            }
        } else {
            echo "No spaces created yet.";
        }
        ?>
    </div>
</body>
</html>
