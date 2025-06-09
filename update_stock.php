<?php
include('db/database.php'); // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode(file_get_contents('php://input'), true);
    if (is_array($cart)) {
        foreach ($cart as $item) {
            // Make sure your cart items have 'id' and 'quantity'
            $id = intval($item['id']);
            $qty = intval($item['quantity']);
            $sql = "UPDATE products SET stock_left = GREATEST(stock_left - $qty, 0) WHERE id = $id";
            mysqli_query($connection, $sql);
        }
        echo 'success';
    }
}
?>