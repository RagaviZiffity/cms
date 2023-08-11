<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/page_form.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>
    <script src="page_form.js"></script>

</head>

<body>
    <?php
    $space_id = $_POST['space_id'];
    session_start();
    include 'connection.php';

    if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
        header("Location: LoginPage.php");
        exit();
    }

    $user = $_SESSION['username'];
    ?>
    <div class="topnav">
        <a class="active" href="#"><?php echo "User: {$user}"; ?></a>
    </div>
    <div>
        <form action="editor.php" method="post">
            <input type="hidden" name="space_id" value="<?= $space_id; ?>">
            <span style="margin-left: 34%; margin-top: 50px;">Title: </span> <input type="text" name="page_title" style="width: 500px; margin-top: 50px;"><br><br>
            <br><br>
            <textarea id="full-featured" name="toolbox"> </textarea><br><br>
            <input type="submit" name="publish" value="publish" style="width: 500px; margin-left: 38%;">
        </form>
    </div>

</body>

</html>