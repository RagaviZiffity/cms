<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="page_form.css">
    <style>
      /* Top Navigation */
.topnav {
    background-color: #333;
    overflow: hidden;
}

.topnav a {
    background-color: #007bff;
    float: right;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 16px;
}

.topnav a:hover {
    background-color: #333;
    color: white;
}

/* Form Container */
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f7f7f7;
}

.form-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-container input[type="text"],
.form-container textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-container input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 50%;
    margin-left: auto;
    margin-right: auto;
}

.form-container input[type="submit"]:hover {
    background-color: #0056b3;
}

/* ... Your existing CSS ... */


    </style>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script src="page_form.js"></script>
</head>
<body>
    <?php
    $page_id= $_GET['page_id'];
    session_start();
    include 'connection.php';

    if (!isset($_SESSION['is_user']) || $_SESSION['is_user'] !== true) {
        header("Location: LoginPage.php");
        exit();
    }

    $user= $_SESSION['username'];
    ?>
    <div class="topnav">
            <a class="active" href="#"><?php echo "User: {$user}"; ?></a>
    </div>
    <div>
   <form action="subpage_editor.php" method="post">
   <input type="hidden" name="page_id" value="<?= $page_id; ?>">
    <span style="margin-left: 34%; margin-top: 50px;">Title: </span> <input type="text" name="page_title" style="width: 500px; margin-top: 50px;"><br><br>
    <textarea id="full-featured" name="toolbox"> </textarea><br><br>
    <input type="submit" name="publish" value="publish" style="width: 500px; margin-left: 38%;">
   </form> 
   </div>
   
</body>
</html>