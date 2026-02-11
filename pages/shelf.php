<?php
$page_title = 'Depot';
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);

$all_shelves = find_all('shelves')
    ?>
<?php
if (isset($_POST['add_shelf'])) {
    $req_field = array('shelf-name');
    validate_fields($req_field);
    $shelf_name = remove_junk($db->escape($_POST['shelf-name']));
    if (empty($errors)) {
        $sql = "INSERT INTO shelves (name)";
        $sql .= " VALUES ('{$shelf_name}')";
        if ($db->query($sql)) {
            $session->msg("s", "Shelf added successfully.");
            redirect('shelf.php', false);
        } else {
            $session->msg("d", "Sorry, registration failed.");
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
</div>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add Shelf</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="shelf.php">
                    <div class="form-group">
                        <input type="text" class="form-control" name="shelf-name" placeholder="Shelf name"
                            required>
                    </div>
                    <button type="submit" name="add_shelf" class="btn btn-primary">Add Shelf</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Depot</span>
                </strong>
            </div>
            <div class="panel-body">
                <!-- Search Filter -->
                <div class="form-group">
                    <input type="text" id="shelfSearch" class="form-control" placeholder="Search Depot...">
                </div>
                <table id="shelfTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Depot</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_shelves as $shelf): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucfirst($shelf['name'])); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_shelf.php?id=<?php echo (int) $shelf['id']; ?>"
                                            class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="delete_shelf.php?id=<?php echo (int) $shelf['id']; ?>"
                                            class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>

