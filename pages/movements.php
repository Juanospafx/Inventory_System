<?php
$page_title = 'Input/output of items';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(3);

$movements = find_all_movements();

include_once(__DIR__ . '/../views/header.php');
?>

<!-- Campo de b??squeda para filtrado en el cliente -->

<div class="row" style="margin-bottom: 20px;">
  <div class="col-md-12">
    <input id="searchMovementsInput" type="text" class="form-control" placeholder="Filter by item, user, project, etc.">
  </div>
</div>

<!-- Contenido principal de la p??gina -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); // Mensajes de ??xito/error ?>
  </div>

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <a href="add_movement.php" class="btn btn-primary">Add Input/Output</a>
        </div>
      </div>

      <div class="panel-body">
        <div class="table-responsive">
          <table id="movementsTable" class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Name of item</th>
                <th class="text-center" style="width: 10%;">Quantity</th>
                <th class="text-center" style="width: 15%;">Users</th>
                <th class="text-center" style="width: 15%;">Date</th>
                <th class="text-center" style="width: 15%;">Project</th>
                <th class="text-center" style="width: 15%;">Note</th>
                <th class="text-center" style="width: 10%;">Type</th>
                <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($movements as $movement): ?>
                <tr>
                  <td class="text-center"><?php echo count_id(); ?></td>
                  <td><?php echo remove_junk($movement['product_name']); ?></td>
                  <td class="text-center"><?php echo (int) $movement['quantity']; ?></td>
                  <td class="text-center"><?php echo remove_junk($movement['user_name']); ?></td>
                  <td class="text-center"><?php echo read_date($movement['date']); ?></td>
                  <td class="text-center"><?php echo remove_junk($movement['project_name']); ?></td>
                  <td class="text-center"><?php echo remove_junk($movement['note']); ?></td>
                  <td class="text-center">
                    <?php
                    if ($movement['status'] == 1):
                      echo '<span class="label label-success">Input</span>';
                    elseif ($movement['status'] == 0):
                      echo '<span class="label label-danger">Output</span>';
                    elseif ($movement['status'] == 2):
                      echo '<span class="label label-info">Return</span>';
                    else:
                      echo '<span class="label label-default">Not defined</span>';
                    endif;
                    ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_movement.php?id=<?php echo (int) $movement['id']; ?>" class="btn btn-info btn-xs"
                        title="Editar" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-edit"></span>
                      </a>
                      <a href="delete_movement.php?id=<?php echo (int) $movement['id']; ?>" class="btn btn-danger btn-xs"
                        title="Eliminar" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div><!-- /.panel-body -->
    </div><!-- /.panel panel-default -->
  </div><!-- /.col-md-12 -->
</div><!-- /.row -->



<?php include_once(__DIR__ . '/../views/footer.php'); ?>
