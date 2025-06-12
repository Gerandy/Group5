<?php 
include ('db/database.php'); 
session_start()
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
    $brand = mysqli_real_escape_string($connection, $_POST['brand']);
    $stock = mysqli_real_escape_string($connection, $_POST['stock_left']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);

    $insert_sql = "INSERT INTO products (product_name, brand, stock_left, price) VALUES ('$product_name', '$brand', '$stock', '$price')";
    if (mysqli_query($connection, $insert_sql)) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . mysqli_error($connection);
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - TechEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C0C0C0;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', Arial, Helvetica, sans-serif; /* Consistent font */
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .container.mt-4 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .tab-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.12);
            width: 480px;
            min-height: 520px;
            padding: 40px 35px 35px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: stretch;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .Exit-button {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .Exit-button a {
            color: #333;
            font-size: 1.5rem;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .Exit-button a:hover {
            color: #dc3545;
        }
        .form-label {
            font-weight: 500;
            color: #2c6ea3;
            margin-bottom: 6px;
            margin-left: 2px;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid #b0b0b0;
            background-color: #f5f7fa;
            font-size: 1.1rem;
            padding: 12px;
            margin-bottom: 18px;
            transition: border-color 0.2s;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .form-control:focus {
            border-color: #2c6ea3;
            box-shadow: 0 0 0 2px #2c6ea340;
        }
        .Confirm-button {
            border-radius: 15px;
            border: none;
            background-color: #1C8D20;
            width: 60%;
            text-align: center;
            font-family: 'Inter', Arial, Helvetica, sans-serif; /* Consistent font */
            cursor: pointer;
            font-weight: bold;
            padding: 12px;
            margin: 30px auto 0 auto;
            color: #fff;
            font-size: 1.15rem;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(28,141,32,0.08);
        }
        .Confirm-button:hover {
            background-color: #157016;
        }
        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #2c6ea3;
            margin-bottom: 25px;
            letter-spacing: 1px;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
    </style>
    <!-- Add Inter font from Google Fonts for consistency -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%); height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="font-size: 2rem; color: #fff;" href="index.php">
      <img src="assets/teacheaseshoplogo.png" alt="Logo" style="height:36px;margin-right:10px;">TechEase
    </a>
    <div class="ms-auto">
      <a href="product.php" class="btn btn-outline-light rounded-pill px-4 py-2 d-flex align-items-center"
         style="font-weight:600; font-size:1.1rem; box-shadow:0 2px 8px rgba(0,0,0,0.08); min-width:140px;">
        <span class="me-2" style="font-size:1.3rem;">&#8592;</span> Back
      </a>
    </div>
  </div>
</nav>
<?php if (!empty($message)) { ?>
    <script>
        alert("<?php echo addslashes($message); ?>");
    </script>
<?php } ?>
<div class="container mt-4">
    <div class="tab-container">
        <div class="Exit-button"><a href="product.php" title="Back to Product List">&times;</a></div>
        <div class="form-title">Add New Product</div>
        <form method="POST" action="addProducts.php" autocomplete="off" novalidate>
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="mb-3">
                <label for="stock_left" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock_left" name="stock_left" min="0" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
            </div>
            <center><button type="submit" class="Confirm-button">Confirm</button></center>
        </form>
        <div class="text-center mt-3">
            <a href="importProducts.php" class="btn btn-outline-primary">
                📥 Import Products from Excel
            </a>
            <br>
            <small class="text-muted">Download a <a href="sample_import.xlsx" target="_blank">sample Excel template</a></small>
        </div>
    </div>
</div>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const missing = [];
    if (!document.getElementById('product_name').value.trim()) missing.push('Product Name');
    if (!document.getElementById('brand').value.trim()) missing.push('Brand');
    if (!document.getElementById('stock_left').value.trim()) missing.push('Stock');
    if (!document.getElementById('price').value.trim()) missing.push('Price');
    if (missing.length > 0) {
        e.preventDefault();
        alert('Please fill out the following required field(s):\n- ' + missing.join('\n- '));
    }
});
</script>
</body>
</html>