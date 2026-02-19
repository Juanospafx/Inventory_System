<?php
class AuthService {
    public static function login(string $username, string $password): array {
        $user = UserData::getByUsername($username);
        if ($user && sha1(md5($password)) == $user->password) {
            session_regenerate_id(true);
            Session::setUID($user->id);
            $roles = UserData::getRolesByUserId($user->id);
            Session::setRoles($roles);
            if (empty($roles)) {
                Session::unsetUID();
                return [
                    'ok' => false,
                    'error' => 'No tienes permisos para acceder.',
                ];
            }
            return [
                'ok' => true,
                'user' => $user,
                'roles' => $roles,
            ];
        }
        return [
            'ok' => false,
            'error' => 'Usuario o contrasena incorrectos.',
        ];
    }

    public static function logout(): void {
        Session::unsetUID();
    }
}
?>
