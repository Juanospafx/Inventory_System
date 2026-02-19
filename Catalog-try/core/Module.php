<?php
// Module.php
// @brief layout selection for public/admin

class Module {
    public static function loadLayout(){
        $root = dirname(__DIR__);
        if (Core::$root === 'admin/') {
            include $root . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'admin.php';
        } else {
            include $root . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'public.php';
        }
    }
}
?>
