<?php
include('db/database.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM products WHERE id = $id";
    mysqli_query($connection, $query);
}

header('Location: product.php');
exit;
?>