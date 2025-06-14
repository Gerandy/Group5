<?php
include('db/database.php');

// Create the vouchers table if it doesn't exist
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS vouchers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    discount_percent INT NOT NULL
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_voucher'])) {
    $voucher_name = mysqli_real_escape_string($connection, $_POST['voucher_name']);
    $voucher_discount = intval($_POST['voucher_discount']);
    mysqli_query($connection, "INSERT INTO vouchers (title, discount_percent) VALUES ('$voucher_name', $voucher_discount)");
    header("Location: addVouchers.php");
    exit;
}

// Handle voucher edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_voucher'])) {
    $edit_id = intval($_POST['edit_voucher_id']);
    $edit_name = mysqli_real_escape_string($connection, $_POST['edit_voucher_name']);
    $edit_discount = intval($_POST['edit_voucher_discount']);
    mysqli_query($connection, "UPDATE vouchers SET title='$edit_name', discount_percent=$edit_discount WHERE id=$edit_id");
    header("Location: addVouchers.php");
    exit;
}
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
            width: 500px;
            min-height: 60vh;
            padding: 40px 35px 35px 35px;
            display: flex;
            flex-direction: column;
        }
        .form-title { text-align: center; font-size: 2rem; font-weight: bold; color: #2c6ea3; margin-bottom: 25px; }
        .voucher-list { margin-bottom: 20px; }
        .voucher-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .voucher-item.active { background: #e6ffe6; }
        .voucher-actions button { margin-left: 5px; }
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
        <!-- Add Voucher Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
            Add Voucher
        </button>
        <!-- Voucher List with Sliders -->
        <div class="voucher-list" id="voucherList">
            <?php
            // Show vouchers with the most recently added on top
            $result = mysqli_query($connection, "SELECT * FROM vouchers ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="voucher-item" data-voucher-id="' . $row['id'] . '" data-discount="' . $row['discount_percent'] . '">
                        <span style="color:#2c6ea3;font-weight:bold;">' . htmlspecialchars($row['title']) . ' <span class="badge bg-info ms-2">' . $row['discount_percent'] . '%</span></span>
                        <div>
                            <label class="switch mb-0 me-2">
                                <input type="checkbox" class="voucher-switch" data-voucher-id="' . $row['id'] . '" data-discount="' . $row['discount_percent'] . '">
                                <span class="slider"></span>
                            </label>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editVoucherModal' . $row['id'] . '">Edit</button>
                        </div>
                    </div>';

                // Edit Modal for this voucher
                echo '
                <div class="modal fade" id="editVoucherModal' . $row['id'] . '" tabindex="-1" aria-labelledby="editVoucherModalLabel' . $row['id'] . '" aria-hidden="true">
                  <div class="modal-dialog">
                    <form method="post" class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editVoucherModalLabel' . $row['id'] . '">Edit Voucher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="edit_voucher_id" value="' . $row['id'] . '">
                        <div class="mb-3">
                          <label for="editVoucherName' . $row['id'] . '" class="form-label">Voucher Name</label>
                          <input type="text" class="form-control" id="editVoucherName' . $row['id'] . '" name="edit_voucher_name" value="' . htmlspecialchars($row['title']) . '" required>
                        </div>
                        <div class="mb-3">
                          <label for="editVoucherDiscount' . $row['id'] . '" class="form-label">Discount (%)</label>
                          <input type="number" class="form-control" id="editVoucherDiscount' . $row['id'] . '" name="edit_voucher_discount" min="1" max="100" value="' . $row['discount_percent'] . '" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="edit_voucher" class="btn btn-success">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
                ';
            }
            ?>
        </div>
        <div class="alert alert-info mt-4">
            <strong>How it works:</strong> Turn on a voucher to apply its discount to all items at checkout in the POS. Only one voucher can be active at a time.
        </div>
    </div>
</div>

<!-- Add Voucher Modal -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVoucherModalLabel">Add Voucher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="voucherName" class="form-label">Voucher Name</label>
          <input type="text" class="form-control" id="voucherName" name="voucher_name" required>
        </div>
        <div class="mb-3">
          <label for="voucherDiscount" class="form-label">Discount (%)</label>
          <input type="number" class="form-control" id="voucherDiscount" name="voucher_discount" min="1" max="100" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_voucher" class="btn btn-primary">Create Voucher</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Only one voucher can be active at a time
document.querySelectorAll('.voucher-switch').forEach(function(switchEl) {
    switchEl.addEventListener('change', function() {
        if (this.checked) {
            // Uncheck all other switches
            document.querySelectorAll('.voucher-switch').forEach(function(other) {
                if (other !== switchEl) other.checked = false;
            });
            // Save active voucher id and discount in localStorage
            localStorage.setItem('active_voucher_id', this.getAttribute('data-voucher-id'));
            localStorage.setItem('active_voucher_discount', this.getAttribute('data-discount'));
        } else {
            // If unchecked, remove from localStorage
            localStorage.removeItem('active_voucher_id');
            localStorage.removeItem('active_voucher_discount');
        }
    });
});

// On page load, restore the active voucher switch
window.addEventListener('DOMContentLoaded', function() {
    var activeId = localStorage.getItem('active_voucher_id');
    document.querySelectorAll('.voucher-switch').forEach(function(switchEl) {
        if (switchEl.getAttribute('data-voucher-id') === activeId) {
            switchEl.checked = true;
        }
    });
});
</script>
</body>
</html>