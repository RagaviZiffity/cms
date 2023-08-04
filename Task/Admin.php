<?php
session_start();
include 'connection.php';

// Check if the user is an admin, if not, redirect them to the login page
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: AdminLogin.php");
    exit();
}

// Process the form data to create spaces if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_space'])) {
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Retrieve and sanitize the space details from the form
    $space_name = sanitize_input($_POST["space_name"]);
    $space_description = sanitize_input($_POST["space_description"]);

    // Insert the space details into the database
    $sql = "INSERT INTO spaces (spaceName, DESCRIPTION) VALUES ('$space_name', '$space_description')";
    if ($conn->query($sql) === TRUE) {
        echo "Space created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 50px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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
    <h2>Admin Page - Create Spaces</h2>
    <form action="Admin.php" method="post">
        <label>Space Name: </label>
        <input type="text" name="space_name" required>
        <br>
        <label>Space Description:</label>
        <textarea name="space_description" rows="4" required></textarea>
        <br>
        <input type="submit" name="create_space" value="Create Space">
    </form>

    <h2>Created Spaces:</h2>
    <?php
    ?>
    <div class="folder-container">
        <?php
        $sql = "SELECT * FROM spaces";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $space_id = $row["spaceId"];
                $space_name = $row["spaceName"];
                echo '<div class="folder" onclick="window.location.href=\'Admin_space_details.php?id=' . $space_id . '\'">';
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