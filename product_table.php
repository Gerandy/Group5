<?php
include('db/database.php');
$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);
echo '<table class="table table-striped">';
echo '<tr>';
echo '<th> Product Name</th>';
echo '<th> Brand</th>';
echo '<th> Stock Left</th>';
echo '<th> Price</th>';
echo '<th> Option</th>';
echo '</tr>';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
        echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
        echo '<td><button class="addbutton" data-product-id="' . htmlspecialchars($row['id']) . '">Add Item</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No products found</td></tr>';
}
echo '</table>';

doc.save('receipt.pdf');

// Clear cart after printing and update UI
for (let key in cart) delete cart[key];
renderCart();

// Reload product table to reflect updated stock
reloadProductTable();
?>