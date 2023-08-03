<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="text" name="getval"/>
        <input type="submit" name="subval" value="submit"/>
    </form>
</body>
</html>
<?php
    if(isset($_POST['subval']))
    {
        $input= filter_var($_POST['getval'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo $input;
    }
?>