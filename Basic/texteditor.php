<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="texteditor.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script src="texteditor.js"></script>
    
</head>
<body>
   <form action="editor.php" method="post">
    <textarea id="full-featured" name="toolbox"> </textarea>
    <input type="submit" name="publish" value="publish">
   </form> 
</body>
</html>