<?php
$page_title = 'Catalog export';
require_once(__DIR__ . '/../includes/load.php');
@require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);

$xlsxAvailable = class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet') && class_exists('PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx');
if ($xlsxAvailable) {
  class_alias('PhpOffice\\PhpSpreadsheet\\Spreadsheet', 'LocalSpreadsheet');
  class_alias('PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx', 'LocalXlsxWriter');
}

$scope = $_GET['scope'] ?? 'catalog';
$format = strtolower(trim((string)($_GET['format'] ?? 'xlsx')));
if (!in_array($format, ['xlsx', 'csv'], true)) {
  $format = 'xlsx';
}

function out_csv(string $filename, array $headers, array $rows): void {
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=' . $filename);
  $out = fopen('php://output', 'w');

  // UTF-8 BOM + semicolon delimiter for better Excel compatibility in ES locales.
  fwrite($out, "\xEF\xBB\xBF");
  fputcsv($out, $headers, ';');
  foreach ($rows as $row) {
    fputcsv($out, $row, ';');
  }
  fclose($out);
  exit;
}

function out_xlsx(string $filename, array $headers, array $rows): void {
  global $xlsxAvailable;

  // Fallback: if PhpSpreadsheet is not fully available on this host, export CSV directly.
  if (!$xlsxAvailable) {
    $csvName = preg_replace('/\.xlsx$/i', '.csv', $filename);
    out_csv($csvName, $headers, $rows);
  }

  try {
    $spreadsheet = new LocalSpreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray($headers, null, 'A1');
    $r = 2;
    foreach ($rows as $row) {
      $sheet->fromArray($row, null, 'A' . $r);
      $r++;
    }

    foreach (range('A', $sheet->getHighestColumn()) as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=' . $filename);
    $writer = new LocalXlsxWriter($spreadsheet);
    $writer->save('php://output');
    exit;
  } catch (Throwable $e) {
    $csvName = preg_replace('/\.xlsx$/i', '.csv', $filename);
    out_csv($csvName, $headers, $rows);
  }
}

if ($scope === 'cart') {
  $projectId = (int)($_GET['project_id'] ?? 0);
  $projectName = '';
  if ($projectId > 0) {
    $project = find_by_id('projects', $projectId);
    if ($project) {
      $projectName = (string)($project['name'] ?? '');
    }
  }

  $orderNumber = 'PO-' . date('Ymd-His');
  $projectSlug = $projectName !== '' ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $projectName) : 'NO_PROJECT';
  $baseName = $orderNumber . '_' . $projectSlug;
  $filename = $baseName . ($format === 'csv' ? '.csv' : '.xlsx');

  // Required layout: A1=Name, B1=quantity
  $headers = ['Name', 'quantity'];
  $rows = [];

  $cart = $_SESSION['catalog_cart'] ?? [];
  foreach ($cart as $productId => $item) {
    $pid = (int)$productId;
    $product = find_by_id('products', $pid);
    if (!$product) { continue; }

    $rows[] = [
      $product['name'] ?? '',
      $item['quantity'] ?? 1,
    ];
  }

  // Include selected project inside file (without breaking A/B headers).
  $rows[] = ['', ''];
  $rows[] = ['Project', $projectName !== '' ? $projectName : 'No project selected'];
  $rows[] = ['Order', $orderNumber];

  if ($format === 'csv') {
    out_csv($filename, $headers, $rows);
  }
  out_xlsx($filename, $headers, $rows);
}

$headers = ['id', 'catalog_code', 'name', 'catalog_category', 'catalog_description', 'catalog_unit', 'catalog_brand', 'catalog_model', 'quantity', 'catalog_is_active'];
$rows = [];
$dbRows = find_by_sql("SELECT id, catalog_code, name, catalog_category, catalog_description, catalog_unit, catalog_brand, catalog_model, quantity, catalog_is_active FROM products ORDER BY name ASC");
foreach ($dbRows as $row) {
  $rows[] = [
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
  ];
}

$filename = 'catalog_export_' . date('Ymd_His') . ($format === 'csv' ? '.csv' : '.xlsx');
if ($format === 'csv') {
  out_csv($filename, $headers, $rows);
}
out_xlsx($filename, $headers, $rows);
