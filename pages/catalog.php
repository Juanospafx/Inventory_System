<?php
$page_title = 'Catalog';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

if (!isset($_SESSION['catalog_cart'])) {
  $_SESSION['catalog_cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'add_to_cart') {
    $productId = (int)($_POST['product_id'] ?? 0);
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $unit = trim((string)($_POST['unit'] ?? 'ea'));
    $note = trim((string)($_POST['item_note'] ?? ''));

    if ($productId > 0) {
      if (!isset($_SESSION['catalog_cart'][$productId])) {
        $_SESSION['catalog_cart'][$productId] = ['quantity' => 0, 'unit' => $unit, 'note' => $note];
      }
      $_SESSION['catalog_cart'][$productId]['quantity'] += $qty;
      $_SESSION['catalog_cart'][$productId]['unit'] = $unit;
      $_SESSION['catalog_cart'][$productId]['note'] = $note;
      $session->msg('s', 'Item added to cart.');
    }

    redirect('catalog.php', false);
  }

  if ($action === 'remove_from_cart') {
    $productId = (int)($_POST['product_id'] ?? 0);
    if ($productId > 0 && isset($_SESSION['catalog_cart'][$productId])) {
      unset($_SESSION['catalog_cart'][$productId]);
      $session->msg('s', 'Item removed from cart.');
    }
    redirect('catalog.php', false);
  }

  if ($action === 'clear_cart') {
    $_SESSION['catalog_cart'] = [];
    $session->msg('s', 'Cart cleared.');
    redirect('catalog.php', false);
  }
}

$search = trim((string)($_GET['q'] ?? ''));
$where = '';
if ($search !== '') {
  $s = $db->escape($search);
  $where = "WHERE (name LIKE '%{$s}%' OR catalog_code LIKE '%{$s}%' OR catalog_category LIKE '%{$s}%' OR catalog_brand LIKE '%{$s}%')";
}

$products = find_by_sql("SELECT id, name, quantity, catalog_code, catalog_category, catalog_description, catalog_unit, catalog_brand, catalog_model, catalog_is_active FROM products {$where} ORDER BY name ASC");

$cartRows = [];
foreach ($_SESSION['catalog_cart'] as $productId => $item) {
  $pid = (int)$productId;
  $product = find_by_id('products', $pid);
  if (!$product) continue;
  $cartRows[] = [
    'id' => $pid,
    'catalog_code' => $product['catalog_code'] ?? '',
    'name' => $product['name'] ?? '',
    'quantity' => $item['quantity'] ?? 1,
    'unit' => $item['unit'] ?? ($product['catalog_unit'] ?? 'ea'),
    'note' => $item['note'] ?? '',
  ];
}
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row mb-3">
  <div class="col-md-8">
    <form method="get" class="d-flex gap-2">
      <input type="text" class="form-control" name="q" placeholder="Search by name, code, category, brand" value="<?php echo htmlspecialchars($search); ?>">
      <button class="btn btn-primary" type="submit">Search</button>
      <a class="btn btn-secondary" href="catalog.php">Reset</a>
    </form>
  </div>
  <div class="col-md-4 text-end">
    <a class="btn btn-success" href="catalog_export.php?scope=catalog">Export Catalog (CSV)</a>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading"><strong>Catalog Items</strong></div>
      <div class="panel-body table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Unit</th>
              <th>Stock</th>
              <th>Add</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $p): ?>
              <tr>
                <td><?php echo htmlspecialchars($p['catalog_code'] ?? ''); ?></td>
                <td>
                  <strong><?php echo htmlspecialchars($p['name']); ?></strong><br>
                  <small><?php echo htmlspecialchars((string)($p['catalog_description'] ?? '')); ?></small>
                </td>
                <td><?php echo htmlspecialchars((string)($p['catalog_category'] ?? '')); ?></td>
                <td><?php echo htmlspecialchars((string)($p['catalog_unit'] ?? 'ea')); ?></td>
                <td><?php echo htmlspecialchars((string)($p['quantity'] ?? '0')); ?></td>
                <td>
                  <form method="post" class="d-flex gap-1">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" name="product_id" value="<?php echo (int)$p['id']; ?>">
                    <input type="number" class="form-control form-control-sm" name="quantity" value="1" min="1" style="width:80px;">
                    <input type="text" class="form-control form-control-sm" name="unit" value="<?php echo htmlspecialchars((string)($p['catalog_unit'] ?? 'ea')); ?>" style="width:80px;">
                    <button class="btn btn-primary btn-sm" type="submit">+</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="panel panel-default mt-3">
      <div class="panel-heading"><strong>Bulk import items (CSV from Excel)</strong></div>
      <div class="panel-body">
        <p class="text-muted">Required column: <code>name</code>. Recommended columns: <code>catalog_code, catalog_category, catalog_description, catalog_unit, catalog_brand, catalog_model, quantity, note</code>.</p>
        <form method="post" action="catalog_import.php" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
          <input type="file" name="catalog_file" class="form-control" accept=".csv" required>
          <button class="btn btn-success" type="submit">Import CSV</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading d-flex justify-content-between">
        <strong>Purchase Cart</strong>
        <form method="post" onsubmit="return confirm('Clear cart?');">
          <input type="hidden" name="action" value="clear_cart">
          <button class="btn btn-danger btn-xs" type="submit">Clear</button>
        </form>
      </div>
      <div class="panel-body">
        <?php if (empty($cartRows)): ?>
          <div class="alert alert-warning">Cart is empty.</div>
        <?php else: ?>
          <table class="table table-striped table-sm">
            <thead>
              <tr><th>Code</th><th>Qty</th><th>Unit</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($cartRows as $item): ?>
              <tr>
                <td>
                  <?php echo htmlspecialchars($item['catalog_code']); ?><br>
                  <small><?php echo htmlspecialchars($item['name']); ?></small>
                </td>
                <td><?php echo (int)$item['quantity']; ?></td>
                <td><?php echo htmlspecialchars($item['unit']); ?></td>
                <td>
                  <form method="post">
                    <input type="hidden" name="action" value="remove_from_cart">
                    <input type="hidden" name="product_id" value="<?php echo (int)$item['id']; ?>">
                    <button class="btn btn-danger btn-xs" type="submit">x</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>

          <form method="get" action="catalog_export.php" class="d-grid gap-2">
            <input type="hidden" name="scope" value="cart">
            <input type="text" name="order_name" class="form-control" placeholder="Order name (optional)">
            <button class="btn btn-info" type="submit">Generate Purchase Order (CSV)</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
