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
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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
        }
        .Exit-button a:hover {
            color: #dc3545;
        }
        .form-label {
            font-weight: 500;
            color: #2c6ea3;
            margin-bottom: 6px;
            margin-left: 2px;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid #b0b0b0;
            background-color: #f5f7fa;
            font-size: 1.1rem;
            padding: 12px;
            margin-bottom: 18px;
            transition: border-color 0.2s;
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
            font-family: inter;
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
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #2c6ea3; height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" style="font-size: 2rem;" href="index.php">TechEase</a>
    <div class="ms-auto">
      <a href="add_customer.php" class="btn btn-light me-2" style="font-weight: 500;">Add Customer</a>
      <a href="product.php" class="btn btn-light" style="font-weight: 500;">Product Page</a>
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
        <form method="POST" action="addProducts.php" autocomplete="off">
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
            <button type="submit" class="Confirm-button">Confirm</button>
        </form>
    </div>
</div>
</body>
</html>