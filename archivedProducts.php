<?php
include('db/database.php');

// Restore product from archive
if (isset($_GET['restore_id'])) {
    $restore_id = intval($_GET['restore_id']);
    mysqli_query($connection, "UPDATE products SET archived = 0 WHERE id = $restore_id");
    header("Location: archivedProducts.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Archived Products - TechEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #C0C0C0; min-height: 100vh; margin: 0; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .container.mt-4 { background: #fff; border-radius: 20px; box-shadow: 0 0 20px rgba(0,0,0,0.12); padding: 40px 35px 35px 35px; margin-top: 40px; }
        h3 { color: #2c6ea3; font-weight: bold; }
        .btn-primary, .btn-success { font-weight: 600; }
    </style>
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
<div class="container mt-4">
    <h3>Archived Products</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Stock Left</th>
                <th>Price</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $archived_query = "SELECT * FROM products WHERE archived = 1";
            $archived_result = mysqli_query($connection, $archived_query);
            if (mysqli_num_rows($archived_result) > 0) {
                while ($row = mysqli_fetch_assoc($archived_result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                    echo '<td>
                            <a href="archivedProducts.php?restore_id=' . htmlspecialchars($row['id']) . '" class="btn btn-success btn-sm" onclick="return confirm(\'Restore this product?\')">Restore</a>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No archived products</td></tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="product.php" class="btn btn-primary">Back to Products</a>
</div>
</body>
</html>