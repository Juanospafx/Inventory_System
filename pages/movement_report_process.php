<?php
$page_title = 'Inputs/outputs Report';
require_once(__DIR__ . '/../includes/load.php');
// Verificar que el usuario tenga permiso para ver esta p??gina
page_require_level(3);

$results = [];
$start_date = '';
$end_date = '';

if (isset($_POST['submit'])) {
  $req_dates = array('start-date', 'end-date');
  validate_fields($req_dates);

  if (empty($errors)) {
    $start_date = remove_junk($db->escape($_POST['start-date']));
    $end_date = remove_junk($db->escape($_POST['end-date']));
    // Aseg??rate de que la funci??n find_movements_by_dates seleccione tambi??n la columna 'location'
    $results = find_movements_by_dates($start_date, $end_date);
  } else {
    $session->msg("d", "Date selection error.");
    redirect('movements_report.php', false);
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Report of Input/outputs</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <style>
    @media print {

      html,
      body {
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
      }

      .page-break {
        page-break-before: always;
        width: auto;
        margin: auto;
      }
    }

    .page-break {
      width: 980px;
      margin: 0 auto;
    }

    .sale-head {
      margin: 40px 0;
      text-align: center;
    }

    .sale-head h1,
    .sale-head strong {
      padding: 10px 20px;
      display: block;
    }

    .sale-head h1 {
      margin: 0;
      border-bottom: 1px solid #212121;
    }

    .table>thead:first-child>tr:first-child>th {
      border-top: 1px solid #000;
    }

    table thead tr th {
      text-align: center;
      border: 1px solid #ededed;
    }

    table tbody tr td {
      vertical-align: middle;
    }

    .sale-head,
    table.table thead tr th,
    table tbody tr td,
    table tfoot tr td {
      border: 1px solid #212121;
      white-space: nowrap;
    }

    .sale-head h1,
    table thead tr th,
    table tfoot tr td {
      background-color: #f8f8f8;
    }

    tfoot {
      color: #000;
      text-transform: uppercase;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <?php if (!empty($results)): ?>
    <div class="page-break">
      <div class="sale-head pull-right">
        <h1>Report of Inputs/outputs</h1>
        <strong><?php echo date("d/m/Y", strtotime($start_date)); ?> a
          <?php echo date("d/m/Y", strtotime($end_date)); ?></strong>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Item name</th>
            <th>Quantity</th>
            <th>Users</th>
            <th>Project</th> <!-- CAMBIADO DE LOCATION -->
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $result): ?>
            <?php
            // Ahora se comparan cadenas, ya que el CASE de la funci??n ya devuelve texto.
            if ($result['status'] == 'Input') {
              $status_label = 'success';
              $status_text = 'Input';
            } elseif ($result['status'] == 'Output') {
              $status_label = 'danger';
              $status_text = 'Output';
            } elseif ($result['status'] == 'Return') {
              $status_label = 'info';
              $status_text = 'Return';
            } else {
              $status_label = 'default';
              $status_text = 'No definido';
            }
            ?>
            <tr>
              <td><?php echo date("d/m/Y", strtotime($result['date'])); ?></td>
              <td><?php echo remove_junk(ucfirst($result['product_name'])); ?></td>
              <td class="text-right"><?php echo (int) $result['quantity']; ?></td>
              <td class="text-right"><?php echo remove_junk($result['user_name']); ?></td>
              <!-- Mostrar el proyecto -->
              <td class="text-center"><?php echo remove_junk($result['project_name']); ?></td>
              <!-- Tipo (Input/Output/Devoluci??n) con la etiqueta correspondiente -->
              <td class="text-center">
                <span class="label label-<?php echo $status_label; ?>">
                  <?php echo remove_junk($status_text); ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">
      <strong>No records were found between these dates.</strong>
    </div>
  <?php endif; ?>
</body>

</html>
<?php if (isset($db)) {
  $db->db_disconnect();
} ?>

