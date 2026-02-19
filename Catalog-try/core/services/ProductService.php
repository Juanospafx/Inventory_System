<?php
class ProductService {
    private static function uploadDir(): string {
        return dirname(__DIR__, 2) . '/admin/storage/products/';
    }

    public static function createFromRequest(array $post, array $files): PostData {
        $product = new PostData();
        $product->code = isset($post['code']) ? trim((string)$post['code']) : '';
        $product->name = isset($post['name']) ? trim((string)$post['name']) : '';
        $product->description = isset($post['description']) ? trim((string)$post['description']) : '';
        $product->category_id = !empty($post['category_id']) ? (int)$post['category_id'] : null;
        $product->is_public = isset($post['is_public']) ? 1 : 0;
        $product->in_existence = isset($post['in_existence']) ? 1 : 0;
        $product->is_featured = isset($post['is_featured']) ? 1 : 0;

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-';
        $code = '';
        for ($i = 0; $i < 11; $i++) {
            $code .= $alphabet[rand(0, strlen($alphabet) - 1)];
        }
        $product->short_name = $code;

        if (isset($files['image']) && is_uploaded_file($files['image']['tmp_name'])) {
            $dir = self::uploadDir();
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $handle = new Upload($files['image']);
            if ($handle->uploaded) {
                $handle->Process($dir);
                $product->image = $handle->file_dst_name;
            }
        }

        $product->add();
        return $product;
    }

    public static function updateFromRequest(array $post, array $files): PostData {
        if (!isset($post['id'])) {
            throw new RuntimeException('ID de producto no enviado.');
        }
        $product = PostData::getById((int)$post['id']);
        if (!$product) {
            throw new RuntimeException('Producto no encontrado.');
        }

        $product->id = (int)$post['id'];
        $product->code = isset($post['code']) ? trim((string)$post['code']) : $product->code;
        $product->name = isset($post['name']) ? trim((string)$post['name']) : $product->name;
        $product->description = isset($post['description']) ? trim((string)$post['description']) : $product->description;
        $product->category_id = (isset($post['category_id']) && $post['category_id'] !== '') ? (int)$post['category_id'] : null;
        $product->is_public = isset($post['is_public']) ? 1 : 0;
        $product->is_featured = isset($post['is_featured']) ? 1 : 0;

        if (isset($files['image']) && is_uploaded_file($files['image']['tmp_name'])) {
            $dir = self::uploadDir();
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $handle = new Upload($files['image']);
            if ($handle->uploaded) {
                $handle->Process($dir);
                $product->image = $handle->file_dst_name;
                if (method_exists($product, 'update_image')) {
                    $product->update_image();
                }
            }
        }

        $product->update();
        return $product;
    }

    public static function deleteById(int $id): void {
        $product = PostData::getById($id);
        if ($product) {
            $product->del();
        }
    }
}
?>
