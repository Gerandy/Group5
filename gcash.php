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
        .gcash-container {
            background-color:rgb(0, 80, 230);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 1000px;
            padding: 20px;
            color: #fff;
            position: relative;
        }
        .gcash-logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 300px;
        }
        .gcash-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gcash-info {
            flex: 1;
            margin-left: 90px;
        } 
        .gcash-info h4, .maya-info p {
            margin: 0;
        }
        .gcash-qr {
            margin-left: 20px;
        }
        .gcash-qr img {
            width: 350px;
            height: 400px;
            border-radius: 10px;
            background: #fff;
            padding: 5px;
        }
        .gcash-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .gcash-actions button {
            width: 48%;
            border-radius: 10px;
            font-weight: bold;
        }
        .cancel-btn {
            background: #fff;
            color: #0077c5;
            border: none;
            height: 30px;
        }
        .confirm-btn {
            background: #fff;
            color: #0077c5;
            border: none;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="gcash-container">
        <img src="assets/gcashlogo.png" alt="Gcash logo" class="gcash-logo">
        <div class="gcash-details">
            <div class="gcash-info">
                <h1 style="font-size: 80px;">TechEase</h1>
                <p style="font-size: 40px;">09927274046</p>
            </div>
            <div class="gcash-qr">
                <img src="assets/qrgcash.png" alt="Gcash QR">
            </div>
        </div>
        <div class="gcash-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" id="gcash-confirm-btn">Confirm & Print Receipt</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
    // Get cart and payment info from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let discountPercent = parseFloat(localStorage.getItem('discountPercent')) || 0;
    let pay = parseFloat(localStorage.getItem('pay')) || 0;

    document.getElementById('gcash-confirm-btn').addEventListener('click', async function() {
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
                pay: pay, // This is the exact amount input by the user
                change: change,
                payment_method: 'GCash' // or 'Maya' for maya.php
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
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $logFile = __DIR__ . '/log.json';

    $logs = [];
    if (file_exists($logFile)) {
        $logs = json_decode(file_get_contents($logFile), true) ?: [];
    }

    $data['id'] = uniqid('txn_');
    $data['datetime'] = date('Y-m-d H:i:s');

    $logs[] = $data;

    file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    echo 'logged';
}
?>