<?php
include('db/database.php');
require 'vendor/autoload.php'; // Make sure you have PhpSpreadsheet installed via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Skip header row, start from 2nd row
    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];
        // [0] = id (optional), [1] = product name, [2] = brand, [3] = stock, [4] = price
        $product_name = mysqli_real_escape_string($connection, $row[1]);
        $brand = mysqli_real_escape_string($connection, $row[2]);
        $stock = intval($row[3]);
        $price = floatval($row[4]);
        if ($product_name && $brand && $stock >= 0 && $price >= 0) {
            $sql = "INSERT INTO products (product_name, brand, stock_left, price) VALUES ('$product_name', '$brand', $stock, $price)";
            mysqli_query($connection, $sql);
        }
    }
    $message = "Products imported successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Import Products - TechEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0fa;
            min-height: 100vh;
        }
        .import-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.12);
            width: 480px;
            margin: 60px auto 0 auto;
            padding: 40px 35px 35px 35px;
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
      <a href="addProducts.php" class="btn btn-light me-2" style="font-weight: 500;">Add Product</a>
      <a href="product.php" class="btn btn-light" style="font-weight: 500;">Product Page</a>
    </div>
  </div>
</nav>
<div class="import-container">
    <div class="form-title">Import Products (Excel)</div>
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="excel_file" class="form-label">Select Excel File (.xlsx):</label>
            <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Import</button>
    </form>
    <div class="mt-4">
        <strong>Excel Format:</strong>
        <div>
            <small>
                <b>id</b> | <b>product name</b> | <b>Brand</b> | <b>Stock</b> | <b>Price</b><br>
                (id can be blank or ignored)
            </small>
        </div>
        <div class="mt-2">
            <a href="sample_import.xlsx" class="btn btn-link">Download Sample Excel</a>
        </div>
    </div>
</div>
</body>
</html>