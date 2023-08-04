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
    
</head>
<body>
    <?php
    // space_id
    $space_id= $_POST['space_id'];
    echo $space_id;
    ?>
    
   <form action="editor.php" method="post">
   <input type="hidden" name="space_id" value="<?= $space_id; ?>">
    Title: <input type="text" name="page_title" required>
    <textarea id="full-featured" name="toolbox"> </textarea>
    <input type="submit" name="publish" value="publish">
   </form> 
   
</body>
</html>

