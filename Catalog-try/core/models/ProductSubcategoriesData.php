<?php
class ProductSubcategoriesData {
    public static $tablename = "product_subcategories";

    public function __construct(){
        $this->post_id = "";
        $this->subcategory_id = "";
    }

    // Inserta la relación para un producto
    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (post_id, subcategory_id) ";
        $sql .= "VALUES (\"$this->post_id\", \"$this->subcategory_id\")";
        Executor::doit($sql);
    }

    // Actualiza la relación para un producto (asume que ya existe una relación)
    public function update(){
        $sql = "UPDATE ".self::$tablename." 
                SET subcategory_id = \"$this->subcategory_id\" 
                WHERE post_id = $this->post_id";
        Executor::doit($sql);
    }

    // Elimina la relación de subcategoría para un producto
    public static function deleteByPostId($post_id){
        $sql = "DELETE FROM ".self::$tablename." WHERE post_id = $post_id";
        Executor::doit($sql);
    }

    // Retorna la subcategoría asignada a un producto (si existe)
    public static function getByProductId($post_id){
        $sql = "SELECT s.* FROM ".self::$tablename." ps 
                JOIN subcategories s ON ps.subcategory_id = s.id 
                WHERE ps.post_id = $post_id LIMIT 1";
        $query = Executor::doit($sql);
        return Model::one($query[0], new SubcategoryData());
    }
}
?>
