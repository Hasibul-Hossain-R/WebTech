<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cookie</title>
</head>
<body>
    <?php
        setcookie('sectione', '41', time() + 3600); // lasts for 1 hour
        echo "Cookie set: sectione = 41";
    ?>
</body>
</html>