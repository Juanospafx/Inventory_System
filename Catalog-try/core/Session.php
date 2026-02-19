<?php

/**
 * Clase para manejo de sesiones de usuario
 * Incluye manejo de ID de usuario y roles.
 */

class Session {
    
    // ✅ Guardar el ID del usuario en la sesión
    public static function setUID($uid) {
        $_SESSION['user_id'] = $uid;
    }

    // ✅ Eliminar el ID de usuario de la sesión
    public static function unsetUID() {
        unset($_SESSION['user_id']);
        unset($_SESSION['roles']); // También eliminamos roles
    }

    // ✅ Verificar si hay un usuario autenticado
    public static function issetUID() {
        return isset($_SESSION['user_id']);
    }

    // ✅ Obtener el ID del usuario autenticado
    public static function getUID() {
        return $_SESSION['user_id'] ?? false;
    }

    // ✅ Guardar roles en la sesión
    public static function setRoles($roles) {
        $_SESSION['roles'] = $roles;
    }

    // ✅ Obtener los roles del usuario
    public static function getRoles() {
        return $_SESSION['roles'] ?? [];
    }

    // ✅ Verificar si el usuario tiene un rol específico
    public static function hasRole($role) {
        return in_array($role, self::getRoles());
    }
}

?>
