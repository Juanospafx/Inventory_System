<?php
class SaleData {
    public static $tablename = "sales";

    public function __construct(){
        $this->id = null;
        $this->user_id = null;
        $this->status = "pending";
    }

    // ✅ Agregar una nueva venta y devolver su ID
    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (user_id, created_at, status) VALUES (?, NOW(), ?)";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("is", $this->user_id, $this->status);
        
        if ($stmt->execute()) {
            return $con->insert_id; // Devuelve el ID de la venta creada
        } else {
            return false; // Indica error
        }
    }

    // ✅ Obtener una venta por ID
    public static function getById($id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=?";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object("SaleData");
    }

    // ✅ Obtener todas las ventas
    public static function getAll(){
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC";
        $base = new Database();
        $con = $base->connect();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $sales = [];
        while ($row = $result->fetch_object("SaleData")) {
            $sales[] = $row;
        }
        return $sales;
    }
}
?>
