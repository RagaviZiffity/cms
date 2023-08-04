<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $space_id = $_GET['id'];

    // Retrieve space details from the database based on the space ID
    $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $space_name = $row["spaceName"];
        $space_description = $row["DESCRIPTION"];

        // Display space details
        // echo "<h2>Space Details</h2>";
        // echo "<strong>Space Name:</strong> " . $space_name . "<br>";
        // echo "<strong>Description:</strong> " . $space_description . "<br>";
    } else {
        echo "Space not found.";
    }
} else {
    echo "Invalid request.";
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

        div {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
        }

        h3 {
            margin-bottom: 10px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div>
        <div>
        <form action="user_action.php" method="post">
        <label>Access permission: </label>
        <input type="hidden" name="space_id" value="<?= $space_id; ?>">
        <input type="text" name="space_access">
        <br><br>
        <input type="submit" name="Give_access" value="Give access">
        </form>
        </div>
        <div>
        <h2>Space Details</h2>
        <h3>Name: <?= $space_name; ?></h3>
        <h3>Description: <?= $space_description; ?></h3>
        </div>
    </div>
</body>
</html>