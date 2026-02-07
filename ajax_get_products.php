<?php
require_once('includes/load.php');

if (isset($_GET['location'])) {
    $location = remove_junk($db->escape($_GET['location']));
    $products = find_products_by_location($location);
    header('Content-Type: application/json');
    echo json_encode($products);
}
?>