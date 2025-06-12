<?php
include('db/database.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Check header layout
    $header = array_map('strtolower', array_map('trim', $rows[0]));
    $header = array_filter($header, function($v) { return $v !== ''; }); // Remove empty columns
    $header = array_values($header); // Re-index

    $expected = ['id', 'product name', 'brand', 'stock', 'price'];
    $expectedLower = $expected;

    if ($header !== $expectedLower) {
        $message = "<span style='color:red;'>Error: Excel layout is incorrect.<br>
        Detected header: " . implode(' | ', $header) . "<br>
        Expected: id | product name | brand | stock | price<br>
        Please use the template with columns in this exact order.</span>";
    } else {
        $errors = [];
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            // Check for missing cells
            if (count($row) < 5 || in_array('', array_slice($row, 0, 5), true)) {
                $errors[] = "Row " . ($i+1) . " has empty cell(s).";
                continue;
            }
            $id = trim($row[0]);
            $product_name = trim($row[1]);
            $brand = trim($row[2]);
            $stock = trim($row[3]);
            $price = trim($row[4]);

            // Validate id (must be a number and not blank)
            if ($id === '' || !is_numeric($id) || intval($id) < 1) {
                $errors[] = "Row " . ($i+1) . ": ID must be a positive number and not blank.";
                continue;
            }

            // Validate product_name (must not be blank or only spaces)
            if (trim($product_name) === '') {
                $errors[] = "Row " . ($i+1) . ": Product Name must not be blank.";
                continue;
            }
            // Validate brand (must not be blank or only spaces)
            if (trim($brand) === '') {
                $errors[] = "Row " . ($i+1) . ": Brand must not be blank.";
                continue;
            }
            // Validate stock and price (numeric)
            if (!is_numeric($stock) || $stock < 0) {
                $errors[] = "Row " . ($i+1) . ": Stock must be a number.";
                continue;
            }
            if (!is_numeric($price) || $price < 0) {
                $errors[] = "Row " . ($i+1) . ": Price must be a number.";
                continue;
            }

            // Check if product exists by id or name
            $id_sql = "id='" . mysqli_real_escape_string($connection, $id) . "'";
            $name_sql = "product_name='" . mysqli_real_escape_string($connection, $product_name) . "'";
            $check = mysqli_query($connection, "SELECT * FROM products WHERE $id_sql OR $name_sql LIMIT 1");
            if ($check && mysqli_num_rows($check) > 0) {
                // Update existing: add stock, update price, update brand and name
                $existing = mysqli_fetch_assoc($check);
                $new_stock = intval($existing['stock_left']) + intval($stock);
                $sql = "UPDATE products SET 
                            product_name='" . mysqli_real_escape_string($connection, $product_name) . "', 
                            brand='" . mysqli_real_escape_string($connection, $brand) . "', 
                            stock_left=$new_stock, 
                            price=" . floatval($price) . " 
                        WHERE $id_sql OR $name_sql";
            } else {
                // Insert new with provided id
                $sql = "INSERT INTO products (id, product_name, brand, stock_left, price) VALUES (" . intval($id) . ", '" . mysqli_real_escape_string($connection, $product_name) . "', '" . mysqli_real_escape_string($connection, $brand) . "', " . intval($stock) . ", " . floatval($price) . ")";
            }
            mysqli_query($connection, $sql);
        }
        if (count($errors) > 0) {
            $message = "<span style='color:red;'>Import failed:<br>" . implode('<br>', $errors) . "</span>";
        } else {
            $message = "<span style='color:green;'>Products imported/updated successfully!</span>";
        }
    }
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
<?php

?>
</body>
</html>