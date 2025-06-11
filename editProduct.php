<?php
include('db/database.php');
$product = [
    'product_name' => '',
    'brand' => '',
    'stock_left' => '',
    'price' => ''
];
$message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($connection, $_POST['product_name']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $stock = intval($_POST['stock_left']);
        $price = floatval($_POST['price']);
        $update = mysqli_query($connection, "UPDATE products SET product_name='$name', brand='$brand', stock_left=$stock, price=$price WHERE id=$id");
        if ($update) {
            $message = "Product updated successfully!";
            
            echo "<script>alert('Product updated successfully!');window.location.href='product.php';</script>";
            exit;
        } else {
            $message = "Failed to update product.";
        }
    }
   
    $result = mysqli_query($connection, "SELECT * FROM products WHERE id = $id");
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .header { 
        background-color: #2c6ea3;
        height: 50px;
    }
    body {
        background-color: #C0C0C0;
        margin: 0;
        min-height: 100vh;
        display: grid;
    }
    .mt-4 {
        display: flex;
        justify-content: center;
    }
    .tab-container {
        background: white;
        padding: 5% 8%;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        min-width: 300px;
        text-align: center;
        margin: 0 auto;
        position: relative;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 18px;
        width: 100%;
    }
    .form-label {
        margin-bottom: 4px;
        font-weight: 500;
    }
    input[type="text"], input[type="number"] {
        border-radius: 15px;
        border: none;
        background-color: #D9D9D9;
        padding: 8px 12px;
        width: 100%;
        margin-bottom: 0;
    }
    .Product-name, .input-class {
        margin-top: 18px;
        text-align: left;
        font-weight: 500;
    }
    .Exit-button {
        display: flex;
        justify-content: flex-end;
        cursor: pointer;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .Confirm-button {
        border-radius: 15px;
        border: none;
        background-color: #1C8D20;
        width: 60%;
        text-align: center;
        cursor: pointer;
        padding: 10px;
        margin: 25px auto 0 auto;
        display: block;
        color: #fff;
        font-weight: bold;
        font-size: 1.1rem;
        transition: background 0.2s;
    }
    .Confirm-button:hover {
        background-color: #157016;
    }
    .Confirm-button:disabled {
        background-color: #b0b0b0;
        color: #fff;
        cursor: not-allowed;
        opacity: 0.8;
    }
  </style>
</head>
<body>
<div class="header"></div>
<div class="container mt-4">
    <div class="col-lg-4">
        <div class="tab-container">
            <div class="Exit-button"><a href="product.php" style="text-decoration:none;color:black;">
                <a href="product.php" style="text-decoration:none;color:inherit;font-weight:bold;">&#10005;</a>
            </a></div>
            <?php if ($message) { ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php } ?>
            <form method="POST" action="editProduct.php<?php if (isset($_GET['id'])) { echo '?id=' . htmlspecialchars($_GET['id']); } ?>">
                <div class="form-group">
                    <label for="product_name" class="form-label">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="brand" class="form-label">Brand:</label>
                    <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="stock_left" class="form-label">Stock:</label>
                    <input type="number" id="stock_left" name="stock_left" value="<?php echo htmlspecialchars($product['stock_left']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                <button type="submit" class="Confirm-button" id="updateBtn" disabled>Update</button>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const updateBtn = document.getElementById('updateBtn');
    const initial = {
        product_name: form.product_name.value,
        brand: form.brand.value,
        stock_left: form.stock_left.value,
        price: form.price.value
    };

    form.addEventListener('input', function() {
        const changed =
            form.product_name.value !== initial.product_name ||
            form.brand.value !== initial.brand ||
            form.stock_left.value !== initial.stock_left ||
            form.price.value !== initial.price;
        updateBtn.disabled = !changed;
    });
});
</script>
</body>
</html>
