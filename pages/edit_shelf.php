<?php
$page_title = 'Edit shelf';
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
//Display all catgories.
$shelf = find_by_id('shelves', (int) $_GET['id']);
if (!$shelf) {
    $session->msg("d", "Missing shelf id.");
    redirect('shelf.php');
}
?>

<?php
if (isset($_POST['edit_shelf'])) {
    $req_field = array('shelf-name');
    validate_fields($req_field);
    $shelf_name = remove_junk($db->escape($_POST['shelf-name']));
    if (empty($errors)) {
        $sql = "UPDATE shelves SET name='{$shelf_name}'";
        $sql .= " WHERE id='{$shelf['id']}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg("s", "Anaquel actualizado con ??xito.");
            redirect('shelf.php', false);
        } else {
            $session->msg("d", "Lo siento, actualizaci??n fall??.");
            redirect('shelf.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('shelf.php', false);
    }
}
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editando <?php echo remove_junk(ucfirst($shelf['name'])); ?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_shelf.php?id=<?php echo (int) $shelf['id']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="shelf-name"
                            value="<?php echo remove_junk(ucfirst($shelf['name'])); ?>">
                    </div>
                    <button type="submit" name="edit_shelf" class="btn btn-primary">Actualizar anaquel</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once(__DIR__ . '/../views/footer.php'); ?>
