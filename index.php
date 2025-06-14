<?php 
include ('db/database.php'); 

// Pagination and search setup
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Handle search
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// Build WHERE clause to exclude archived products and handle search
if ($search) {
    $where = "WHERE (product_name LIKE '%$search%' OR brand LIKE '%$search%') AND archived = 0";
} else {
    $where = "WHERE archived = 0";
}

// Get total products for pagination (with search, excluding archived)
$total_query = "SELECT COUNT(*) as total FROM products $where";
$total_result = mysqli_query($connection, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = max(1, ceil($total_products / $limit));

// Get products for current page (with search, excluding archived)
$query = "SELECT * FROM products $where LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);
?>
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
    width: 960px;
    height: 850px; 
    display: flex;
    flex-direction: column;
    margin-left:-100px;         
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
        .category-buttons-container {
            overflow-x: auto;
                
            gap: 10px;
            
            margin-top: 30px;
            background-color: #D9D9D9;
            height:120px;
        }
        .category-buttons button {
            flex: 0 0 auto;
            width: 150px;
            height: 80px;
            border-radius: 15px;
            margin-right:20px;
            margin-top:10px;
        }
        .search-container {
            display: flex;
            justify-content: flex-end;
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
        }
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3572b0;
            font-size: 20px;
            cursor: pointer;
        }
        .addbutton {
            background-color: #D9D9D9;
            border-radius: 10px;
            border: none;
            padding: 5px 10px;
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

.payment-summary {
    background-color: #D9D9D9;
    padding: 10px;
    border-radius: 10px;
    position: sticky;
    bottom: 0;
    width: 100%;
    
    
}

.payment-summary .btn {
    min-width: 120px;
    min-height: 45px;
    font-size: 1.1rem;
    border-radius: 10px;
}

.payment-summary .row {
    margin-top: 10px;
}

.payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-bottom: 1px solid #bfbfbf;
}

.payment-row:last-child {
    border-bottom: none;
}



.payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-bottom: 1px solid #bfbfbf;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    margin-top: 5px; 
    font-weight: bold; 
}

pos-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-left:80px;
}

.pos-buttons button {
    flex: 1;
    margin: 5px;
    padding: 10px;
    width:200px;
    border-radius: 10px;
    margin-left:10px;
    margin-top: 20px;
    background-color: rgb(216, 52, 52);
    color:white;
    border-color: none;
    border: none;
}

.button-checkout{
    flex: 1;
    margin: 5px;
    padding: 10px;
    width: 200px;
    border-radius: 10px;
    margin-left:125px;
    margin-top: 18px;
    background-color: rgb(5, 150, 53);
    color:white;
    border-color: none;
    border: none;
    
}

h6 {
    margin-bottom:-30px;
}

#pay-amount,
#change-amount {
    width: 180px !important;
    min-width: 120px;
    font-size: 1.1rem;
    text-align: left;
}
    </style>
</head>
<body>
    <!-- Add this just after <body> and before your .container -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%); height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="font-size: 2rem; color: #fff;" href="#">
      <img src="assets/teacheaseshoplogo.png" alt="Logo" style="height:36px;margin-right:10px;">TechEase
    </a>
    <div class="dropdown ms-auto">
      <button class="btn btn-outline-light rounded-pill px-4 py-2 d-flex align-items-center" type="button" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight:600; font-size:1.1rem; box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <span class="me-2"><img src="assets/menulogo.png" style="filter:invert(1);height:22px;"></span> Menu
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 animate__animated animate__fadeInDown" aria-labelledby="menuDropdown" style="min-width:220px;">
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="product.php"><img src="assets/productslogo.png" class="me-2">Products</a></li>
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="log.php"><img src="assets/timehistorylogo.png" class="me-2">Transaction History</a></li>
      </ul>
    </div>
  </div>
</nav>
    
    <div class="container mt-4">
        <div class="row g-3">
           
            <div class="col-lg-8">
                <div class="pos-container">
                    <form method="get" class="search-container mb-3" style="display: flex; align-items: center; justify-content: flex-start;">
    <input type="text" class="searchbar" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn btn-primary ms-2">Search</button>
</form>
                    <hr class="separator-line">
                    <div class="product-table">
                        <table class="table table-striped">
        <tr>
            <th> ID</th>
            <th> Product Name</th>
            <th> Brand</th>
            <th> Stock Left</th>
            <th> Price</th>
            <th> Option</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
                echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
                echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                echo '<td><button class="addbutton" data-product-id="' . htmlspecialchars($row['id']) . '">Add Item</button>'. '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No products found</td></tr>';
        }
        ?>
    </table>
                    </div>
                    
                </div>
                
            </div>
    
            
            <div class="col-lg-4">
                <div class="container-box">
                    <center><h5>Checkout</h5></center>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
    <!-- Cart items will be inserted here by JavaScript -->
</tbody>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="payment-summary">
    <div class="total-row">
        <span>PAY</span>
        <span><strong>₱</strong>
            <input type="number" id="pay-amount" class="form-control form-control-sm d-inline" style="width:180px;display:inline;" min="0" value="0">
        </span>
    </div>
    <hr>
    <div class="total-row">
        <span>CHANGE</span>
        <span><strong>₱</strong>
            <span id="change-amount-text">0</span>
        </span>
    </div>
    <hr>
    <div class="total-row">
        <span>Subtotal</span>
        <span><strong>₱</strong> <span id="subtotal-amount-text">0</span></span>
    </div>
    <div class="total-row">
        <span>Discount</span>
        <span><strong>₱</strong> <span id="discount-amount-text">0</span></span>
    </div>
    <div class="total-row">
        <span>Total</span>
        <span><strong>₱</strong> <span id="total-amount-text">0</span></span>
    </div>
    <!-- Button grid below total -->
    <div class="row mt-3 gx-2 gy-2">
        <div class="col-6 d-grid">
            <button class="btn btn-danger w-100" id="discount-btn">Discount</button>
        </div>
        <div class="col-6 d-grid">
            <button class="btn btn-danger w-100" id="clearAllBtn">Clear All</button>
        </div>
        <div class="col-6 d-grid">
            <button class="btn btn-danger w-100" id="modeofpayment-btn">Mode of Payment</button>
        </div>
        <div class="col-6 d-grid">
            <button class="btn btn-success w-100" id="printpay-btn">Print/Pay</button>
        </div>
    </div>
</div>
                   
                </div>
                
            </div>
        </div>
    </div>
    
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const payInput = document.getElementById('pay-amount');
    payInput.value = 0;
    payInput.disabled = true;

    // 1. Load cart from localStorage on page load
let cart = {};

function loadCart() {
    const saved = localStorage.getItem('cart');
    cart = saved ? JSON.parse(saved) : {};
}

// 2. Save cart to localStorage whenever it changes
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// 3. Call loadCart() on page load
window.addEventListener('DOMContentLoaded', function() {
    loadCart();
    renderCart(); // Make sure renderCart uses the global 'cart' variable
});

// 4. When adding/removing items, always call saveCart()
function addToCart(productId, productData) {
    // ...your logic to add/update cart...
    cart[productId] = productData;
    saveCart();
    renderCart();
}

function removeFromCart(productId) {
    delete cart[productId];
    saveCart();
    renderCart();
}

    let discountPercent = 0;
    if (localStorage.getItem('active_voucher_discount')) {
        discountPercent = parseInt(localStorage.getItem('active_voucher_discount'), 10);
    }

    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    function loadCart() {
        const saved = localStorage.getItem('cart');
        if (saved) cart = JSON.parse(saved);
        else cart = {};
    }

    loadCart();

    document.querySelectorAll('.addbutton').forEach(function(button) {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const productId = this.getAttribute('data-product-id');
            const name = row.children[1].textContent;
            const stock = parseInt(row.children[3].textContent); // Stock Left column
            const price = parseFloat(row.children[4].textContent.replace(/[^\d.]/g, ''));

            if (stock === 0) {
                alert('Cannot add item with 0 stock!');
                return;
            }

            if (cart[productId]) {
                if (cart[productId].quantity < cart[productId].stock) {
                    cart[productId].quantity += 1;
                } else {
                    alert('Cannot add more than available stock!');
                }
            } else {
                cart[productId] = {
                    id: productId,
                    name: name,
                    price: price,
                    quantity: 1,
                    stock: stock
                };
            }
            saveCart();
            renderCart();
        });
    });

    function updateTotal() {
        let total = 0;
        Object.values(cart).forEach(item => {
            total += item.price * item.quantity;
        });
        if (discountPercent > 0) {
            total = total - (total * (discountPercent / 100));
        }
        document.getElementById('total-amount-text').textContent = total.toLocaleString();
        return total;
    }

    function updateChange() {
        const total = updateTotal();
        let pay = parseFloat(document.getElementById('pay-amount').value) || 0;
        let changeText = "0";
        if (pay < total) {
            changeText = pay === 0 ? "0" : "Insufficient Amount";
        } else {
            changeText = (pay - total).toLocaleString();
        }
        document.getElementById('change-amount-text').textContent = changeText;
    }

    function renderCart() {
        const cartBody = document.getElementById('cart-body');
        cartBody.innerHTML = '';
        Object.keys(cart).forEach(function(productId) {
            const item = cart[productId];
            cartBody.innerHTML += `
<tr>
    <td>${item.name}</td>
    <td>
        <button class="btn btn-sm btn-decrease" data-product-id="${productId}">-</button>
        ${item.quantity}
        <button class="btn btn-sm btn-increase" data-product-id="${productId}">+</button>
        <span class="text-muted" style="font-size:12px;">${item.stock - item.quantity}</span>
    </td>
    <td>
        ₱${(item.price * item.quantity).toLocaleString()}
        <span class="cart-delete text-danger" data-product-id="${productId}" style="cursor:pointer; float:right; margin-left:10px; font-weight:bold;">Delete</span>
    </td>
</tr>
`;
        });

        // --- Update Stock Left in Product Table ---
        document.querySelectorAll('.product-table tr').forEach(function(row, idx) {
            if (idx === 0) return; // skip header
            const productId = row.querySelector('.addbutton')?.getAttribute('data-product-id');
            if (!productId) return;
            const stockCell = row.children[3];
            let originalStock = parseInt(stockCell.getAttribute('data-original-stock'));
            if (isNaN(originalStock)) {
                // Save original stock if not already saved
                originalStock = parseInt(stockCell.textContent);
                stockCell.setAttribute('data-original-stock', originalStock);
            }
            const inCart = cart[productId]?.quantity || 0;
            stockCell.textContent = originalStock - inCart;
            // Optional: visually disable Add Item if stock is 0
            const addBtn = row.querySelector('.addbutton');
            if (originalStock - inCart <= 0) {
                addBtn.disabled = true;
            } else {
                addBtn.disabled = false;
            }
        });

        // Disable or enable pay field based on cart content
        const payInput = document.getElementById('pay-amount');
        if (Object.keys(cart).length === 0) {
            payInput.value = 0;
            payInput.disabled = true;
        } else {
            payInput.disabled = false;
        }

        document.querySelectorAll('.btn-increase').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-product-id');
                if (cart[id].quantity < cart[id].stock) {
                    cart[id].quantity += 1;
                } else {
                    alert('Cannot add more than available stock!');
                }
                saveCart();
                renderCart();
            });
        });
        document.querySelectorAll('.btn-decrease').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-product-id');
                if (cart[id].quantity > 1) {
                    cart[id].quantity -= 1;
                } else {
                    delete cart[id];
                }
                saveCart();
                renderCart();
            });
        });

        document.querySelectorAll('.cart-delete').forEach(function(span) {
            span.addEventListener('click', function() {
                const id = this.getAttribute('data-product-id');
                delete cart[id];
                saveCart();
                renderCart();
            });
        });

        let subtotal = 0;
        for (const id in cart) {
            subtotal += cart[id].price * cart[id].quantity;
        }

        // Get discount percent from localStorage (set by addVouchers.php)
        let discountPercent = 0;
        if (localStorage.getItem('active_voucher_discount')) {
            discountPercent = parseInt(localStorage.getItem('active_voucher_discount'), 10);
        }

        let discount = 0;
        if (discountPercent > 0) {
            discount = subtotal * (discountPercent / 100);
        }

        let total = subtotal - discount;

        // Update your summary display
        document.getElementById('subtotal-amount-text').textContent = subtotal.toLocaleString();
        document.getElementById('discount-amount-text').textContent = discount > 0 ? '-' + discount.toLocaleString() : '0';
        document.getElementById('total-amount-text').textContent = total.toLocaleString();

        updateChange();
    }

    document.getElementById('pay-amount').addEventListener('input', updateChange);

    document.getElementById('modeofpayment-btn').addEventListener('click', function() {
        if (Object.keys(cart).length === 0) {
            alert('Cart is empty. Please add items before selecting a mode of payment.');
            return;
        }
        const choice = prompt('Select mode of payment:\n1. Cash (default)\n2. GCash\n3. Maya\n\nType 1, 2, or 3:');
        if (choice === '2') {
            const total = updateTotal();
            document.getElementById('pay-amount').value = total;
            updateChange();
            localStorage.setItem('cart', JSON.stringify(Object.values(cart)));
            localStorage.setItem('discountPercent', discountPercent);
            localStorage.setItem('pay', total);
            window.location.href = 'gcash.php';
        } else if (choice === '3') {
            const total = updateTotal();
            document.getElementById('pay-amount').value = total;
            updateChange();
            localStorage.setItem('cart', JSON.stringify(Object.values(cart)));
            localStorage.setItem('discountPercent', discountPercent);
            localStorage.setItem('pay', total);
            window.location.href = 'maya.php';
        } else if (choice === '1' || choice === null || choice === '') {
            // Default cash, do nothing
        } else {
            alert('Invalid choice. Please select 1, 2, or 3.');
        }
    });
    document.getElementById('clearAllBtn').addEventListener('click', function() {
        for (let key in cart) delete cart[key];
        renderCart();
    });
    document.getElementById('discount-btn').addEventListener('click', function() {
    // Redirect to voucher management page
    window.location.href = 'addVouchers.php?from=pos';
});
    document.getElementById('printpay-btn').addEventListener('click', function() {
        const total = updateTotal();
        const pay = parseFloat(document.getElementById('pay-amount').value) || 0;
        const changeText = document.getElementById('change-amount-text').textContent.replace(/,/g, '');
        let change = 0;
        if (!isNaN(changeText) && changeText !== "Insufficient Amount") {
            change = parseFloat(changeText);
        }

        if (Object.keys(cart).length === 0) {
            alert('Cart is empty. Cannot print receipt.');
            return;
        }
        if (pay < total) {
            alert('Insufficient amount.');
            return;
        }

        // Generate unique receipt number
        const receiptNumber = 'RCPT-' + Date.now() + '-' + Math.floor(Math.random() * 900 + 100);

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: [90, 120 + Object.keys(cart).length * 8]
        });

        let y = 10;
        doc.setFontSize(14);
        doc.text('TECHEASE', 45, y, { align: 'center' });
        y += 6;
        doc.setFontSize(10);
        doc.text('248 Imus City', 45, y, { align: 'center' });
        y += 5;
        doc.text('Tel: 09927274046', 45, y, { align: 'center' });
        y += 8;
        doc.setFontSize(12);
        doc.text('SALES RECEIPT', 45, y, { align: 'center' });
        y += 8;
        doc.setFontSize(9);
        doc.text('Date: ' + new Date().toLocaleString(), 5, y);
        y += 5;
        doc.setFontSize(10);
        doc.text('Receipt No: ' + receiptNumber, 5, y);
        y += 6;
        doc.setFontSize(10);
        doc.text('Item', 5, y);
        doc.text('Qty', 40, y, { align: 'center' });
        doc.text('Price', 75, y, { align: 'right' });
        y += 6;
        doc.setLineWidth(0.1);
        doc.line(5, y - 5, 75, y - 5);

        // Items with wrapped names
        Object.values(cart).forEach(item => {
            doc.setFontSize(9);
            const nameLines = doc.splitTextToSize(item.name, 32);
            doc.text(nameLines, 5, y);
            doc.text(String(item.quantity), 40, y, { align: 'center' });
            doc.text((item.price * item.quantity).toLocaleString(), 75, y, { align: 'right' });
            y += 6 * nameLines.length;
        });

        doc.line(5, y - 2, 75, y - 2);
        y += 4;

        doc.setFontSize(10);
        let subtotal = 0;
        Object.values(cart).forEach(item => { subtotal += item.price * item.quantity; });

        doc.text('Subtotal:', 5, y);
        doc.text(subtotal.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        if (discountPercent > 0) {
            doc.text('Discount (' + discountPercent + '%):', 5, y);
            doc.text((subtotal * (discountPercent / 100)).toLocaleString(), 75, y, { align: 'right' });
            y += 5;
        }
        doc.text('TOTAL:', 5, y);
        doc.text(total.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        doc.text('PAY:', 5, y);
        doc.text(pay.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        doc.text('CHANGE:', 5, y);
        doc.text(change.toLocaleString(), 75, y, { align: 'right' });
        y += 8;
        doc.setFontSize(9);
        doc.text('Thank you for shopping!', 40, y, { align: 'center' });

        doc.save('receipt.pdf');

        // Log transaction and update stock, including receipt number
        fetch('log_transaction.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                cart: Object.values(cart),
                subtotal: subtotal,
                discount: discountPercent,
                total: total,
                pay: pay,
                change: change,
                receipt_number: receiptNumber
            })
        });

        fetch('update_stock.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Object.values(cart))
        });

        // Clear cart and localStorage
        cart = {};
        localStorage.removeItem('cart');
        renderCart();

        setTimeout(() => {
            location.reload();
        }, 500); 
    });

    
    

   
    updateTotal();
    updateChange();

    document.querySelectorAll('.pos-buttons button').forEach(btn => {
    if (btn.textContent.trim() === 'Mode of Payment') {
        btn.addEventListener('click', function() {
            
            if (Object.keys(cart).length === 0) {
                alert('Cart is empty. Please add items before selecting a mode of payment.');
                return;
            }
            
            const choice = prompt('Select mode of payment:\n1. Cash (default)\n2. GCash\n3. Maya\n\nType 1, 2, or 3:');
            if (choice === '2') {
                
                const total = updateTotal();
                document.getElementById('pay-amount').value = total;
                updateChange();
                localStorage.setItem('cart', JSON.stringify(Object.values(cart)));
                localStorage.setItem('discountPercent', discountPercent);
                localStorage.setItem('pay', total);
                window.location.href = 'gcash.php';
            } else if (choice === '3') {
                
                const total = updateTotal();
                document.getElementById('pay-amount').value = total;
                updateChange();
                localStorage.setItem('cart', JSON.stringify(Object.values(cart)));
                localStorage.setItem('discountPercent', discountPercent);
                localStorage.setItem('pay', total);
                window.location.href = 'maya.php';
            } else if (choice === '1' || choice === null || choice === '') {
                
            } else {
                alert('Invalid choice. Please select 1, 2, or 3.');
            }
        });
    }
    if (btn.textContent.trim() === 'Clear All') {
        btn.addEventListener('click', function() {
            for (let key in cart) delete cart[key];
            renderCart();
        });
    }
    if (btn.textContent.trim() === 'Discount') {
        btn.addEventListener('click', function() {
            let input = prompt('Enter discount percentage (0-100):', discountPercent || 0);
            if (input === null) return; 
            input = parseFloat(input);
            if (isNaN(input) || input < 0 || input > 100) {
                alert('Please enter a valid discount percentage between 0 and 100.');
                return;
            }
            discountPercent = input;
            renderCart();
        });
    }
});
});

function reloadProductTable() {
    fetch('product_table.php')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.product-table').innerHTML = html;
      
            document.querySelectorAll('.addbutton').forEach(function(button) {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const productId = this.getAttribute('data-product-id');
                    const name = row.children[0].textContent;
                    const stock = parseInt(row.children[2].textContent);
                    const price = parseFloat(row.children[3].textContent.replace(/[^\d.]/g, ''));
                    if (cart[productId]) {
                        if (cart[productId].quantity < cart[productId].stock) {
                            cart[productId].quantity += 1;
                        } else {
                            alert('Cannot add more than available stock!');
                        }
                    } else {
                        cart[productId] = {
                            id: productId,
                            name: name,
                            price: price,
                            quantity: 1,
                            stock: stock
                        };
                    }
                    renderCart();
                });
            });
        });
}

// On page load
window.addEventListener('DOMContentLoaded', function() {
    loadCart();
    renderCart();
});

// When adding/removing items:
function addToCart(productId, ...otherArgs) {
    // ...your add logic...
    saveCart();
    renderCart();
}
function removeFromCart(productId) {
    // ...your remove logic...
    saveCart();
    renderCart();
}

// Add this function to clear the cart and localStorage
function clearAllCart() {
    cart = {};
    localStorage.removeItem('cart');
    renderCart();
}

// Example: Attach to a "Clear All" button
document.getElementById('clearAllBtn').addEventListener('click', function() {
    clearAllCart();
});
</script>
</body>
</html>
<?php if ($total_pages > 1): ?>
<nav>
    <ul class="pagination justify-content-center mt-4">
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <li class="page-item <?php if ($p == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $p; ?><?php if($search) echo '&search=' . urlencode($search); ?>"><?php echo $p; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
