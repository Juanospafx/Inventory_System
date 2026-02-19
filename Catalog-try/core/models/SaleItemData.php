<?php
class SaleItemData {
    public static $tablename = "sale_items";

    public function __construct(){
        $this->id = null;
        $this->sale_id = null;
        $this->post_id = null;
        $this->quantity = 1;
        $this->code = "";
    }

    // ✅ Agregar un producto a una venta
    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (sale_id, post_id, quantity, code) VALUES (?, ?, ?, ?)";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiis", $this->sale_id, $this->post_id, $this->quantity, $this->code);
        
        return $stmt->execute();
    }

    // ✅ Crear un nuevo item de venta sin necesidad de instanciar el objeto
    public static function create($sale_id, $post_id, $quantity, $code) {
        $sql = "INSERT INTO " . self::$tablename . " (sale_id, post_id, quantity, code) VALUES (?, ?, ?, ?)";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiis", $sale_id, $post_id, $quantity, $code);
        
        return $stmt->execute();
    }

    // ✅ Obtener productos de una venta por ID de venta
    public static function getBySaleId($sale_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE sale_id = ?";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $sale_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_object("SaleItemData")) {
            $items[] = $row;
        }
        return $items;
    }
}
?>
