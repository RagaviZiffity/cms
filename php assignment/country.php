<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="country.php" method="post">
        <input type="text" name="country">
        <input type="submit" >
    </form>
</body>
</html>
<?php
    setcookie("fav_food", "pizza", time() + (86400 * 2), "/");
    setcookie("fav_drink", "milkshake", time() + (86400 * 4), "/");
    setcookie("fav_fruit", "mango", time() + (86400 * 5), "/");
?>