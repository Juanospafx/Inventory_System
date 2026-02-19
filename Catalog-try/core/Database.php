<?php
class Database {
    public static $db;
    public static $con;

    private $user;
    private $pass;
    private $host;
    private $ddbb;
    private $charset;

    public function __construct(){
        $config = require __DIR__ . '/config/database.php';
        $this->user = $config['user'] ?? '';
        $this->pass = $config['pass'] ?? '';
        $this->host = $config['host'] ?? 'localhost';
        $this->ddbb = $config['name'] ?? '';
        $this->charset = $config['charset'] ?? 'utf8mb4';
    }

    public function connect(){
        $con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb);
        if ($con->connect_error) {
            die('Database connection error: ' . $con->connect_error);
        }
        if (!empty($this->charset)) {
            $con->set_charset($this->charset);
        }
        return $con;
    }

    public static function getCon(){
        if (self::$con === null && self::$db === null) {
            self::$db = new Database();
            self::$con = self::$db->connect();
        }
        return self::$con;
    }
}
?>
