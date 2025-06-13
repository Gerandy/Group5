<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%); height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="font-size: 2rem; color: #fff;" href="index.php">
      <img src="assets/teacheaseshoplogo.png" alt="Logo" style="height:36px;margin-right:10px;">TechEase
    </a>
    <div class="dropdown ms-auto">
      <button class="btn btn-outline-light rounded-pill px-4 py-2 d-flex align-items-center" type="button" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight:600; font-size:1.1rem; box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <span class="me-2"><img src="assets/menulogo.png" style="filter:invert(1);height:22px;"></span> Menu
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 animate__animated animate__fadeInDown" aria-labelledby="menuDropdown" style="min-width:220px;">
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="addProducts.php"><img src="assets/cartlogo.png" class="me-2">Add Product</a></li>
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="addBrands.php"><img src="assets/registerlogo.png" class="me-2">Register Brand</a></li>
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="addVouchers.php"><img src="assets/voucherlogo.png" class="me-2">Voucher Management</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="index.php"><img src="https://img.icons8.com/ios-filled/20/2c6ea3/home.png" class="me-2">Home</a></li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container mt-4">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="pos-container">
                    <div class="search-container" style="display: flex; align-items: center; justify-content: flex-start;">
                        <input type="text" class="searchbar" placeholder="Search product...">
                    </div>
                    <hr class="separator-line">
                    <div class="product-table">
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
                                include('db/database.php');

// Pagination setup
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Get products for current page
$query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);

// Get total number of products for pagination
$total_query = "SELECT COUNT(*) as total FROM products";
$total_result = mysqli_query($connection, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                                        echo '<td>
                                                <a href="editProduct.php?id=' . htmlspecialchars($row['id']) . '" style="color: #0d6efd; text-decoration: underline; margin-right: 15px;">Edit</a>
                                                <a href="deleteProduct.php?id=' . htmlspecialchars($row['id']) . '" style="color: #dc3545; text-decoration: underline;" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
                                            </td>';
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
    <?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <li class="page-item <?php if ($p == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
    document.querySelector('.searchbar').addEventListener('input', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('.product-table tbody tr').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
        });
    });
    </script>
</body>
</html>
