<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constants</title>
</head>
<body>
    <?php
    define("MINSIZE", 5050);
    echo MINSIZE;
    echo "<br>";
    echo "Buhay q pag wala siya ay " . constant("MINSIZE"); // same thing as the previous line

    echo "<br>";
    define("Kapogian", 100);
    echo "Ang aking kapogian is equal to: " . Kapogian; 
    echo "<br>";
    echo "Ang aking kapogian is equal to: " . constant("Kapogian");

    echo "<br>";
    echo __FILE__;
    echo "<br>";
    echo "Sa line ". __LINE__ . " q triny yung line magic constant.";


    ?>
</body>
</html>