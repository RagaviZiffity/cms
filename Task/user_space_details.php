<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
    header("Location: LoginPage.php");
    exit();
}

$user= $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $space_id = $_GET['id'];

    // Retrieve space details from the database based on the space ID
    $sql = "SELECT * FROM spaces WHERE spaceId='$space_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $space_name = $row["spaceName"];
        $space_description = $row["DESCRIPTION"];

    } else {
        echo "Space not found.";
    }
    $sql = "SELECT * FROM pages where spaceId='$space_id'";
    $result = $conn->query($sql);

    
    $pages = array(); // Initialize an array to store all pages

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $page_id = $row["page_id"];
            $title = $row["title"];

            // Store the page details in the array
            $pages[] = array("id" => $page_id, "title" => $title);
        }
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
            text-align: left;
        }

        h3 {
            margin-bottom: 10px;
        }

        form {
            text-align: left;
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

        /* Style for the clickable page titles */
        .page-link {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }

        .page-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div>
        <div>
            <h2>Space Details</h2>
            <h3>Space name: <?= $space_name; ?></h3>
            <h3>Description: <?= $space_description; ?></h3>
        </div>
        <?php
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $page_id = $page["id"];
                $title = $page["title"];

                // Create a clickable link for each page title
                echo '<h2 class="page-link" onclick="window.location.href=\'view_content.php?space_id=' . $space_id . '&id=' . $page_id . '\'">' . $title . '</h2>';
                echo "<hr>";
            }
        } else {
            echo "No pages found.";
        }
        ?>
        <div>
        <form action="page_form.php" method="post">
            <input type="hidden" name="space_id" value="<?php echo $space_id; ?>">
            <input type="submit" value="Create page" name="page">       
        </form>
        </div>
    </div>
</body>
</html>
