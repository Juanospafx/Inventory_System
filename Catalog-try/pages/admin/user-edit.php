<?php 
$user = UserData::getById($_GET["id"]); 
$roles = RoleData::getAll(); // Obtener roles disponibles
$userRoles = UserData::getRolesByUserId($user->id); // Obtener roles del usuario
?>

<div class="row">
    <div class="col-md-12">
        <h1>Editar Usuario</h1>
        <br>
        <form class="form-horizontal" method="post" id="edituser" action="api/legacy/admin/user-update.php" role="form">

            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Nombre*</label>
                <div class="col-md-6">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user->name); ?>" 
                           class="form-control" id="name" placeholder="Nombre" required>
                </div>
            </div>

            <div class="form-group">
                <label for="lastname" class="col-lg-2 control-label">Apellido*</label>
                <div class="col-md-6">
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($user->lastname); ?>" 
                           class="form-control" id="lastname" placeholder="Apellido" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Nombre de usuario*</label>
                <div class="col-md-6">
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user->username); ?>" 
                           class="form-control" id="username" placeholder="Nombre de usuario" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email*</label>
                <div class="col-md-6">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" 
                           class="form-control" id="email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Contrase??a</label>
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control" id="password" 
                           placeholder="Dejar en blanco para no cambiar">
                    <p class="help-block">La contrase??a solo se modificar?? si ingresas una nueva.</p>
                </div>
            </div>

            <!-- Activar/Desactivar usuario -->
            <div class="form-group">
                <label class="col-lg-2 control-label">Estado</label>
                <div class="col-md-6">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="is_active" <?php echo ($user->is_active) ? "checked" : ""; ?>> Activo
                    </label>
                </div>
            </div>

            <!-- Selecci??n de Roles -->
            <div class="form-group">
                <label class="col-lg-2 control-label">Roles*</label>
                <div class="col-md-6">
                    <select name="roles[]" class="form-control" multiple required>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role->id; ?>" 
                                    <?php echo (in_array($role->name, $userRoles)) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($role->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block">Puedes seleccionar m??ltiples roles usando CTRL + Click.</p>
                </div>
            </div>

            <p class="alert alert-info">* Campos obligatorios</p>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </div>
        </form>
    </div>
</div>


