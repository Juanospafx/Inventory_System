<?php
require_once(__DIR__ . '/../core/bootstrap.php');
require_once(__DIR__ . '/../core/services/ProductService.php');

// Manejar la bÃºsqueda de productos por cÃ³digo QR
if (isset($_GET['qr_code'])) {
    $qr_code = remove_junk($db->escape($_GET['qr_code']));
    $product = ProductService::findByQrOrCode($qr_code);

    if ($product) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($product);
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('error' => 'Product not found'));
    }
    return; // Terminar el script para evitar otros bloques
}

// Manejar la bÃºsqueda de productos por nombre
if (isset($_GET['product_name']) && strlen($_GET['product_name'])) {
    $product_name = remove_junk($db->escape($_GET['product_name']));
    $html = '';
    if ($results = ProductService::searchByTitle($product_name)) {
        foreach ($results as $result) {
            $html .= "<li>";
            $html .= "  <a href=\"#\">";
            $html .= "    <div class=\"pull-left\">";
            if ($result['media_id'] === '0') {
                $html .= "      <img class=\"img-avatar img-circle\" src=\"" . base_url('uploads/products/no_image.jpg') . "\" alt=\"\">";
            } else {
                $media = find_by_id('media', (int) $result['media_id']);
                $html .= "      <img class=\"img-avatar img-circle\" src=\"" . base_url('uploads/products/' . $media['file_name']) . "\" alt=\"\">";
            }
            $html .= "    </div>";
            $html .= "    <div class=\"body\">";
            $html .= "      <p class=\"text-muted\">" . $result['name'] . "</p>";
            $html .= "    </div>";
            $html .= "  </a>";
            $html .= "</li>";
        }
    } else {
        $html .= "<li><a href=\"#\">No products found</a></li>";
    }
    echo $html;
    return;
}

// Manejar la bÃºsqueda de productos por ubicaciÃ³n
if (isset($_GET['location']) && strlen($_GET['location'])) {
    $location = remove_junk($db->escape($_GET['location']));
    $products = ProductService::findByLocation($location);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($products);
    return;
}
?>

