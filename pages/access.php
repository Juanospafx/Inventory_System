<?php
$page_title = 'Access Management';
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

$all_groups = find_all('user_groups');
$all_users = find_all_user();
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<!-- Groups Section -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <i class="fa-solid fa-layer-group"></i>
        <span>Groups</span>
     </strong>
       <a href="add_group.php" class="btn btn-primary float-end btn-sm"> Add group</a>
    </div>
     <div class="panel-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Group name</th>
            <th class="text-center" style="width: 20%;">Group level</th>
            <th class="text-center" style="width: 15%;">Status</th>
            <th class="text-center" style="width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach($all_groups as $a_group): ?>
          <tr>
           <td class="text-center"><?php echo $i++;?></td>
           <td><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
           <td class="text-center">
             <?php echo remove_junk(ucwords($a_group['group_level']))?>
           </td>
           <td class="text-center">
           <?php if($a_group['group_status'] === '1'): ?>
            <span class="label label-success"><?php echo "Active"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Inactive"; ?></span>
          <?php endif;?>
           </td>
           <td class="text-center">
             <div class="btn-group">
                <a href="edit_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="fa-solid fa-pencil"></i>
               </a>
                <a href="delete_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete">
                  <i class="fa-solid fa-trash-can"></i>
                </a>
                </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>

<!-- Users Section -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="fa-solid fa-users"></i>
          <span>Users</span>
        </strong>
        <a href="add_user.php" class="btn btn-primary float-end">Add users</a>
      </div>
      <div class="panel-body">
        <!-- Search Filter -->
        <div class="mb-3">
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
            <?php $j = 1; foreach ($all_users as $a_user): ?>
              <tr>
                <td class="text-center"><?php echo $j++; ?></td>
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
                      <i class="fa-solid fa-pencil"></i>
                    </a>
                    <a href="delete_user.php?id=<?php echo (int) $a_user['id']; ?>" class="btn btn-xs btn-danger"
                      data-toggle="tooltip" title="Delete">
                      <i class="fa-solid fa-trash-can"></i>
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