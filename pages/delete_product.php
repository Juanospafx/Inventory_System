<?php
  require_once(__DIR__ . '/../includes/load.php');
  page_require_level(2);

  $product = find_by_id('products', (int)$_GET['id']);
  if (!$product) {
    $session->msg("d", "Missing ID.");
    redirect('product.php');  // Aseg??rate que el archivo exista
  }

  $delete_id = delete_by_id('products', (int)$product['id']);
  if ($delete_id) {
      $session->msg("s", "Product deleted.");
      redirect('product.php', false);
  } else {
      $session->msg("d", "Delete failed.");
      redirect('product.php', false);
  }
?>



