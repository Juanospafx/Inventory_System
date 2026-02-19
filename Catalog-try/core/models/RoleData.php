<?php
class RoleData {
    public static $tablename = "roles"; // Nombre de la tabla en la base de datos

    public function __construct() {
        $this->id = "";
        $this->name = "";
        $this->description = "";
    }

    // Obtener todos los roles
    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while ($r = $query[0]->fetch_array()) {
            $array[$cnt] = new RoleData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->description = $r['description'];
            $cnt++;
        }
        return $array;
    }

    // Obtener un rol por su ID
    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new RoleData();
        while ($r = $query[0]->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->description = $r['description'];
            $found = $data;
            break;
        }
        return $found;
    }
}
?>
