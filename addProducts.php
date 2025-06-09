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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .header { background-color: #2c6ea3;
            height: 50px;
        }
        body {
            background-color: #C0C0C0;
            margin: 0;
            height: 81vh;
            display: grid;
        }
        .mt-4{
            display: flex;
            justify-content: center;
        }
        .tab-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 70%;
            text-align: center;
            font-weight: bold;

        }
        input {
            border-radius: 15px;
            border: none;
            background-color: #D9D9D9;
        }

        .Product-name  {
            margin-top: 10px;
        }
        .input-class {
            margin-top: 10px;
            margin-left: 60px;
        }

        .Exit-button {
            display:flex ;
            justify-content: right;
            cursor: pointer;
            padding-right: 20px;
            padding-top: 10px;
        }
        .Confirm-button {
            border-radius: 15px;
            border: none;
            background-color: #1C8D20;
            width: 40%;
            text-align: center;
            font-family: inter;
            cursor: pointer;
            font-weight: bold;
            padding: 5px;
            margin: auto;
            margin-top: 10%;
            display: block;
        }

    </style>
</head>
<body>
<?php if (!empty($message)) { ?>
    <script>
        alert("<?php echo addslashes($message); ?>");
    </script>
<?php } ?>
    <div class="header"></div>
        <div class="container mt-4">
            <div class="col-lg-4">
                <div class="tab-container">
                    <div class="Exit-button"><a href="product.php">X</a></div>
                    <form method="POST" action="addProducts.php">
                        <div class="Product-name">Product Name:
                            <input type="text" name="product_name" required>
                        </div>
                        <div class="input-class">Brand:
                            <input type="text" name="brand" required>
                        </div>
                        <div class="input-class">Stock:
                            <input type="number" name="stock_left" required>
                        </div>
                        <div class="input-class">Price:
                            <input type="number" name="price" required>
                        </div>
                        <button type="submit" class="Confirm-button">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    
</body>
</html>