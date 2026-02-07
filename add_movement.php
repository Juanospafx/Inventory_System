<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$page_title = 'Add inputs/outputs';
require_once('includes/load.php');
// Verifica el nivel de usuario
page_require_level(3);

// Listado de productos
$all_products = find_all('products');
// Listado de usuarios (si lo requieres)
$all_users = find_all('users');
$all_projects = find_all('projects');

if (isset($_POST['add_movement'])) {
  // Se requieren estos campos
  $req_fields = array('product_id', 'quantity', 'status', 'date');
  validate_fields($req_fields);

  if (empty($errors)) {
    // Recoger y convertir datos
    $p_id = (int) $db->escape($_POST['product_id']);
    $s_qty = (int) $db->escape($_POST['quantity']);
    $s_status = (int) $db->escape($_POST['status']); // 1: Entrada, 0: Salida, 2: Devolución

    // Si es admin y se seleccionó un usuario para Salida/Retorno, usar ese. Si no, el actual.
    $current_user = current_user();
    if ($current_user['user_level'] == 1 && ($s_status === 0 || $s_status === 2) && !empty($_POST['user_id'])) {
      $user_id = (int) $_POST['user_id'];
    } else {
      $user_id = (int) $_SESSION['user_id'];
    }
    $p_project = (!empty($_POST['project_id'])) ? (int) $db->escape($_POST['project_id']) : NULL;
    $s_date = (!empty($_POST['date'])) ? date("Y-m-d", strtotime($_POST['date'])) : make_date();
    $s_note = $db->escape($_POST['note']);

    // Validaciones según el tipo de movimiento
    if ($s_status === 0) { // Salida
      // Verificar que no se retire más de lo que hay en stock
      $sql_check_stock = "SELECT quantity FROM products WHERE id = '{$p_id}' LIMIT 1";
      $result_stock = $db->query($sql_check_stock);
      $product_stock = $db->fetch_assoc($result_stock);
      if ($s_qty > (int) $product_stock['quantity']) {
        $_SESSION['form_data'] = $_POST;
        $session->msg('d', "Error: You cannot withdraw more than what is in stock. Available stock: " . $product_stock['quantity']);
        redirect('add_movement.php', false);
      }
    } elseif ($s_status === 2) { // Devolución
      $sql_borrowed = "SELECT 
                              IFNULL(SUM(CASE WHEN status = 0 THEN quantity ELSE 0 END),0) as total_output,
                              IFNULL(SUM(CASE WHEN status = 2 THEN quantity ELSE 0 END),0) as total_return
                           FROM movements
                           WHERE product_id = '{$p_id}' AND user_id = '{$user_id}'";
      $result_borrowed = $db->query($sql_borrowed);
      $borrowed_data = $db->fetch_assoc($result_borrowed);
      $total_salida = (int) $borrowed_data['total_output'];
      $total_devolucion = (int) $borrowed_data['total_return'];
      $max_devolucion = $total_salida - $total_devolucion;

      if ($s_qty > $max_devolucion) {
        $_SESSION['form_data'] = $_POST;
        $session->msg('d', "Error: You cannot return more items than you took out. Maximum allowed: " . $max_devolucion);
        redirect('add_movement.php', false);
      }
    }

    // Insertar el registro de movimiento
    $sql = "INSERT INTO movements (product_id, quantity, user_id, project_id, status, date, note) VALUES 
              ('{$p_id}', '{$s_qty}', '{$user_id}', " . ($p_project ? "'{$p_project}'" : "NULL") . ", '{$s_status}', '{$s_date}', '{$s_note}')";
    if ($db->query($sql)) {
      update_product_qty($s_qty, $p_id, $s_status);
      $session->msg('s', "Added inventory movement.");
      redirect('add_movement.php', false);
    } else {
      $_SESSION['form_data'] = $_POST;
      $session->msg('d', 'Sorry, registration failed.');
      redirect('add_movement.php', false);
    }
  } else {
    $_SESSION['form_data'] = $_POST;
    $session->msg("d", $errors);
    redirect('add_movement.php', false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>

<?php
// Recuperar datos del formulario almacenados en sesión (si existen) y luego limpiarlos
$form_data = array();
if (isset($_SESSION['form_data'])) {
  $form_data = $_SESSION['form_data'];
  unset($_SESSION['form_data']);
}
?>

<!-- Agrega la librería html5-qrcode -->
<script src="https://unpkg.com/html5-qrcode"></script>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add input/output/Return</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="add_movement.php" class="clearfix">
            <!-- Fila para QR Code y selección de producto -->
            <div class="form-group">
              <div class="row">
                <!-- Campo de código QR -->
                <div class="col-md-6">
                  <label for="qr_code">QR Code (optional)</label>
                  <input type="text" id="qr_code" name="qr_code" class="form-control"
                    placeholder="Scan QR code or enter manually">
                  <small class="form-text text-muted">Scan a QR code to automatically fill in the product
                    information.</small>
                </div>
                <!-- Botón para iniciar el escaneo -->
                <div class="col-md-6">
                  <label>&nbsp;</label>
                  <button id="start-scan" type="button" class="btn btn-info btn-block">Scan QR Code</button>
                </div>
              </div>
            </div>

            <!-- Contenedor para mostrar la cámara al escanear -->
            <div class="form-group" id="scanner-container" style="display:none;">
              <div id="reader" style="width:100%; max-width:400px; margin: 0 auto;"></div>
            </div>

            <!-- Producto y Proyecto -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="product_id">Select item</label>
                  <select class="form-control select2" name="product_id" id="product_id" required>
                    <option value="">Select an item</option>
                    <?php foreach ($all_products as $product): ?>
                      <option value="<?php echo (int) $product['id']; ?>">
                        <?php echo $product['name']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="project_id">Select Project (Optional for Inputs)</label>
                  <select class="form-control select2" name="project_id" id="project_id">
                    <option value="">Sin proyecto asignado</option>
                    <?php foreach ($all_projects as $project): ?>
                      <option value="<?php echo (int) $project['id']; ?>">
                        <?php echo $project['name']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <!-- Cantidad -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" name="quantity" placeholder="Cantidad" required
                    value="<?php echo isset($form_data['quantity']) ? htmlspecialchars($form_data['quantity']) : ''; ?>">
                </div>
                <!-- Estado -->
                <div class="col-md-6">
                  <label for="status">Status</label>
                  <select class="form-control" name="status" id="status" required onchange="toggleUserSelection()">
                    <option value="">Select a Status</option>
                    <option value="1" <?php echo (isset($form_data['status']) && $form_data['status'] == 1) ? 'selected' : ''; ?>>Input</option>
                    <option value="0" <?php echo (isset($form_data['status']) && $form_data['status'] == 0) ? 'selected' : ''; ?>>Output</option>
                    <option value="2" <?php echo (isset($form_data['status']) && $form_data['status'] == 2) ? 'selected' : ''; ?>>Return</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Selección de Usuario (Solo para Admin y Salida/Retorno) -->
            <?php $user_level = current_user()['user_level']; ?>
            <div class="form-group" id="user_selection_group"
              style="display: <?php echo ($user_level == 1 && isset($form_data['status']) && ($form_data['status'] == 0 || $form_data['status'] == 2)) ? 'block' : 'none'; ?>;">
              <div class="row">
                <div class="col-md-6">
                  <label for="user_id">Select User (Admin only)</label>
                  <select class="form-control select2" name="user_id" id="user_id">
                    <option value="">Current User</option>
                    <?php foreach ($all_users as $user): ?>
                      <option value="<?php echo (int) $user['id']; ?>" <?php echo (isset($form_data['user_id']) && $form_data['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <!-- Fecha y Ubicación -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" name="date"
                    value="<?php echo isset($form_data['date']) ? htmlspecialchars($form_data['date']) : ''; ?>">
                </div>
                <div class="col-md-6">
                  <label for="note">Note</label>
                  <textarea class="form-control" name="note"
                    placeholder="Optional note"><?php echo isset($form_data['note']) ? htmlspecialchars($form_data['note']) : ''; ?></textarea>
                </div>
              </div>
            </div>

            <button type="submit" name="add_movement" class="btn btn-danger">Add movement</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script para iniciar el escaneo con html5-qrcode -->
<script>
  function toggleUserSelection() {
    const status = document.getElementById('status').value;
    const userGroup = document.getElementById('user_selection_group');
    const userLevel = <?php echo (int) current_user()['user_level']; ?>;

    if (userLevel === 1 && (status === '0' || status === '2')) {
      userGroup.style.display = 'block';
    } else {
      userGroup.style.display = 'none';
    }
  }
  document.getElementById('start-scan').addEventListener('click', function () {
    // Mostrar el contenedor del escáner
    document.getElementById('scanner-container').style.display = 'block';
    const html5QrCode = new Html5Qrcode("reader");
    const config = { fps: 10, qrbox: 250 };

    html5QrCode.start(
      { facingMode: "environment" },
      config,
      (decodedText, decodedResult) => {
        // Cuando se detecta el código, asignarlo al input de qr_code
        console.log("QR Code detected: " + decodedText);
        document.getElementById('qr_code').value = decodedText;
        // Detener el escáner y ocultar el contenedor
        html5QrCode.stop().then(() => {
          document.getElementById('scanner-container').style.display = 'none';
          // Rellenar automáticamente el producto
          var qr_code = document.getElementById('qr_code').value;
          if (qr_code) {
            fetch('ajax.php?qr_code=' + qr_code)
              .then(response => response.json())
              .then(data => {
                if (data && !data.error) {
                  document.getElementById('product_id').value = data.id;
                  document.getElementsByName('quantity')[0].value = 1;
                  document.getElementsByName('status')[0].value = 0;
                  toggleUserSelection();
                } else {
                  alert('Product not found for QR code: ' + qr_code);
                }
              })
              .catch(err => {
                console.error("Error fetching product data: " + err);
                alert('Error retrieving product information.');
              });
          }
        }).catch(err => {
          console.error("Error stopping scanner: " + err);
        });
      },
      errorMessage => {
        // Opcional: maneja errores en la lectura (por ejemplo, mostrar un mensaje en consola)
        // console.log("Scanning error: " + errorMessage);
      }
    ).catch(err => {
      console.error("Error starting scanner: " + err);
      alert('Error starting the camera. Please check permissions.');
    });
  });

  // Script para buscar producto por código QR al cambiar el input manualmente
  document.getElementById('qr_code').addEventListener('change', function () {
    var qr_code = this.value;
    var productSelect = document.getElementById('product_id');

    if (qr_code) {
      fetch('ajax.php?qr_code=' + qr_code)
        .then(response => response.json())
        .then(data => {
          if (data && !data.error) {
            productSelect.value = data.id;
            // Also default to output and trigger user selection if admin
            document.getElementsByName('status')[0].value = 0;
            toggleUserSelection();
          } else {
            alert('Product not found for QR code: ' + qr_code);
          }
        })
        .catch(err => {
          console.error("Error fetching product data: " + err);
          alert('Error retrieving product information.');
        });
    }
  });
</script>

<?php include_once('layouts/footer.php'); ?>