<?php
$logs = [];
$logFile = __DIR__ . '/log.json';
if (file_exists($logFile)) {
    $logs = json_decode(file_get_contents($logFile), true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaction Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%); height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="font-size: 2rem; color: #fff;" href="index.php">
      <img src="assets/teacheaseshoplogo.png" alt="Logo" style="height:36px;margin-right:10px;">TechEase
    </a>
    <div class="dropdown ms-auto">
      <button class="btn btn-outline-light rounded-pill px-4 py-2 d-flex align-items-center" type="button" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight:600; font-size:1.1rem; box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <span class="me-2"><img src="https://img.icons8.com/ios-filled/24/2c6ea3/menu--v1.png" style="filter:invert(1);height:22px;"></span> Menu
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 animate__animated animate__fadeInDown" aria-labelledby="menuDropdown" style="min-width:220px;">
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="product.php"><img src="assets/productslogo.png" class="me-2" alt="Products">Products</a></li>
        <li><a class="dropdown-item py-3 d-flex align-items-center" href="index.php"><img src="assets/homelogo.png" class="me-2" alt="Home">Home</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h2>Transaction Logs</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Items</th>
                <th>Total</th>
                <th>Pay</th>
                <th>Change</th>
                <th>Discount</th>
                <th>Reprint</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_reverse($logs) as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['datetime']) ?></td>
                <td>
                    <?php foreach ($log['cart'] as $item): ?>
                        <?= htmlspecialchars($item['name']) ?> x<?= $item['quantity'] ?> (₱<?= $item['price'] ?>)<br>
                    <?php endforeach; ?>
                </td>
                <td>₱<?= htmlspecialchars($log['total']) ?></td>
                <td>₱<?= htmlspecialchars($log['pay']) ?></td>
                <td>₱<?= htmlspecialchars($log['change']) ?></td>
                <td><?= isset($log['discount']) ? $log['discount'].'%' : '0%' ?></td>
                <td>
                    <button class="btn btn-primary btn-sm reprint-btn" data-log='<?= htmlspecialchars(json_encode($log), ENT_QUOTES, "UTF-8") ?>'>Reprint</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.querySelectorAll('.reprint-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const log = JSON.parse(this.getAttribute('data-log'));
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: [90, 120 + log.cart.length * 8]
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
        doc.text('Date: ' + log.datetime, 5, y);
        y += 6;
        doc.setFontSize(10);
        doc.text('Item', 5, y);
        doc.text('Qty', 45, y, { align: 'center' });
        doc.text('Price', 75, y, { align: 'right' });
        y += 6;
        doc.setLineWidth(0.1);
        doc.line(5, y - 5, 75, y - 5);
        log.cart.forEach(item => {
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
        doc.text(log.subtotal.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        if (log.discount > 0) {
            doc.text('Discount (' + log.discount + '%):', 5, y);
            doc.text((log.subtotal * (log.discount / 100)).toLocaleString(), 75, y, { align: 'right' });
            y += 5;
        }
        doc.text('TOTAL:', 5, y);
        doc.text(log.total.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        doc.text('PAY:', 5, y);
        doc.text(log.pay.toLocaleString(), 75, y, { align: 'right' });
        y += 5;
        doc.text('CHANGE:', 5, y);
        doc.text(log.change.toLocaleString(), 75, y, { align: 'right' });
        y += 8;
        doc.setFontSize(9);
        doc.text('Thank you for shopping!', 40, y, { align: 'center' });
        doc.save('receipt_' + log.id + '.pdf');
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>