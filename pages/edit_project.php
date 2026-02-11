<?php
$page_title = 'Edit Projects';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../core/services/ProjectService.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
//Display all catgories.
$project = ProjectService::find((int) $_GET['id']);
if (!$project) {
  $session->msg("d", "Missing Project id.");
  redirect('projects.php');
}
?>

<?php
if (isset($_POST['edit_project'])) {
  $req_field = array('project-name');
  validate_fields($req_field);
  $project_name = $_POST['project-name'] ?? '';
  if (empty($errors)) {
    $result = ProjectService::update($project['id'], $project_name);
    if ($result) {
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

<?php include_once(__DIR__ . '/../views/footer.php'); ?>

