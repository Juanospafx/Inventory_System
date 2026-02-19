<?php
$page_title = 'Catalog export';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

$scope = $_GET['scope'] ?? 'catalog';
$filename = 'catalog_export_' . date('Ymd_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);
$out = fopen('php://output', 'w');

if ($scope === 'cart') {
  $orderName = trim($_GET['order_name'] ?? 'purchase_order');
  $orderName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $orderName);
  header('Content-Disposition: attachment; filename=' . $orderName . '_' . date('Ymd_His') . '.csv');

  fputcsv($out, ['catalog_code', 'name', 'quantity', 'unit', 'note']);

  $cart = $_SESSION['catalog_cart'] ?? [];
  foreach ($cart as $productId => $item) {
    $pid = (int)$productId;
    $product = find_by_id('products', $pid);
    if (!$product) { continue; }

    fputcsv($out, [
      $product['catalog_code'] ?? '',
      $product['name'] ?? '',
      $item['quantity'] ?? 1,
      $item['unit'] ?? ($product['catalog_unit'] ?? 'ea'),
      $item['note'] ?? '',
    ]);
  }

  fclose($out);
  exit;
}

fputcsv($out, ['id', 'catalog_code', 'name', 'catalog_category', 'catalog_description', 'catalog_unit', 'catalog_brand', 'catalog_model', 'quantity', 'catalog_is_active']);
$rows = find_by_sql("SELECT id, catalog_code, name, catalog_category, catalog_description, catalog_unit, catalog_brand, catalog_model, quantity, catalog_is_active FROM products ORDER BY name ASC");
foreach ($rows as $row) {
  fputcsv($out, [
    $row['id'],
    $row['catalog_code'],
    $row['name'],
    $row['catalog_category'],
    $row['catalog_description'],
    $row['catalog_unit'],
    $row['catalog_brand'],
    $row['catalog_model'],
    $row['quantity'],
    $row['catalog_is_active'],
  ]);
}

fclose($out);
exit;
