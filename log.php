<?php
$logs = [];
$logFile = __DIR__ . '/log.json';
if (file_exists($logFile)) {
    $logs = json_decode(file_get_contents($logFile), true) ?: [];
}

// Pagination setup
$logsPerPage = 10; // Show only 10 items per page

// --- Add search logic ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $logs = array_filter($logs, function($log) use ($search) {
        return isset($log['receipt_number']) && stripos($log['receipt_number'], $search) !== false;
    });
}
// --- End search logic ---

$totalLogs = count($logs);
$totalPages = ceil($totalLogs / $logsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$start = ($page - 1) * $logsPerPage;
$logsToShow = array_slice(array_reverse($logs), $start, $logsPerPage);
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
    <center><h2 class="mb-4 fw-bold" style="color:#2c6ea3;">Transaction Logs</h2></center>
    <div class="mx-auto" style="max-width:1200px;">
        <!-- --- Add search bar here --- -->
        <form class="mb-3 d-flex justify-content-end" method="get" style="max-width:400px; margin-left:auto;">
            <input type="text" name="search" class="form-control me-2" placeholder="Search transaction number..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <!-- --- End search bar --- -->
        <!-- Card with increased height and pagination inside -->
        <div class="bg-white rounded-4 shadow-lg p-3 pb-3" style="height:650px; display: flex; flex-direction: column; justify-content: flex-start;">
            <!-- Table header (fixed) -->
            <div style="overflow: hidden;">
                <table class="table table-bordered align-middle mb-0" style="table-layout:fixed;">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 14%;">Date/Time</th>
                            <th style="width: 32%;">Items</th>
                            <th style="width: 11%;">Total</th>
                            <th style="width: 11%;">Pay</th>
                            <th style="width: 11%;">Change</th>
                            <th style="width: 9%;">Discount</th>
                            <th style="width: 12%;">Reprint</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Table body (scrollable) -->
            <div style="height:600px; overflow-y:auto;">
                <table class="table table-bordered align-middle mb-0" style="table-layout:fixed;">
                    <tbody>
                        <?php
                        $rowCount = 0;
                        foreach ($logsToShow as $log): $rowCount++; ?>
                        <tr style="height:50px;">
                            <td class="text-break" style="width: 14%;"><?= htmlspecialchars($log['datetime']) ?></td>
                            <td class="text-break" style="width: 32%; word-break:break-word;">
                                <?= isset($log['receipt_number']) ? htmlspecialchars($log['receipt_number']) : 'N/A' ?>
                            </td>
                            <td class="text-break fw-semibold text-success" style="width: 11%;">₱<?= htmlspecialchars($log['total']) ?></td>
                            <td class="text-break" style="width: 11%;">₱<?= htmlspecialchars($log['pay']) ?></td>
                            <td class="text-break" style="width: 11%;">₱<?= htmlspecialchars($log['change']) ?></td>
                            <td class="text-break" style="width: 9%;"><?= isset($log['discount']) ? $log['discount'].'%' : '0%' ?></td>
                            <td style="width: 12%;">
                                <button class="btn btn-outline-primary btn-sm reprint-btn w-100 rounded-pill" data-log='<?= htmlspecialchars(json_encode($log), ENT_QUOTES, "UTF-8") ?>'>
                                    <img src="https://img.icons8.com/ios-filled/18/2c6ea3/print.png" style="margin-right:6px;filter:invert(0.2);">Reprint
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php for ($i = $rowCount; $i < 10; $i++): ?>
                        <tr style="height:50px;">
                            <td colspan="7" style="background:#f8fafc;">&nbsp;</td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination INSIDE the card, just below the table -->
            <div class="d-flex justify-content-center align-items-center mt-2">
                <nav aria-label="Transaction log pagination">
                    <ul class="pagination justify-content-center mb-0">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                                <a class="page-link rounded-pill" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
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
<style>
.table {
    border-radius: 1rem;
    overflow: hidden;
    background: #fff;
}
.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    font-size: 1.05rem;
    background: #fff;
    word-break: break-word;
    border-color: #e3e8ee !important;
    min-width: 80px;
    white-space: normal;
}
.table thead th {
    background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%) !important;
    color: #fff;
    font-weight: 600;
    border-bottom: 2px solid #4682b4;
    font-size: 1.08rem;
    letter-spacing: 0.5px;
}
.table tbody tr {
    transition: background 0.2s;
}
.table tbody tr:hover {
    background: #f0f6fa;
}
.pagination .page-link {
    color: #2c6ea3;
    border: none;
    font-weight: 500;
    margin: 0 2px;
    transition: background 0.2s, color 0.2s;
}
.pagination .page-item.active .page-link,
.pagination .page-link:hover {
    background: #2c6ea3;
    color: #fff;
}
.bg-white {
    background: #fff !important;
}
@media (max-width: 1200px) {
    .table th, .table td { font-size: 0.98rem; }
}
@media (max-width: 900px) {
    .table th, .table td { font-size: 0.92rem; }
}
</style>
</body>
</html>