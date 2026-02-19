<!-- Main Content -->

<div class="row">
  <div class="col-md-12">

    <h2>Publicaciones</h2>
    <a href="index.php?view=newproduct" class="btn btn-default">Agregar Producto</a>

    <!-- Buscador -->
    <div class="form-group" style="margin-top:15px;">
      <input type="text" id="buscadorPublicaciones" class="form-control" placeholder="Buscar publicaci??n...">
    </div>

  </div>
</div>

<br>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-th-list"></i> Publicaciones
      </div>
      <div class="widget-body medium no-padding">
        <?php
        $categories = PostData::getAll();
        if(count($categories) > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered" id="tablaPublicaciones">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Visible</th>
                  <th>Destacado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($categories as $cat): ?>
                  <tr>
                    <td><?php echo $cat->code; ?></td>
                    <td><?php echo $cat->name; ?></td>
                    <td><?php echo $cat->category_id; ?></td>
                    <td style="width:90px;">
                      <center>
                        <?php if($cat->is_public): ?>
                          <i class="fa fa-check"></i>
                        <?php else: ?>
                          <i class="fa fa-remove"></i>
                        <?php endif; ?>
                      </center>
                    </td>
                    <td style="width:90px;">
                      <center>
                        <?php if($cat->is_featured): ?>
                          <i class="fa fa-check"></i>
                        <?php else: ?>
                          <i class="fa fa-remove"></i>
                        <?php endif; ?>
                      </center>
                    </td>
                    <td style="width:185px;">
                      <a href="../index.php?view=product&product_id=<?php echo $cat->id; ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-link"></i></a>
                      <a href="index.php?view=editproduct&product_id=<?php echo $cat->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                      <a href="api/legacy/admin/product-delete.php&product_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="panel-body">
            <p class="alert alert-warning">No hay Publicaciones, puedes empezar agregando tu lista de Publicaciones.</p>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<!-- Script de b??squeda -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('buscadorPublicaciones');
  var table = document.getElementById('tablaPublicaciones');
  var filas = table.getElementsByTagName('tr');

  input.addEventListener('keyup', function () {
    var filtro = this.value.toLowerCase();

    // Recorremos todas las filas del tbody (saltando el thead)
    for (var i = 1; i < filas.length; i++) {
      var fila = filas[i];
      var textoFila = fila.textContent.toLowerCase();

      if (textoFila.indexOf(filtro) > -1) {
        fila.style.display = '';
      } else {
        fila.style.display = 'none';
      }
    }
  });
});
</script>



