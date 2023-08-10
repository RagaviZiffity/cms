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
    <script>
        function goLogout() {
            window.location.href = 'signupPage.php';
        }
    </script>
    <style>
        /* Container for Create Spaces and Spaces List */
.spaces-container {
    text-align: center;
    padding: 30px;
}

/* Create Spaces Form */
.create-spaces-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.create-spaces-form label {
    font-size: 18px;
    margin-bottom: 10px;
    color: #555;
}

.create-spaces-form input[type="text"],
.create-spaces-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.create-spaces-form input[type="text"]:focus,
.create-spaces-form textarea:focus {
    border-color: #007bff;
}

.create-spaces-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.create-spaces-button:hover {
    background-color: #0056b3;
}

/* Spaces List */
.folder-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
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

#Logout-btn{
    background-color: #555;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    color: #fff;
}


    </style>
</head>
<body>
<div class="spaces-container">
    <h2 style="text-align: center;">Create Spaces</h2>
    <form class="create-spaces-form" action="Admin.php" method="post">
        <label>Space Name: </label>
        <input type="text" name="space_name" required>
        <br><br>
        <label>Space Description:</label>
        <textarea name="space_description" rows="4" required></textarea>
        <br><br>
        <input class="create-spaces-button" type="submit" name="create_space" value="Create Space">
    </form>
    <br><br>
    <h2 style="text-align: center;">Spaces list:</h2>
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
    </div><br><br>
    <div>
        <button id="Logout-btn" onclick="goLogout()">Logout</button>
    </div>
</body>
</html>