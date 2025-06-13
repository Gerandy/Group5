<?php
include('db/database.php');

$limit = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$where = $search ? "WHERE product_name LIKE '%$search%' OR brand LIKE '%$search%' OR price LIKE '%$search%'" : "";

$count_query = "SELECT COUNT(*) as total FROM products $where";
$count_result = mysqli_query($connection, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $limit);

$product_query = "SELECT * FROM products $where ORDER BY product_name ASC LIMIT $limit OFFSET $offset";
$product_result = mysqli_query($connection, $product_query);
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Add</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($product_result) > 0): ?>
            <?php $rowCount = 0; while ($row = mysqli_fetch_assoc($product_result)): $rowCount++; ?>
            <tr style="height:48px;">
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
                <td>₱<?= number_format($row['price'], 2) ?></td>
                <td>
                    <button class="btn btn-sm btn-success">Add</button>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php for ($i = $rowCount; $i < $limit; $i++): ?>
            <tr style="height:48px;">
                <td colspan="5" style="background:#f8fafc;">&nbsp;</td>
            </tr>
            <?php endfor; ?>
        <?php else: ?>
            <tr><td colspan="4" class="text-center">No products found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
        <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>