<?php
require_once(__DIR__ . '/../includes/load.php');

echo "<h2>Verification Script</h2>";

// 1. Check Database Column
echo "<h3>1. Checking Database Column 'note' in 'products' table:</h3>";
$sql_check = "SHOW COLUMNS FROM products LIKE 'note'";
$result_check = $db->query($sql_check);
if ($db->num_rows($result_check) > 0) {
    echo "<p style='color: green;'>??? Column 'note' exists in 'products' table.</p>";
} else {
    echo "<p style='color: red;'>??? Column 'note' DOES NOT exist in 'products' table. Please run the database update.</p>";
}

// 2. Check PHP Function join_product_table
echo "<h3>2. Checking if 'join_product_table' returns 'note':</h3>";
$products = join_product_table();
if (!empty($products)) {
    $first_product = $products[0];
    if (array_key_exists('note', $first_product)) {
        echo "<p style='color: green;'>??? 'join_product_table' returns the 'note' field.</p>";
        echo "<p>Example note value: '" . ($first_product['note'] ?? 'NULL') . "'</p>";
    } else {
        echo "<p style='color: red;'>??? 'join_product_table' DOES NOT return the 'note' field. Please ensure you uploaded the updated 'includes/sql.php'.</p>";
    }
} else {
    echo "<p>No products found to check.</p>";
}

echo "<h3>Summary:</h3>";
echo "<p>If both checks are green and notes are still blank, please ensure you have actually added notes to your products using the 'Edit' button.</p>";
?>
