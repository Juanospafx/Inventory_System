<?php
$product = PostData::getById($_GET["product_id"]);
$url = "storage/products/$product->image";

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!-- Main Content -->

<div class="row">
  <div class="col-md-12">
    <!-- Button trigger modal -->
    <h2><?php echo e($product->name); ?> <small>Editar</small></h2>
    <?php if (isset($_SESSION["product_updated"])): ?>
      <p class="alert alert-info">
        <i class="fa fa-check"></i> Producto Actualizado Exitosamente
      </p>
      <?php unset($_SESSION["product_updated"]); ?>
    <?php endif; ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-pencil"></i> Editar Producto
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" enctype="multipart/form-data"
              method="post" action="api/legacy/admin/product-update.php">
          <div class="form-group">
            <label for="code" class="col-lg-2 control-label">Codigo</label>
            <div class="col-lg-2">
              <input type="text"
                     class="form-control"
                     id="code"
                     name="code"
                     value="<?php echo e($product->code); ?>"
                     placeholder="Codigo">
            </div>

            <label for="name" class="col-lg-2 control-label">Nombre</label>
            <div class="col-lg-6">
              <input type="text"
                     class="form-control"
                     id="name"
                     name="name"
                     value="<?php echo e($product->name); ?>"
                     placeholder="Nombre del producto">
            </div>
          </div>

          <div class="form-group">
            <label for="description" class="col-lg-2 control-label">Descripcion</label>
            <div class="col-lg-10">
              <textarea class="form-control"
                        id="description"
                        placeholder="Descripcion"
                        rows="6"
                        name="description"><?php echo e($product->description); ?></textarea>
            </div>
          </div>

          <?php if ($product->image != "" && file_exists($url)): ?>
            <img src="<?php echo e($url); ?>" class="img-responsive">
          <?php endif; ?>

          <br>

          <div class="form-group">
            <label for="image" class="col-lg-2 control-label">Imagen</label>
            <div class="col-lg-10">
              <input type="file" name="image" id="image">
            </div>
          </div>

          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-2">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_public"
                    <?php if ($product->is_public) { echo "checked"; } ?>>
                  Es Visible
                </label>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_featured"
                    <?php if ($product->is_featured) { echo "checked"; } ?>>
                  Producto destacado
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="category_id" class="col-lg-2 control-label">Categoria</label>
            <div class="col-lg-10">
              <?php
              $categories = CategoryData::getAll();
              if (count($categories) > 0):
              ?>
                <select name="category_id" id="category_id" class="form-control">
                  <option value="">-- SELECCIONE CATEGORIA --</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo (int)$cat->id; ?>"
                      <?php if ($product->category_id == $cat->id) { echo "selected"; } ?>>
                      <?php echo e($cat->name); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-6">
              <button type="submit" class="btn btn-success btn-block">
                Actualizar Producto
              </button>
            </div>
            <div class="col-lg-4">
              <button type="reset" class="btn btn-default btn-block">
                Limpiar Campos
              </button>
            </div>
          </div>

          <input type="hidden" name="id" value="<?php echo (int)$_GET["product_id"]; ?>">
        </form>
      </div>
    </div>
  </div>
</div>

<br><br>


