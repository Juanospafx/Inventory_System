<?php
// View.php
// @brief View loader for public/admin pages

class View {
    public static function load($view){
        $viewName = $view;
        if (isset($_GET['view']) && $_GET['view'] !== '') {
            $viewName = $_GET['view'];
        }
        $viewName = preg_replace('/[^a-z0-9\-]/i', '', $viewName);

        $area = (Core::$root === 'admin/') ? 'admin' : 'public';
        $root = dirname(__DIR__);
        $path = $root . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $area . DIRECTORY_SEPARATOR . $viewName . '.php';

        if (file_exists($path)) {
            include $path;
        } else {
            self::Error('<b>404 NOT FOUND</b> Page <b>' . htmlspecialchars($viewName) . '</b>');
        }
    }

    public static function isValid($view = null){
        $viewName = $view ?? ($_GET['view'] ?? '');
        if ($viewName === '') {
            return false;
        }
        $viewName = preg_replace('/[^a-z0-9\-]/i', '', $viewName);
        $area = (Core::$root === 'admin/') ? 'admin' : 'public';
        $root = dirname(__DIR__);
        $path = $root . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $area . DIRECTORY_SEPARATOR . $viewName . '.php';
        return file_exists($path);
    }

    public static function Error($message){
        print $message;
    }
}
?>
