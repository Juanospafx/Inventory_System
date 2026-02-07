<?php
  require_once('includes/load.php');
  page_require_level(2);

  $product = find_by_id('products', (int)$_GET['id']);
  if (!$product) {
    $session->msg("d", "ID vacío");
    redirect('product.php');  // Asegúrate que el archivo exista
  }

  $delete_id = delete_by_id('products', (int)$product['id']);
  if ($delete_id) {
      $session->msg("s", "Producto eliminado");
      redirect('product.php', false);
  } else {
      $session->msg("d", "Eliminación falló");
      redirect('product.php', false);
  }
?>

