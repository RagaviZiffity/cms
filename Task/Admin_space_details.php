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
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Give_access'])) {
    $space_access = $_POST["space_access"];
    $space_id = $_POST['space_id'];

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
    <script>
        function goBack() {
            window.location.href = 'Admin.php';
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        /* Container */
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px;
        }

        /* Access Form */
        .access-form,
        .space-details {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px;
            background-color: white;
        }

        .access-form {
            background-color: #f9f9f9;
        }

        .access-form label {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }

        .access-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
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
        .space-details h2,
        .space-details h3 {
            margin: 0;
            color: #333;
        }

        .space-details h2 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .space-details h3 {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        /* Pages List */
        .pages-list ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .pages-list ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .pages-list li {
            margin: 10px 0;
            font-weight: bold;
        }

        /* Subpages List */
        .subpages-list ul {
            list-style-type: none;
            margin: 5px 0 0 20px;
            padding: 0;
        }

        .subpages-list li {
            margin: 3px 0;
            font-size: 14px;
            color: #888;
            font-weight: normal;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .back-button button {
            background-color: #555;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button button:hover {
            background-color: #333;
        }

        .page-title {
            font-weight: bold;
        }

        .subpage-title {
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="space-details-container">
        <!-- <div class="access-form">
        <form action="Admin_space_details.php" method="post">
            <label>Access permission: </label>
            <input type="hidden" name="space_id" value="<?= $space_id; ?>">
            <input class="access-input" type="text" name="space_access">
            <br><br>
            <input class="give-access-button" type="submit" name="Give_access" value="Give access">
        </form>
    </div> -->
        <div class="access-form">
            <form action="Admin_space_details.php" method="post">
                <label>Select user: </label>
                <input type="hidden" name="space_id" value="<?= $space_id; ?>">
                <select class="access-input" name="space_access">
                    <?php
                    // Retrieve users from the database and populate the dropdown
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $username = $row["username"];
                            echo "<option value='$username'>$username</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>
                <input class="give-access-button" type="submit" name="Give_access" value="Give access">
            </form>
        </div>
        <div class="space-details">
            <h2>Space Details</h2>
            <h3>Name: <?= $space_name; ?></h3>
            <h3>Description: <?= $space_description; ?></h3>

            <br><br><br>
            <div class="pages-list">
            <h2>Pages in this Space</h2>
            <?php
            $sql = "SELECT * FROM pages WHERE spaceId = '$space_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    $page_id = $row['page_id'];
                    $page_title = $row["title"];

                    echo "<li class='page-title'>$page_title"; // Add class for main pages

                    // Retrieve subpages for the current main page
                    $subpage_sql = "SELECT * FROM subpages WHERE page_id = '$page_id'";
                    $subpage_result = $conn->query($subpage_sql);

                    if ($subpage_result->num_rows > 0) {
                        echo "<ul class='subpages-list'>"; // Add class for subpages
                        while ($subpage_row = $subpage_result->fetch_assoc()) {
                            $subpage_title = $subpage_row["title"];
                            echo "<li class='subpage-title'>$subpage_title</li>"; // Add class for subpage titles
                        }
                        echo "</ul>";
                    }

                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "No pages found for this space.";
            }
            ?>
        </div>
        </div>
    </div>
    <div class="back-button">
        <button onclick="goBack()">Back</button>
    </div>
</body>

</html>