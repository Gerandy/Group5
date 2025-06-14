<?php
include('db/database.php');
$voucher_id = intval($_GET['voucher_id']);
$result = mysqli_query($connection, "
    SELECT p.id, p.product_name, p.brand, p.price
    FROM products p
    JOIN voucher_products vp ON p.id = vp.product_id
    WHERE vp.voucher_id = $voucher_id
");
echo '<table class="table table-bordered"><thead><tr><th>ID</th><th>Product Name</th><th>Brand</th><th>Price</th></tr></thead><tbody>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
    echo '<td>' . htmlspecialchars($row['price']) . '</td>';
    echo '</tr>';
}
echo '</tbody></table>';
?>