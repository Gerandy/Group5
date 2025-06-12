<?php
include('db/database.php');

// Pagination setup
$limit = 5; // Products per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search setup
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$where = $search ? "WHERE product_name LIKE '%$search%' OR brand LIKE '%$search%'" : "";

// Get total products count for pagination
$count_query = "SELECT COUNT(*) as total FROM products $where";
$count_result = mysqli_query($connection, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products for current page
$product_query = "SELECT * FROM products $where ORDER BY product_name ASC LIMIT $limit OFFSET $offset";
$product_result = mysqli_query($connection, $product_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voucher Management - TechEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #C0C0C0; min-height: 100vh; margin: 0; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .container.mt-4 { display: flex; justify-content: center; align-items: flex-start; min-height: 80vh; }
        .tab-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.12);
            width: 1020px; /* Increased width for better switch label visibility */
            min-height: 88vh; /* Slightly reduced height for less bottom gap */
            padding: 40px 35px 35px 35px;
            display: flex;
            flex-direction: column;
        }
        .form-title { text-align: center; font-size: 2rem; font-weight: bold; color: #2c6ea3; margin-bottom: 25px; }
        .voucher-list { max-height: 250px; overflow-y: auto; margin-bottom: 20px; }
        .voucher-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .voucher-item.active { background: #e6ffe6; }
        .voucher-actions button { margin-left: 5px; }
        .products-list, .voucher-products-list { max-height: none; /* Remove scroll for product list */ overflow-y: visible; margin-bottom: 0; }
        .products-list table, .voucher-products-list table { width: 100%; }
        .products-list th, .voucher-products-list th { font-size: 1rem; }
        .products-list td, .voucher-products-list td { font-size: 0.95rem; }
        .pagination {
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 0;
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
            margin-bottom: 10px;
        }
        .Confirm-button {
            border-radius: 15px; border: none; background-color: #1C8D20; width: 60%; text-align: center;
            font-family: inter; cursor: pointer; font-weight: bold; padding: 12px; margin: 30px auto 0 auto;
            color: #fff; font-size: 1.15rem; transition: background 0.2s; box-shadow: 0 2px 8px rgba(28,141,32,0.08);
        }
        .Confirm-button:hover { background-color: #157016; }
        @media (max-width: 1000px) {
            .tab-container { width: 100%; padding: 20px 5px 20px 5px; }
        }
        /* Switch styles */
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 32px;
  vertical-align: middle;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #dc3545;
  transition: .4s;
  border-radius: 32px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

.switch input:checked + .slider {
  background-color: #1C8D20;
}

.switch input:checked + .slider:before {
  transform: translateX(28px);
}

.slider:after {
  content: '';
  /* Remove ON/OFF text */
}
.switch input:checked + .slider:after {
  content: '';
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #2c6ea3; height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" style="font-size: 2rem;" href="#">TechEase</a>
    <div class="ms-auto">
      <a href="product.php" class="btn btn-light" style="font-weight: 500;">Product Page</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="tab-container">
        <div class="form-title">Voucher Management</div>
        <!-- Add Voucher Form -->
        <form class="mb-4 d-flex" style="gap:10px;">
            <input type="text" class="form-control" placeholder="Enter voucher name..." required>
            <button type="button" class="btn btn-success">Add Voucher</button>
        </form>
        <div class="row">
            <!-- Voucher List -->
            <div class="col-md-4">
                <div class="voucher-list">
                    <div class="voucher-item active">
                        <span style="color:#2c6ea3;font-weight:bold;">Summer Sale</span>
                        <div class="voucher-actions">
                            <!-- Replace the Turn On/Turn Off buttons inside .voucher-actions with this switch markup -->
                            <label class="switch">
                              <input type="checkbox" checked>
                              <span class="slider"></span>
                            </label>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </div>
                    </div>
                    <div class="voucher-item">
                        <span style="color:#2c6ea3;font-weight:bold;">Holiday Bundle</span>
                        <div class="voucher-actions">
                            <!-- Replace the Turn On/Turn Off buttons inside .voucher-actions with this switch markup -->
                            <label class="switch">
                              <input type="checkbox">
                              <span class="slider"></span>
                            </label>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </div>
                    </div>
                    <!-- More vouchers... -->
                </div>
            </div>
            <!-- Voucher Products Management -->
            <div class="col-md-8">
                <div class="mb-3">
                    <strong>Products in Voucher:</strong>
                    <div class="voucher-products-list">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mouse X100</td>
                                    <td>Logitech</td>
                                    <td>500</td>
                                    <td><button class="btn btn-sm btn-danger">Remove</button></td>
                                </tr>
                                <tr>
                                    <td>Keyboard K200</td>
                                    <td>HP</td>
                                    <td>700</td>
                                    <td><button class="btn btn-sm btn-danger">Remove</button></td>
                                </tr>
                                <!-- More products... -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <strong>Add Product to Voucher:</strong>
                    <form id="searchForm" class="d-flex mb-2" style="gap:10px;" onsubmit="return false;">
                        <input type="text" id="searchInput" name="search" class="searchbar" placeholder="Search product...">
                    </form>
                    <div class="products-list" id="productsList">
                        <!-- Products table will be loaded here by AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function loadProducts(page = 1, search = '') {
    $.get('fetch_products.php', { page: page, search: search }, function(data) {
        $('#productsList').html(data);
    });
}

// Initial load
$(document).ready(function() {
    loadProducts();

    // Live search
    $('#searchInput').on('input', function() {
        loadProducts(1, $(this).val());
    });

    // Pagination click (delegated)
    $('#productsList').on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#searchInput').val();
        loadProducts(page, search);
    });
});
</script>
</body>
</html>