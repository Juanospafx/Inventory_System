<?php

class ProductService
{
  public static function findByQrOrCode($qr_code)
  {
    if (strpos($qr_code, 'PROD-') === 0) {
      $product_id = intval(substr($qr_code, 5));
      return find_by_id('products', $product_id);
    }
    return find_by_qr_code($qr_code);
  }

  public static function findByLocation($location)
  {
    return find_products_by_location($location);
  }

  public static function searchByTitle($product_name)
  {
    return find_product_by_title($product_name);
  }
}

?>
