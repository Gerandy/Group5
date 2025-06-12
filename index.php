<?php 
include ('db/database.php'); 

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
                    <div class="search-container" style="display: flex; align-items: center; justify-content: flex-start;">
                        <input type="text" class="searchbar" placeholder="Search product...">
                    </div>
                    <hr class="separator-line">
                    <div class="product-table">
                        <table class="table table-striped">
        <tr>
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
                <div class="pos-buttons">
                    <button class="">Mode of Payment</button>
                    <button class="">Discount</button>
                    <button class="">Clear All</button>
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
        <span><strong>₱</strong> <input type="number" id="pay-amount" class="form-control form-control-sm d-inline" style="width:180px;display:inline;" min="0" value="0"></span>
    </div>
    <hr>
    <div class="total-row">
        <span>CHANGE</span>
        <span><strong>₱</strong> <input type="text" id="change-amount" class="form-control form-control-sm d-inline" style="width:180px;display:inline;" value="0" readonly></span>
    </div>
    <hr>
    <div class="total-row">
        <span>TOTAL</span>
        <span><strong>₱</strong> <button class="btn btn-sm btn-light" id="total-amount">0</button></span>
    </div>
</div>
                   
                </div>
                
                <button class="button-checkout">Print/Pay</button>
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

    const cart = {};
    let discountPercent = 0;

    document.querySelectorAll('.addbutton').forEach(function(button) {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const productId = this.getAttribute('data-product-id');
            const name = row.children[0].textContent;
            const stock = parseInt(row.children[2].textContent); // Stock Left column
            const price = parseFloat(row.children[3].textContent.replace(/[^\d.]/g, ''));

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
        document.getElementById('total-amount').textContent = total.toLocaleString();
        return total;
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
        <span class="text-muted" style="font-size:12px;">${item.stock}</span>
    </td>
    <td>
        ₱${(item.price * item.quantity).toLocaleString()}
        <span class="cart-delete text-danger" data-product-id="${productId}" style="cursor:pointer; float:right; margin-left:10px; font-weight:bold;">Delete</span>
    </td>
</tr>
`;
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
                renderCart();
            });
        });

        document.querySelectorAll('.cart-delete').forEach(function(span) {
            span.addEventListener('click', function() {
                const id = this.getAttribute('data-product-id');
                delete cart[id];
                renderCart();
            });
        });

        updateTotal();
        updateChange();
    }

    function updateChange() {
        const total = updateTotal();
        const payInput = document.getElementById('pay-amount');
        let pay = parseFloat(payInput.value) || 0;
        const changeField = document.getElementById('change-amount');
        if (pay < total) {
            changeField.value = pay === 0 ? "0" : "Insufficient Amount";
        } else {
            changeField.value = (pay - total).toLocaleString();
        }
    }

    document.getElementById('pay-amount').addEventListener('input', updateChange);

    document.querySelector('.button-checkout').addEventListener('click', function() {
        const total = updateTotal();
        const pay = parseFloat(document.getElementById('pay-amount').value) || 0;
        const change = parseFloat(document.getElementById('change-amount').value.replace(/,/g, '')) || 0;
        if (Object.keys(cart).length === 0) {
            alert('Cart is empty. Cannot print receipt.');
            return;
        }
        if (pay < total) {
            alert('Insufficient amount.');
            return;
        }

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
        y += 6;
        doc.setFontSize(10);
        doc.text('Item', 5, y);
        doc.text('Qty', 45, y, { align: 'center' });
        doc.text('Price', 75, y, { align: 'right' });
        y += 6;
        doc.setLineWidth(0.1);
        doc.line(5, y - 5, 75, y - 5);

        Object.values(cart).forEach(item => {
            doc.setFontSize(9);
            doc.text(item.name, 5, y);
            doc.text(String(item.quantity), 40, y, { align: 'center' });
            doc.text((item.price * item.quantity).toLocaleString(), 75, y, { align: 'right' });
            y += 6;
        });

        doc.line(5, y - 2, 75, y - 2);
        y += 4;

        doc.setFontSize(10);
        let subtotal = 0;
        Object.values(cart).forEach(item => { subtotal += item.price * item.quantity; });

 
const controlNumber = 'CN-' + Date.now() + '-' + Math.floor(Math.random() * 900 + 100);


doc.setFontSize(10);
doc.text('Control No: ' + controlNumber, 5, y);
y += 6;

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
                control_number: controlNumber 
            })
        });

        fetch('update_stock.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Object.values(cart))
        });

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


        for (let key in cart) delete cart[key];
        renderCart();

 
        setTimeout(() => {
            location.reload();
        }, 500); 
    });

    
    document.querySelector('.searchbar').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        document.querySelectorAll('.product-table tr').forEach(function(row, idx) {
           
            if (idx === 0) return;
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchValue) ? '' : 'none';
        });
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
</script>
</body>
</html>
<?php if ($total_pages > 1): ?>
<nav>
    <ul class="pagination justify-content-center mt-4">
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <li class="page-item <?php if ($p == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
