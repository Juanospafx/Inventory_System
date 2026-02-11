<?php
$page_title = 'Users list';
require_once(__DIR__ . '/../includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
page_require_level(1);
//pull out all user form database
$all_users = find_all_user();
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Users</span>
        </strong>
        <a href="add_user.php" class="btn btn-info pull-right">Add users</a>
      </div>
      <div class="panel-body">
        <!-- Search Filter -->
        <div class="form-group">
          <input type="text" id="userSearch" class="form-control" placeholder="Search User...">
        </div>
        <table id="userTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Name </th>
              <th>Users</th>
              <th class="text-center" style="width: 15%;">Users rol</th>
              <th class="text-center" style="width: 10%;">Status</th>
              <th style="width: 20%;">Last login</th>
              <th class="text-center" style="width: 100px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_users as $a_user): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><?php echo remove_junk(ucwords($a_user['name'])) ?></td>
                <td><?php echo remove_junk(ucwords($a_user['username'])) ?></td>
                <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])) ?></td>
                <td class="text-center">
                  <?php if ($a_user['status'] === '1'): ?>
                    <span class="label label-success"><?php echo "Active"; ?></span>
                  <?php else: ?>
                    <span class="label label-danger"><?php echo "Inactive"; ?></span>
                  <?php endif; ?>
                </td>
                <td><?php echo read_date($a_user['last_login']) ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_user.php?id=<?php echo (int) $a_user['id']; ?>" class="btn btn-xs btn-warning"
                      data-toggle="tooltip" title="Edit">
                      <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                    <a href="delete_user.php?id=<?php echo (int) $a_user['id']; ?>" class="btn btn-xs btn-danger"
                      data-toggle="tooltip" title="Delete">
                      <i class="glyphicon glyphicon-remove"></i>
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
<script>
  $(document).ready(function () {
    $("#userSearch").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#userTable tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>

