<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}
$user=$_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Top Navigation Bar */
.topnav {
    background-color: #333;
    overflow: hidden;
}

.topnav a {
    float: right;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.topnav a.active {
    background-color: #007bff;
    color: white;
}

/* Folder Container */
.folder-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px;
}

.folder {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.folder:hover {
    background-color: #808080;
    transform: scale(1.05);
}

.folder strong {
    display: block;
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

    </style>
</head>
<body>
<div class="topnav">
  <a class="active" href="#"><?php echo "User: {$user}"; ?></a>
</div>
<div><h1 style="text-align: center;">Available Spaces:</h1></div>
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
