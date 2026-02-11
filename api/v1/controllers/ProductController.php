<?php

require_once(__DIR__ . '/../../../core/services/ProductService.php');

class ProductController
{
  public static function find($params)
  {
    if (!empty($params['qr_code'])) {
      $product = ProductService::findByQrOrCode($params['qr_code']);
      if ($product) {
        json_ok($product);
      }
      json_error('not_found', 'Product not found.', null, 404);
    }

    if (!empty($params['location'])) {
      $products = ProductService::findByLocation($params['location']);
      json_ok($products);
    }

    json_error('validation_error', 'Provide qr_code or location.');
  }
}

?>

