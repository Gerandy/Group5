<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C0C0C0;
        }
        .pos-container, .container-box {
            background: white;
    padding: 15px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    height: 850px; 
    display: flex;
    flex-direction: column;
    margin-bottom: 30px;
          
 }
        .separator-line {
        border-top: 3px solid #120C0C;
        margin: 10px 0;
        width: 100%;
    }
    .product-table {
     background: white;
    border-radius: 5px;
    padding: 10px;
    flex-grow: 1;
    height: 500px; 
    overflow-y: auto; 
    }
       
        .search-container {
           display: flex;
           justify-content: space-between; 
           width: 100%;
           margin-bottom: 10px;
           position: relative;
        }
        .searchbar {
            width: 100%;
            max-width: 250px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #ddd;
            outline: none;
            font-size: 16px;
            flex: 1; 
        }
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3572b0;
            font-size: 20px;
            cursor: pointer;
            margin-left:10px;
        }
        .addbutton {
            background-color: #D9D9D9;
            border-radius: 10px;
            border: none;
            padding: 5px 10px;
            width: 80px;;
        }
        .header {
            background-color: #2c6ea3;
            height: 50px;
        }

        .container-box {
    background-color: white;
    border-radius: 20px;
    padding: 20px;
    height: 80%;
    width: 430px;
    display: flex;
    flex-direction: column;
    overflow: hidden; 
    height:850px;
    margin-left:20px
    
}

.table-container {
    flex-grow: 1; 
    overflow-y: auto; 
    max-height: 650px; 
}
       

        @media (max-width: 992px) {
            .category-buttons button {
                width: 90px;
                height: 100px;
            }
        }

        
        .payment-summary {
    margin-top: auto; 
    
  
    text-align: left;
}

.buttontop {
    justify-content: space-between;
    border-radius:20px;
    width: 100%;
            max-width: 120px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #ddd;
            outline: none;
            
}

.table-striped tbody tr:nth-child(odd) {
       background-color:#757575; /* Black */
       color: white;
   }

   .table-striped tbody tr:nth-child(even) {
       background-color: #252323; /* Gray */
       color: white;
   }




    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #2c6ea3; height: 70px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" style="font-size: 2rem;" href="index.php">TechEase</a>
    <div class="ms-auto">
    
      <a href="addProducts.php" class="btn btn-light" style="font-weight: 500;">Add Product</a>
      <a href="index.php" class="btn btn-light" style="font-weight: 500;">Home</a>
    </div>
  </div>
</nav>
    <div class="container mt-4">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="pos-container">
                    <div class="search-container" style="display: flex; align-items: center;">
                        <a href="addProducts.php" class="buttontop btn btn-primary me-2">Add new</a>
                        <input type="text" class="searchbar" placeholder="Search product...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <hr class="separator-line">
                    <div class="product-table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Stock Left</th>
                                    <th>Price</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('db/database.php');
                                $query = "SELECT * FROM products";
                                $result = mysqli_query($connection, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                                        echo '<td><a href="edit_product.php?id=' . htmlspecialchars($row['id']) . '" class="addbutton btn btn-secondary btn-sm">Edit</a></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5">No products found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Simple search filter for the table
    document.querySelector('.searchbar').addEventListener('input', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('.product-table tbody tr').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
        });
    });
    </script>
</body>
</html>
