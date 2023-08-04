<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: AdminLogin.php");
    exit();
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
            echo "Access granted successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "User not found.";
    }
}
?>
