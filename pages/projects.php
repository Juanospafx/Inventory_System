﻿<?php
$page_title = 'Projects';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../core/services/ProjectService.php');
// Checkin What level user has permission to view this page
page_require_level(1);

$all_projects = ProjectService::all();
  ?>
<?php
if (isset($_POST['add_project'])) {
  $req_field = array('project-name');
  validate_fields($req_field);
  $project_name = $_POST['project-name'] ?? '';
  if (empty($errors)) {
    if (ProjectService::create($project_name)) {
      $session->msg("s", "Project added successfully.");
      redirect('projects.php', false);
    } else {
      $session->msg("d", "Sorry, registration failed.");
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
</div>
<div class="row">
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa-solid fa-plus"></i>
          <span>Add Project</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="projects.php">
          <div class="mb-3">
            <input type="text" class="form-control" name="project-name" placeholder="Project name" required>
          </div>
          <button type="submit" name="add_project" class="btn btn-primary">Add Project</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa-solid fa-diagram-project"></i>
          <span>Projects List</span>
        </strong>
      </div>
      <div class="panel-body">
        <table id="projectTable" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Projects</th>
              <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_projects as $project): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><?php echo remove_junk(ucfirst($project['name'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_project.php?id=<?php echo (int) $project['id']; ?>" class="btn btn-xs btn-warning"
                      data-toggle="tooltip" title="Edit">
                      <i class="fa-solid fa-pencil"></i>
                    </a>
                    <a href="delete_project.php?id=<?php echo (int) $project['id']; ?>" class="btn btn-xs btn-danger"
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
</div>

<script>
  $(document).ready(function () {
    $("#projectSearch").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#projectTable tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
