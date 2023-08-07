<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="page_form.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script src="page_form.js"></script>
    <style>
        body {
            margin-top: 100px;
  font-family: sans-serif;
  margin: 0;
  padding: 0;
}

form {
  margin: 0 auto;
}

input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
}


.full-featured {
  resize: none;
}

.publish {
  background-color: #000;
  color: #fff;
  cursor: pointer;
  text-align: center;
}
    </style>
    
</head>
<body>
    <?php
    // space_id
    $space_id= $_POST['space_id'];
    echo $space_id;
    ?>
    
   <form action="editor.php" method="post">
   <input type="hidden" name="space_id" value="<?= $space_id; ?>">
   <span style="margin-left: 34%;">Title: </span> <input type="text" name="page_title" required>
    <textarea id="full-featured" name="toolbox"> </textarea>
    <input type="submit" name="publish" value="publish" style="width: 500px; margin-left: 38%;">
   </form> 
   
</body>
</html>

