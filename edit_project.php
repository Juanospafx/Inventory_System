<?php
$page_title = 'Edit Projects';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
//Display all catgories.
$project = find_by_id('projects', (int) $_GET['id']);
if (!$project) {
  $session->msg("d", "Missing Project id.");
  redirect('projects.php');
}
?>

<?php
if (isset($_POST['edit_project'])) {
  $req_field = array('project-name');
  validate_fields($req_field);
  $project_name = remove_junk($db->escape($_POST['project-name']));
  if (empty($errors)) {
    $sql = "UPDATE projects SET name='{$project_name}'";
    $sql .= " WHERE id='{$project['id']}'";
    $result = $db->query($sql);
    if ($result && $db->affected_rows() === 1) {
      $session->msg("s", "Project updated successfully.");
      redirect('projects.php', false);
    } else {
      $session->msg("d", "Sorry, update failed.");
      redirect('projects.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('projects.php', false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Edit <?php echo remove_junk(ucfirst($project['name'])); ?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_project.php?id=<?php echo (int) $project['id']; ?>">
          <div class="form-group">
            <input type="text" class="form-control" name="project-name"
              value="<?php echo remove_junk(ucfirst($project['name'])); ?>">
          </div>
          <button type="submit" name="edit_project" class="btn btn-primary">Update Project</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>