<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/gcash.css">
    <title>GCASH PAYMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .maya-container {
            background-color:rgb(47, 242, 158);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 1000px;
            padding: 20px;
            color: #fff;
            position: relative;
        }
        .maya-logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 300px;
        }
        .maya-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .maya-info {
            flex: 1;
            margin-left: 90px;
        } 
        .maya-info h4, .maya-info p {
            margin: 0;
        }
        .maya-qr {
            margin-left: 20px;
        }
        .maya-qr img {
            width: 350px;
            height: 400px;
            border-radius: 10px;
            background: #fff;
            padding: 5px;
        }
        .maya-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .maya-actions button {
            width: 48%;
            border-radius: 10px;
            font-weight: bold;
        }
        .cancel-btn {
            background: #fff;
            color:rgb(47, 242, 158);
            border: none;
            height: 30px;
        }
        .confirm-btn {
            background: #fff;
            color: rgb(47, 242, 158);
            border: none;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="maya-container">
        <img src="assets/mayalogo.png" alt="Maya logo" class="maya-logo">
        <div class="maya-details">
            <div class="maya-info">
                <h1 style="font-size: 80px;">TechEase</h1>
                <p style="font-size: 40px;">09927274046</p>
            </div>
            <div class="maya-qr">
                <img src="assets/qrmaya.png" alt="Maya QR">
            </div>
        </div>
        <div class="maya-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" id="maya-confirm-btn">Confirm & Print Receipt</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
// Simulate getting cart and payment info from localStorage/session or AJAX
// Replace this with your actual cart retrieval logic
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let discountPercent = parseFloat(localStorage.getItem('discountPercent')) || 0;
let pay = parseFloat(localStorage.getItem('pay')) || 0;

document.getElementById('maya-confirm-btn').addEventListener('click', async function() {
    // Calculate totals
    let subtotal = 0;
    cart.forEach(item => { subtotal += item.price * item.quantity; });
    let total = subtotal - (subtotal * (discountPercent / 100));
    let change = pay - total;

    // Generate PDF Receipt
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'p',
        unit: 'mm',
        format: [90, 120 + cart.length * 8]
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

    cart.forEach(item => {
        doc.setFontSize(9);
        doc.text(item.name, 5, y);
        doc.text(String(item.quantity), 40, y, { align: 'center' });
        doc.text((item.price * item.quantity).toLocaleString(), 75, y, { align: 'right' });
        y += 6;
    });

    doc.line(5, y - 2, 75, y - 2);
    y += 4;

    doc.setFontSize(10);
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

    // Log transaction (optional)
    fetch('log_transaction.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            cart: cart,
            subtotal: subtotal,
            discount: discountPercent,
            total: total,
            pay: pay,
            change: change
        })
    });

    // Update stock in database and wait for it to finish
    await fetch('update_stock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(cart)
    });

    // Clear cart and redirect to index
    localStorage.removeItem('cart');
    localStorage.removeItem('discountPercent');
    localStorage.removeItem('pay');
    alert('Payment Confirmed and Receipt Printed!');
    window.location.href = 'index.php';
});
</script>
<?php
include('db/database.php'); // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode(file_get_contents('php://input'), true);
    if (is_array($cart)) {
        foreach ($cart as $item) {
            if (!isset($item['id']) || !isset($item['quantity'])) continue;
            $id = intval($item['id']);
            $qty = intval($item['quantity']);
            $sql = "UPDATE products SET stock_left = GREATEST(stock_left - $qty, 0) WHERE id = $id";
            mysqli_query($connection, $sql);
        }
        echo 'success';
    } else {
        echo 'invalid cart';
    }
}
?>
</body>
</html>