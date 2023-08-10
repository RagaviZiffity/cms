<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $space_id = $_GET['id'];

    $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $space_name = $row["spaceName"];
        $space_description = $row["DESCRIPTION"];

    } else {
        echo "Space not found.";
    }
} else {
    // echo "Invalid request.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Give_access'])) {
    $space_access = $_POST["space_access"];
    $space_id= $_POST['space_id'];

    $sql = "SELECT * FROM users WHERE username = '$space_access'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        $existing_space_access = $row['space_access'];

        // Append the new space_id to the existing space_access (if it's not already there)
        $updated_space_access = $existing_space_access;
        if (!empty($existing_space_access) && strpos($existing_space_access, $space_id) === false) {
            $updated_space_access .= "," . $space_id;
        } elseif (empty($existing_space_access)) {
            $updated_space_access = $space_id;
        }

        // Update the space_access value in the database for the specific user
        $sql = "UPDATE users SET space_access='$updated_space_access' WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
        $result = $conn->query($sql);
    
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $space_name = $row["spaceName"];
            $space_description = $row["DESCRIPTION"];
            echo "Access granted successfully!";
        }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
        $result = $conn->query($sql);
    
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $space_name = $row["spaceName"];
            $space_description = $row["DESCRIPTION"];
        echo "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Container */
.space-details-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 30px;
}

/* Access Form */
.access-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 30px;
}

.access-form label {
    font-size: 18px;
    margin-bottom: 10px;
    color: #555;
}

.access-form input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.access-form input[type="text"]:focus {
    border-color: #007bff;
}

.give-access-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.give-access-button:hover {
    background-color: #0056b3;
}

/* Space Details */
.space-details {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    flex-grow: 1;
}

.space-details h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #333;
}

.space-details h3 {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}


    </style>
</head>
<body>
<div class="space-details-container">
    <div class="access-form">
        <form action="Admin_space_details.php" method="post">
            <label>Access permission: </label>
            <input type="hidden" name="space_id" value="<?= $space_id; ?>">
            <input class="access-input" type="text" name="space_access">
            <br><br>
            <input class="give-access-button" type="submit" name="Give_access" value="Give access">
        </form>
    </div>
    <div class="space-details">
        <h2>Space Details</h2>
        <h3>Name: <?= $space_name; ?></h3>
        <h3>Description: <?= $space_description; ?></h3>
    </div>
</div>
</body>
</html>