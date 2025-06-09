<?php 
include 'database.php';

$_SESSION['test'] = "Hello World";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


    <?php
    $query = "SELECT * FROM products";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
       while ($row = mysqli_fetch_assoc($result)){;
        echo $row['product_name']."<br>";
        echo $row['brand']."<br>";
        echo $row['price']."<br>";
        }

    }
        
    

    ?>


</body>
</html>