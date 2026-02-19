<?php
$page_title = 'Catalog import';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect('catalog.php', false);
}

if (!isset($_FILES['catalog_file']) || !is_uploaded_file($_FILES['catalog_file']['tmp_name'])) {
  $session->msg('d', 'Please upload a CSV file.');
  redirect('catalog.php', false);
}

$tmp = $_FILES['catalog_file']['tmp_name'];
$fh = fopen($tmp, 'r');
if (!$fh) {
  $session->msg('d', 'Could not read uploaded file.');
  redirect('catalog.php', false);
}

$header = fgetcsv($fh);
if (!$header) {
  fclose($fh);
  $session->msg('d', 'CSV is empty.');
  redirect('catalog.php', false);
}

$headerMap = [];
foreach ($header as $idx => $col) {
  $headerMap[strtolower(trim((string)$col))] = $idx;
}

$required = ['name'];
foreach ($required as $req) {
  if (!array_key_exists($req, $headerMap)) {
    fclose($fh);
    $session->msg('d', 'CSV must include column: ' . $req);
    redirect('catalog.php', false);
  }
}

$shelves = find_all('shelves');
$defaultShelfId = !empty($shelves) ? (int)$shelves[0]['id'] : 0;
if ($defaultShelfId <= 0) {
  fclose($fh);
  $session->msg('d', 'No shelf available. Create at least one shelf before importing.');
  redirect('catalog.php', false);
}

$created = 0;
$updated = 0;
$date = make_date();

while (($row = fgetcsv($fh)) !== false) {
  $name = trim((string)($row[$headerMap['name']] ?? ''));
  if ($name === '') { continue; }

  $code = trim((string)($row[$headerMap['catalog_code']] ?? ($row[$headerMap['code']] ?? '')));
  $category = trim((string)($row[$headerMap['catalog_category']] ?? ($row[$headerMap['category']] ?? '')));
  $description = trim((string)($row[$headerMap['catalog_description']] ?? ($row[$headerMap['description']] ?? '')));
  $unit = trim((string)($row[$headerMap['catalog_unit']] ?? ($row[$headerMap['unit']] ?? 'ea')));
  $brand = trim((string)($row[$headerMap['catalog_brand']] ?? ($row[$headerMap['brand']] ?? '')));
  $model = trim((string)($row[$headerMap['catalog_model']] ?? ($row[$headerMap['model']] ?? '')));
  $quantity = trim((string)($row[$headerMap['quantity']] ?? '0'));
  $note = trim((string)($row[$headerMap['note']] ?? ''));

  $nameEsc = $db->escape($name);
  $codeEsc = $db->escape($code);
  $categoryEsc = $db->escape($category);
  $descriptionEsc = $db->escape($description);
  $unitEsc = $db->escape($unit === '' ? 'ea' : $unit);
  $brandEsc = $db->escape($brand);
  $modelEsc = $db->escape($model);
  $quantityEsc = $db->escape($quantity === '' ? '0' : $quantity);
  $noteEsc = $db->escape($note);

  $existing = null;
  if ($code !== '') {
    $q = $db->query("SELECT id FROM products WHERE catalog_code = '{$codeEsc}' LIMIT 1");
    $existing = $db->fetch_assoc($q);
  }

  if ($existing) {
    $id = (int)$existing['id'];
    $sql = "UPDATE products SET "
      . "name='{$nameEsc}', "
      . "catalog_category=" . ($category === '' ? "NULL" : "'{$categoryEsc}'") . ", "
      . "catalog_description=" . ($description === '' ? "NULL" : "'{$descriptionEsc}'") . ", "
      . "catalog_unit='{$unitEsc}', "
      . "catalog_brand=" . ($brand === '' ? "NULL" : "'{$brandEsc}'") . ", "
      . "catalog_model=" . ($model === '' ? "NULL" : "'{$modelEsc}'") . ", "
      . "quantity='{$quantityEsc}', "
      . "note=" . ($note === '' ? "NULL" : "'{$noteEsc}'") . ", "
      . "catalog_is_active=1 "
      . "WHERE id={$id} LIMIT 1";
    $db->query($sql);
    $updated++;
  } else {
    if ($code === '') {
      $code = 'CAT-' . substr(md5($name . microtime(true)), 0, 10);
      $codeEsc = $db->escape($code);
    }

    $sql = "INSERT INTO products (name, catalog_code, catalog_category, catalog_description, catalog_unit, catalog_brand, catalog_model, catalog_is_active, quantity, shelf_id, date, note) VALUES ("
      . "'{$nameEsc}', '{$codeEsc}', "
      . ($category === '' ? "NULL" : "'{$categoryEsc}'") . ", "
      . ($description === '' ? "NULL" : "'{$descriptionEsc}'") . ", "
      . "'{$unitEsc}', "
      . ($brand === '' ? "NULL" : "'{$brandEsc}'") . ", "
      . ($model === '' ? "NULL" : "'{$modelEsc}'") . ", "
      . "1, '{$quantityEsc}', {$defaultShelfId}, '{$date}', "
      . ($note === '' ? "NULL" : "'{$noteEsc}'")
      . ")";
    $db->query($sql);
    $created++;
  }
}

fclose($fh);
$session->msg('s', "Catalog import complete. Created: {$created}, Updated: {$updated}.");
redirect('catalog.php', false);
