<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
  </style>
</head>

<?php
include('db/database.php');
$product = [
    'product_name' => '',
    'brand' => '',
    'stock_left' => '',
    'price' => ''
];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($connection, "SELECT * FROM products WHERE id = $id");
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
}
?>

<div class="header"></div>
<div class="container mt-4">
    <div class="col-lg-4">
        <div class="tab-container">
            <div class="Exit-button">
                <a href="product.php" style="text-decoration:none;color:inherit;font-weight:bold;">&#10005;</a>
            </div>
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
                <button type="submit" class="Confirm-button">Update</button>
            </form>
          </div>

</body>
</html>
