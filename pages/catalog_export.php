<?php
$page_title = 'Catalog export';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);
ini_set('display_errors', '0');

$scope = $_GET['scope'] ?? 'catalog';
$format = strtolower(trim((string)($_GET['format'] ?? 'xls')));
if (!in_array($format, ['xls', 'xlsx', 'csv', 'pdf'], true)) {
  $format = 'xls';
}

function clear_output_buffers(): void {
  while (ob_get_level() > 0) {
    @ob_end_clean();
  }
}

function out_csv(string $filename, array $headers, array $rows): void {
  clear_output_buffers();
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=' . $filename);
  $out = fopen('php://output', 'w');
  fwrite($out, "\xEF\xBB\xBF");
  fputcsv($out, $headers, ';');
  foreach ($rows as $row) {
    fputcsv($out, $row, ';');
  }
  fclose($out);
  exit;
}

function out_excel_xls(string $filename, array $headers, array $rows): void {
  clear_output_buffers();
  if (!preg_match('/\.xls$/i', $filename)) {
    $filename = preg_replace('/\.(xlsx|csv|pdf)$/i', '', $filename) . '.xls';
  }

  header('Content-Type: application/vnd.ms-excel; charset=utf-8');
  header('Content-Disposition: attachment; filename=' . $filename);

  echo "\xEF\xBB\xBF";
  echo "<table border='1'>";
  echo '<tr>';
  foreach ($headers as $h) {
    echo '<th>' . htmlspecialchars((string)$h, ENT_QUOTES, 'UTF-8') . '</th>';
  }
  echo '</tr>';

  foreach ($rows as $row) {
    echo '<tr>';
    foreach ($row as $cell) {
      echo '<td>' . htmlspecialchars((string)$cell, ENT_QUOTES, 'UTF-8') . '</td>';
    }
    echo '</tr>';
  }
  echo '</table>';
  exit;
}

function pdf_escape(string $s): string {
  $s = str_replace('\\', '\\\\', $s);
  $s = str_replace('(', '\\(', $s);
  $s = str_replace(')', '\\)', $s);
  $s = preg_replace('/[\r\n\t]+/', ' ', $s);
  return $s;
}

function out_pdf(string $filename, array $headers, array $rows): void {
  clear_output_buffers();
  if (!preg_match('/\.pdf$/i', $filename)) {
    $filename = preg_replace('/\.(xlsx|xls|csv)$/i', '', $filename) . '.pdf';
  }

  $lines = [];
  $lines[] = implode(' | ', array_map('strval', $headers));
  foreach ($rows as $row) {
    $lines[] = implode(' | ', array_map(static fn($v) => (string)$v, $row));
  }

  // Keep file readable (single page text report)
  $lines = array_slice($lines, 0, 50);

  $content = "BT\n/F1 10 Tf\n50 800 Td\n";
  foreach ($lines as $i => $line) {
    $content .= '(' . pdf_escape($line) . ") Tj\n";
    $content .= "0 -14 Td\n";
  }
  $content .= "ET";

  $obj1 = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
  $obj2 = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
  $obj3 = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 842] /Contents 5 0 R /Resources << /Font << /F1 4 0 R >> >> >>\nendobj\n";
  $obj4 = "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
  $obj5 = "5 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream\nendobj\n";

  $pdf = "%PDF-1.4\n";
  $offsets = [0];
  foreach ([$obj1, $obj2, $obj3, $obj4, $obj5] as $obj) {
    $offsets[] = strlen($pdf);
    $pdf .= $obj;
  }

  $xrefPos = strlen($pdf);
  $pdf .= "xref\n0 6\n";
  $pdf .= "0000000000 65535 f \n";
  for ($i = 1; $i <= 5; $i++) {
    $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . "\n";
  }
  $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n" . $xrefPos . "\n%%EOF";

  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename=' . $filename);
  echo $pdf;
  exit;
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

  $headers = ['Name', 'quantity'];
  $rows = [];

  $cart = $_SESSION['catalog_cart'] ?? [];
  foreach ($cart as $productId => $item) {
    $pid = (int)$productId;
    $product = find_by_id('products', $pid);
    if (!$product) {
      continue;
    }

    $rows[] = [
      $product['name'] ?? '',
      $item['quantity'] ?? 1,
    ];
  }

  $rows[] = ['', ''];
  $rows[] = ['Project', $projectName !== '' ? $projectName : 'No project selected'];
  $rows[] = ['Order', $orderNumber];

  if ($format === 'csv') {
    out_csv($baseName . '.csv', $headers, $rows);
  }
  if ($format === 'pdf') {
    out_pdf($baseName . '.pdf', $headers, $rows);
  }

  // xls + xlsx both exported as stable Excel-compatible .xls
  out_excel_xls($baseName . '.xls', $headers, $rows);
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

$base = 'catalog_export_' . date('Ymd_His');
if ($format === 'csv') {
  out_csv($base . '.csv', $headers, $rows);
}
if ($format === 'pdf') {
  out_pdf($base . '.pdf', $headers, $rows);
}
out_excel_xls($base . '.xls', $headers, $rows);
