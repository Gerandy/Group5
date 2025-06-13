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
    <div class="tab-container">
        <div class="form-title">Voucher Management</div>
        <!-- Add Voucher Button Centered -->
        <div class="d-flex justify-content-center mb-4">
            <button type="button" class="btn btn-success" id="showAddVoucherModal" style="width: 320px; font-size: 1.2rem; font-weight: 600;">
                + Add Voucher
            </button>
        </div>
        <!-- Add Voucher Modal -->
        <div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addVoucherModalLabel">Add New Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addVoucherForm">
                  <div class="mb-3">
                    <label for="voucherTitle" class="form-label">Voucher Title</label>
                    <input type="text" class="form-control" id="voucherTitle">
                  </div>
                  <div class="mb-3">
                    <label for="voucherCode" class="form-label">Voucher Code</label>
                    <input type="text" class="form-control" id="voucherCode">
                  </div>
                  <div class="mb-3">
                    <label for="voucherDiscount" class="form-label">Discount Percentage (%)</label>
                    <input type="number" class="form-control" id="voucherDiscount" min="1" max="100">
                  </div>
                  <div id="voucherError" class="alert alert-danger py-2 px-3 mb-3 d-none" role="alert" style="font-size: 0.98rem;"></div>
                  <button type="submit" class="btn btn-success w-100">Add Voucher</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Edit Voucher Modal -->
        <div class="modal fade" id="editVoucherModal" tabindex="-1" aria-labelledby="editVoucherModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editVoucherModalLabel">Edit Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="editVoucherForm">
                  <div class="mb-3">
                    <label for="editVoucherTitle" class="form-label">Voucher Title</label>
                    <input type="text" class="form-control" id="editVoucherTitle">
                  </div>
                  <div class="mb-3">
                    <label for="editVoucherCode" class="form-label">Voucher Code</label>
                    <input type="text" class="form-control" id="editVoucherCode">
                  </div>
                  <div class="mb-3">
                    <label for="editVoucherDiscount" class="form-label">Discount Percentage (%)</label>
                    <input type="number" class="form-control" id="editVoucherDiscount" min="1" max="100">
                  </div>
                  <div id="editVoucherError" class="alert alert-danger py-2 px-3 mb-3 d-none" role="alert" style="font-size: 0.98rem;"></div>
                  <button type="submit" class="btn btn-success w-100" id="editVoucherConfirmBtn" disabled>Confirm</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
            <!-- Voucher List -->
            <div class="col-md-4">
                <div class="voucher-list">
                    <div class="voucher-item active">
                        <span style="color:#2c6ea3;font-weight:bold;">Summer Sale</span>
                        <div class="voucher-actions d-flex align-items-center">
                            <label class="switch mb-0">
                              <input type="checkbox" checked>
                              <span class="slider"></span>
                            </label>
                            <a href="editVoucher.php?id=1" class="btn btn-sm btn-primary ms-2 me-2">Edit</a>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </div>
                    </div>
                    <div class="voucher-item">
                        <span style="color:#2c6ea3;font-weight:bold;">Holiday Bundle</span>
                        <div class="voucher-actions d-flex align-items-center">
                            <label class="switch mb-0">
                              <input type="checkbox">
                              <span class="slider"></span>
                            </label>
                            <a href="editVoucher.php?id=2" class="btn btn-sm btn-primary ms-2 me-2">Edit</a>
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
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mouse X100</td>
                                    <td>Logitech</td>
                                    <td>500</td>
                                    <td><button class="btn btn-sm btn-danger">Remove</button></td>
                                </tr>
                                <tr>
                                    <td>2</td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
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

// Show modal on button click
document.getElementById('showAddVoucherModal').onclick = function() {
    var modal = new bootstrap.Modal(document.getElementById('addVoucherModal'));
    modal.show();
};

// Prevent form submission (demo only)
document.getElementById('addVoucherForm').onsubmit = function(e) {
    e.preventDefault();
    // Get field values
    const title = document.getElementById('voucherTitle').value.trim();
    const code = document.getElementById('voucherCode').value.trim();
    const discount = document.getElementById('voucherDiscount').value.trim();
    let missing = [];

    if (!title) missing.push("Voucher Title");
    if (!code) missing.push("Voucher Code");
    if (!discount) missing.push("Discount Percentage");

    const errorDiv = document.getElementById('voucherError');
    if (missing.length > 0) {
        errorDiv.textContent = "Please fill in the following field(s): " + missing.join(", ");
        errorDiv.classList.remove('d-none');
        return;
    } else {
        errorDiv.classList.add('d-none');
    }

    // Here you would handle the form data (AJAX or form submit)
    bootstrap.Modal.getInstance(document.getElementById('addVoucherModal')).hide();
    this.reset();
};

// Show Edit Voucher Modal and populate fields (demo only)
document.querySelectorAll('.voucher-actions .btn-primary').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        // For demo, just fill with sample data. Replace with AJAX for real data.
        const voucherItem = btn.closest('.voucher-item');
        document.getElementById('editVoucherTitle').value = voucherItem.querySelector('span').textContent.trim();
        document.getElementById('editVoucherCode').value = "SAMPLECODE"; // Replace with real code
        document.getElementById('editVoucherDiscount').value = "10"; // Replace with real discount
        document.getElementById('editVoucherError').classList.add('d-none');
        document.getElementById('editVoucherConfirmBtn').disabled = true;
        var modal = new bootstrap.Modal(document.getElementById('editVoucherModal'));
        modal.show();
    });
});

// Enable Confirm button only if any field is changed
const editFields = [
    document.getElementById('editVoucherTitle'),
    document.getElementById('editVoucherCode'),
    document.getElementById('editVoucherDiscount')
];
let originalValues = {};

function storeOriginalEditValues() {
    originalValues = {
        title: editFields[0].value,
        code: editFields[1].value,
        discount: editFields[2].value
    };
}
document.getElementById('editVoucherModal').addEventListener('show.bs.modal', storeOriginalEditValues);

editFields.forEach(function(field) {
    field.addEventListener('input', function() {
        const changed = editFields[0].value !== originalValues.title ||
                        editFields[1].value !== originalValues.code ||
                        editFields[2].value !== originalValues.discount;
        document.getElementById('editVoucherConfirmBtn').disabled = !changed;
    });
});

// Edit form validation
document.getElementById('editVoucherForm').onsubmit = function(e) {
    e.preventDefault();
    const title = document.getElementById('editVoucherTitle').value.trim();
    const code = document.getElementById('editVoucherCode').value.trim();
    const discount = document.getElementById('editVoucherDiscount').value.trim();
    let missing = [];
    if (!title) missing.push("Voucher Title");
    if (!code) missing.push("Voucher Code");
    if (!discount) missing.push("Discount Percentage");
    const errorDiv = document.getElementById('editVoucherError');
    if (missing.length > 0) {
        errorDiv.textContent = "Please fill in the following field(s): " + missing.join(", ");
        errorDiv.classList.remove('d-none');
        return;
    } else {
        errorDiv.classList.add('d-none');
    }
    bootstrap.Modal.getInstance(document.getElementById('editVoucherModal')).hide();
    this.reset();
};
</script>
</body>
</html>