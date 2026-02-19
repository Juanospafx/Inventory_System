<?php
class CategoryService {
    public static function createFromRequest(array $post): CategoryData {
        $cat = new CategoryData();
        $cat->name = isset($post['name']) ? trim((string)$post['name']) : '';
        $cat->short_name = isset($post['short_name']) ? trim((string)$post['short_name']) : '';
        $cat->is_active = isset($post['is_active']) ? 1 : 0;
        $cat->add();
        return $cat;
    }

    public static function updateFromRequest(array $post): CategoryData {
        if (!isset($post['id'])) {
            throw new RuntimeException('ID de categoria no enviado.');
        }
        $cat = CategoryData::getById((int)$post['id']);
        if (!$cat) {
            throw new RuntimeException('Categoria no encontrada.');
        }
        $cat->id = (int)$post['id'];
        $cat->name = isset($post['name']) ? trim((string)$post['name']) : $cat->name;
        $cat->short_name = isset($post['short_name']) ? trim((string)$post['short_name']) : $cat->short_name;
        $cat->is_active = isset($post['is_active']) ? 1 : 0;
        $cat->update();
        return $cat;
    }

    public static function deleteById(int $id): void {
        $cat = CategoryData::getById($id);
        if ($cat) {
            $cat->del();
        }
    }
}
?>
