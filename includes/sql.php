<?php
require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table));
  }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);

  // Si la consulta falla, mostramos el error (mejor que pantalla en blanco)
  if ($result === false) {
    die("Error en la consulta SQL: " . $db->error . " | Query: " . $sql);
  }

  // Si no es un SELECT, $result será true (bool), devolvemos un array vacío
  if ($result === true) {
    return [];
  }

  // Para SELECT sí tenemos un resultset
  $result_set = $result->fetch_all(MYSQLI_ASSOC);
  return $result_set ?: []; // Retorna un array vacío si no hay filas
}

/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table, $id)
{
  global $db;
  $id = (int) $id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table, $id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE id=" . $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table)
{
  global $db;
  if (tableExists($table)) {
    $sql = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table)
{
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $db->escape($table) . '"');
  if ($table_exit) {
    if ($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login form.
/*--------------------------------------------------------------*/
function authenticate($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password']) {
      return $user['id'];
    }
  }
  return false;
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login_v2.php form.
/* If you used this method then remove authenticate function.
/*--------------------------------------------------------------*/
function authenticate_v2($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password']) {
      return $user;
    }
  }
  return false;
}

/*--------------------------------------------------------------*/
/* Find current log in user by session id
/*--------------------------------------------------------------*/
function current_user()
{
  static $current_user;
  global $db;
  if (!$current_user) {
    if (isset($_SESSION['user_id'])):
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id('users', $user_id);
    endif;
  }
  return $current_user;
}
/*--------------------------------------------------------------*/
/* Find all user by
/* Joining users table and user gropus table
/*--------------------------------------------------------------*/
function find_all_user()
{
  global $db;
  $results = array();
  $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
  $sql .= "g.group_name ";
  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN user_groups g ";
  $sql .= "ON g.group_level=u.user_level ORDER BY u.name ASC";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------*/
/* Function to update the last log in of a user
/*--------------------------------------------------------------*/

function updateLastLogIn($user_id)
{
  global $db;
  $date = make_date();
  $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

// ... (resto de tu sql.php sigue igual, no hace falta tocarlo)


/*--------------------------------------------------------------*/
/* Find all Group name
/*--------------------------------------------------------------*/
function find_by_groupName($val)
{
  global $db;
  $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------------------------------------*/
/* Find group level
/*--------------------------------------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  $sql = "SELECT * FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->fetch_assoc($result));
}
/*--------------------------------------------------------------*/
/* Function for cheaking which user level has access to page
/*--------------------------------------------------------------*/
function page_require_level($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //if user not login
  if (!$session->isUserLoggedIn()):
    $session->msg('d', 'Por favor Iniciar sesión...');
    redirect('index.php', false);
    //if Group status Deactive
  elseif (isset($login_level['group_status']) && $login_level['group_status'] === '0'):
    $session->msg('d', 'Este nivel de usaurio esta inactivo!');
    redirect('home.php', false);
    //cheackin log in User level and Require level is Less than or equal to
  elseif ($current_user['user_level'] <= (int) $require_level):
    return true;
  else:
    $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
    redirect('home.php', false);
  endif;

}
/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* JOIN with categorie  and media database table
/*--------------------------------------------------------------*/
function join_product_table($name = '')
{
  global $db;

  // Consulta base
  $sql = "SELECT p.id, p.name, p.quantity, p.shelf_id, p.date, p.qr_code, p.note, ";
  $sql .= "c.name AS shelf, ";
  $sql .= "m.file_name AS image, p.media_id ";
  $sql .= "FROM products p ";
  $sql .= "LEFT JOIN shelves c ON p.shelf_id = c.id ";
  $sql .= "LEFT JOIN media m ON p.media_id = m.id ";

  // Arreglo para condiciones WHERE
  $conditions = [];

  // Filtrado por nombre
  if (!empty($name)) {
    $conditions[] = "p.name LIKE '%" . $db->escape($name) . "%'";
  }

  // Si existen condiciones, agregamos el WHERE
  if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
  }

  // Ordenar por nombre
  $sql .= " ORDER BY p.name";

  // Devolver resultados
  return find_by_sql($sql);
}



/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* Request coming from ajax.php for auto suggest
/*--------------------------------------------------------------*/

function find_product_by_title($product_name)
{
  global $db;
  $p_name = remove_junk($db->escape($product_name));
  $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
}


/*--------------------------------------------------------------*/
/* Function for Finding all product info by product title
/* Request coming from ajax.php
/*--------------------------------------------------------------*/
function find_all_product_info_by_title($title)
{
  global $db;

  // Escapar la variable para evitar inyección SQL
  $title = $db->escape($title);

  // Búsqueda exacta:
  $sql = "SELECT * FROM products ";
  $sql .= "WHERE name = '{$title}' ";
  $sql .= "LIMIT 1";

  // Si prefieres una búsqueda parcial, puedes usar:
  // $sql  = "SELECT * FROM products WHERE name LIKE '%{$title}%' LIMIT 1";

  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Update product quantity
/*--------------------------------------------------------------*/
function update_product_qty($qty, $p_id, $status)
{
  global $db;
  $qty = (int) $qty;
  $id = (int) $p_id;

  if ($status === 1 || $status === 2) {
    // Entrada y Devolución: se suman items al stock
    $sql = "UPDATE products SET quantity = quantity + '{$qty}' WHERE id = '{$id}'";
  } elseif ($status === 0) {
    // Salida: se restan items del stock
    $sql = "UPDATE products SET quantity = quantity - '{$qty}' WHERE id = '{$id}'";
  } else {
    return false; // Estado no válido
  }

  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}




/*--------------------------------------------------------------*/
/* Function for Display Recent product Added
/*--------------------------------------------------------------*/
function find_recent_product_added($limit)
{
  global $db;
  $sql = " SELECT p.id,p.name, p.media_id,c.name AS shelf,";
  $sql .= "m.file_name AS image FROM products p";
  $sql .= " LEFT JOIN shelves c ON c.id = p.shelf_id";
  $sql .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql .= " ORDER BY p.id DESC LIMIT " . $db->escape((int) $limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Find Highest moving Product
/*--------------------------------------------------------------*/
function find_highest_moving_product($limit)
{
  global $db;
  $sql = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.quantity) AS totalQty";
  $sql .= " FROM movements s";
  $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
  $sql .= " GROUP BY s.product_id";
  $sql .= " ORDER BY SUM(s.quantity) DESC LIMIT " . $db->escape((int) $limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for find all movements
/*--------------------------------------------------------------*/
function find_all_movements($product_name = '', $user_name = '', $note = '')
{
  global $db;

  $sql = "SELECT s.id, s.quantity, s.date, s.status, s.note, ";
  $sql .= "p.name AS product_name, ";
  $sql .= "u.name AS user_name, ";
  $sql .= "IFNULL(b.name, 'Sin proyecto asignado') AS project_name ";
  $sql .= "FROM movements s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id ";
  $sql .= "LEFT JOIN users u ON s.user_id = u.id ";
  $sql .= "LEFT JOIN projects b ON s.project_id = b.id ";

  $conditions = array();

  // Filtrado por nombre del producto
  if (!empty($product_name)) {
    $conditions[] = "p.name LIKE '%" . $db->escape($product_name) . "%'";
  }

  // Filtrado por nombre del usuario
  if (!empty($user_name)) {
    $conditions[] = "u.name LIKE '%" . $db->escape($user_name) . "%'";
  }

  // Filtrado por nota
  if (!empty($note)) {
    $conditions[] = "s.note LIKE '%" . $db->escape($note) . "%'";
  }

  // Si existen condiciones, se agregan al WHERE
  if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
  }

  // Ordenar por fecha de forma descendente
  $sql .= " ORDER BY s.date DESC";

  return find_by_sql($sql);
}


/*--------------------------------------------------------------*/
/* Function for Display Recent movement
/*--------------------------------------------------------------*/
function find_recent_movements($limit)
{
  global $db;

  $sql = "SELECT s.id, s.date, p.name AS product_name, ";
  $sql .= "CASE s.status ";
  $sql .= "WHEN 1 THEN 'Input' ";
  $sql .= "WHEN 0 THEN 'Output' ";
  $sql .= "WHEN 2 THEN 'Return' ";
  $sql .= "ELSE 'Desconocido' END AS status ";
  $sql .= "FROM movements s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id ";
  $sql .= "ORDER BY s.date DESC LIMIT " . (int) $limit;

  return find_by_sql($sql) ?: []; // Evita errores si no hay registros
}


/*--------------------------------------------------------------*/
/* Function for Generate movements report by two dates
/*--------------------------------------------------------------*/
// Ejemplo de cómo luciría tu query en find_movements_by_dates()
function find_movements_by_dates($start_date, $end_date)
{
  global $db;
  $sql = "SELECT s.date, p.name AS product_name, s.quantity, u.name AS user_name, ";
  $sql .= "CASE s.status ";
  $sql .= "WHEN 1 THEN 'Input' ";
  $sql .= "WHEN 0 THEN 'Output' ";
  $sql .= "WHEN 2 THEN 'Return' ";
  $sql .= "ELSE 'Desconocido' END AS status, ";
  $sql .= "s.note, IFNULL(pr.name, 'Sin proyecto asignado') AS project_name ";
  $sql .= "FROM movements s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id ";
  $sql .= "LEFT JOIN users u ON s.user_id = u.id ";
  $sql .= "LEFT JOIN projects pr ON s.project_id = pr.id ";
  $sql .= "WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}' ";
  $sql .= "ORDER BY s.date ASC";
  return find_by_sql($sql);
}





/*--------------------------------------------------------------*/
/* Function for Generate Daily movements report
/*--------------------------------------------------------------*/
function daily_movements($year, $month)
{
  global $db;

  $sql = "SELECT s.id, s.date, p.name AS product_name, s.quantity, ";
  $sql .= "CASE s.status ";
  $sql .= "WHEN 1 THEN 'Input' ";
  $sql .= "WHEN 0 THEN 'Output' ";
  $sql .= "WHEN 2 THEN 'Return' ";
  $sql .= "ELSE 'Desconocido' END AS status ";
  $sql .= "FROM movements s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id ";
  $sql .= "WHERE YEAR(s.date) = '{$year}' AND MONTH(s.date) = '{$month}' ";
  $sql .= "ORDER BY s.date DESC";

  $movements = find_by_sql($sql);
  return $movements ?: []; // Retorna un array vacío si no hay resultados
}

/*--------------------------------------------------------------*/
/* Function for Generate Monthly movements report
/*--------------------------------------------------------------*/
function monthly_movements($year)
{
  global $db;

  $sql = "SELECT s.id, s.date, p.name AS product_name, s.quantity, ";
  $sql .= "CASE s.status ";
  $sql .= "WHEN 1 THEN 'Input' ";
  $sql .= "WHEN 0 THEN 'Output' ";
  $sql .= "WHEN 2 THEN 'Return' ";
  $sql .= "ELSE 'Desconocido' END AS status ";
  $sql .= "FROM movements s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id ";
  $sql .= "WHERE YEAR(s.date) = '{$year}' ";
  $sql .= "ORDER BY s.date DESC";

  $movements = find_by_sql($sql);
  return $movements ?: []; // Retorna un array vacío si no hay resultados
}

