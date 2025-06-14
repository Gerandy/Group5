<?php
include('db/database.php');
$voucher_id = intval($_GET['voucher_id']);
$product_id = intval($_GET['product_id']);
mysqli_query($connection, "INSERT IGNORE INTO voucher_products (voucher_id, product_id) VALUES ($voucher_id, $product_id)");
?>
<table class="table table-bordered" id="allProductsTable">