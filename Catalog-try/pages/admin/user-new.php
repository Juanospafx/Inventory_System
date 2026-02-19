<div class="row">
    <div class="col-md-12">
        <h1>Agregar Usuario</h1>
        <br>
        <form class="form-horizontal" method="post" id="adduser" action="api/legacy/admin/user-add.php" role="form">

            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Nombre*</label>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required>
                </div>
            </div>

            <div class="form-group">
                <label for="lastname" class="col-lg-2 control-label">Apellido*</label>
                <div class="col-md-6">
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Nombre de usuario*</label>
                <div class="col-md-6">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Nombre de usuario" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email*</label>
                <div class="col-md-6">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Contrase??a*</label>
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Contrase??a" required>
                </div>
            </div>

            <!-- Selecci??n de Roles -->
            <div class="form-group">
                <label for="roles" class="col-lg-2 control-label">Roles*</label>
                <div class="col-md-6">
                    <select name="roles[]" class="form-control" multiple required>
                        <?php
                        $roles = RoleData::getAll();
                        foreach ($roles as $role) {
                            echo "<option value='{$role->id}'>{$role->name}</option>";
                        }
                        ?>
                    </select>
                    <p class="help-block">Puedes seleccionar m??ltiples roles manteniendo presionada la tecla Ctrl (Windows) o Cmd (Mac).</p>
                </div>
            </div>

            <p class="alert alert-info">* Campos obligatorios</p>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </div>
            </div>

        </form>
    </div>
</div>


