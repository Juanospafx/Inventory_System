<?php
$page_title = 'Catalog export';
require_once(__DIR__ . '/../includes/load.php');
@require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);

ini_set('display_errors', '0');

$scope = $_GET['scope'] ?? 'catalog';
$format = strtolower(trim((string)($_GET['format'] ?? 'xlsx')));
if (!in_array($format, ['xlsx', 'csv'], true)) {
  $format = 'xlsx';
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
  header('Cache-Control: no-store, no-cache, must-revalidate');
  $out = fopen('php://output', 'w');
  fwrite($out, "\xEF\xBB\xBF");
  fputcsv($out, $headers, ';');
  foreach ($rows as $row) {
    fputcsv($out, $row, ';');
  }
  fclose($out);
  exit;
}

function xlsx_col(int $n): string {
  $s = '';
  while ($n > 0) {
    $m = ($n - 1) % 26;
    $s = chr(65 + $m) . $s;
    $n = intdiv($n - 1, 26);
  }
  return $s;
}

function xlsx_escape(string $v): string {
  return htmlspecialchars($v, ENT_XML1 | ENT_COMPAT, 'UTF-8');
}

function build_sheet_xml(array $headers, array $rows): string {
  $all = array_merge([$headers], $rows);
  $maxCols = count($headers);
  $lastCol = xlsx_col(max(1, $maxCols));
  $lastRow = max(1, count($all));

  $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
  $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
  $xml .= '<dimension ref="A1:' . $lastCol . $lastRow . '"/>';
  $xml .= '<sheetData>';

  foreach ($all as $rIdx => $row) {
    $r = $rIdx + 1;
    $xml .= '<row r="' . $r . '">';
    for ($c = 0; $c < $maxCols; $c++) {
      $val = (string)($row[$c] ?? '');
      $ref = xlsx_col($c + 1) . $r;
      if ($r > 1 && is_numeric($val) && $val !== '') {
        $xml .= '<c r="' . $ref . '"><v>' . $val . '</v></c>';
      } else {
        $xml .= '<c r="' . $ref . '" t="inlineStr"><is><t>' . xlsx_escape($val) . '</t></is></c>';
      }
    }
    $xml .= '</row>';
  }

  $xml .= '</sheetData></worksheet>';
  return $xml;
}

function out_xlsx(string $filename, array $headers, array $rows): void {
  if (!class_exists('ZipStream\\ZipStream')) {
    $csvName = preg_replace('/\.xlsx$/i', '.csv', $filename);
    out_csv($csvName, $headers, $rows);
  }

  try {
    $sheetXml = build_sheet_xml($headers, $rows);

    $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
      . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
      . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
      . '<Default Extension="xml" ContentType="application/xml"/>'
      . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
      . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
      . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
      . '</Types>';

    $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
      . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
      . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
      . '</Relationships>';

    $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
      . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
      . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
      . '<sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets>'
      . '</workbook>';

    $wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
      . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
      . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
      . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
      . '</Relationships>';

    $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
      . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
      . '<fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>'
      . '<fills count="1"><fill><patternFill patternType="none"/></fill></fills>'
      . '<borders count="1"><border/></borders>'
      . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
      . '<cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>'
      . '</styleSheet>';

    clear_output_buffers();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Cache-Control: no-store, no-cache, must-revalidate');

    $out = fopen('php://output', 'wb');
    $zip = new ZipStream\ZipStream(outputName: $filename, sendHttpHeaders: false, outputStream: $out);
    $zip->addFile(fileName: '[Content_Types].xml', data: $contentTypes);
    $zip->addFile(fileName: '_rels/.rels', data: $rels);
    $zip->addFile(fileName: 'xl/workbook.xml', data: $workbook);
    $zip->addFile(fileName: 'xl/_rels/workbook.xml.rels', data: $wbRels);
    $zip->addFile(fileName: 'xl/styles.xml', data: $styles);
    $zip->addFile(fileName: 'xl/worksheets/sheet1.xml', data: $sheetXml);
    $zip->finish();
    fclose($out);
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
