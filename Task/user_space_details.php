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

    } else {
        echo "Space not found.";
    }
    $sql = "SELECT * FROM pages";
    $result = $conn->query($sql);

    
    $pages = array(); // Initialize an array to store all pages

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $page_id = $row["page_id"];
            $content = $row["content"];
            $title = $row["title"];

            // Store the page details in the array
            $pages[] = array("id" => $page_id, "title" => $title, "content" => $content);
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
        <h2>Space Details</h2>
        <h3>Space name: <?= $space_name; ?></h3>
        <h3>Description: <?= $space_description; ?></h3>
        </div>
        <?php
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $page_id = $page["id"];
                $title = $page["title"];
                $content = $page["content"];

                // Display each page as a separate tag
                echo "<h2>$title</h2>";
                echo "<div>$content</div>";
                echo "<hr>";
            }
        } else {
            echo "No pages found.";
        }
        ?>
        <div>
        <form action="page_form.php" method="post">
            <input type="submit" value="Create page" name="page">       
        </form>
        </div>
    </div>
</body>
</html>