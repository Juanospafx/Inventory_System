<?php
$page_title = 'Edit Media';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

if (empty($_GET['id'])) {
    $session->msg('d', 'Missing Media ID.');
    redirect('media.php');
}

$media = find_by_id('media', (int)$_GET['id']);
if (!$media) {
    $session->msg('d', 'Media not found.');
    redirect('media.php');
}

if (isset($_POST['update_media'])) {
    $req_fields = array('media-description');
    validate_fields($req_fields);

    if (empty($errors)) {
        $description = remove_junk($db->escape($_POST['media-description']));
        $query = "UPDATE media SET description = '{$description}' WHERE id = '{$media['id']}'";
        if ($db->query($query)) {
            $session->msg('s', 'Media description updated successfully.');
            redirect('media.php');
        } else {
            $session->msg('d', 'Failed to update media description.');
            redirect('edit_media.php?id=' . (int)$media['id']);
        }
    } else {
        $session->msg('d', $errors);
        redirect('edit_media.php?id=' . (int)$media['id']);
    }
}

include_once(__DIR__ . '/../views/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-edit"></span>
                    <span>Edit Media Description</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="edit_media.php?id=<?php echo (int)$media['id']; ?>" method="post">
                    <div class="form-group">
                        <label for="media-description">Description</label>
                        <input type="text" class="form-control" name="media-description" value="<?php echo htmlspecialchars($media['description']); ?>">
                    </div>
                    <div class="form-group">
                        <img src="<?php echo base_url('uploads/products/' . $media['file_name']); ?>" class="img-thumbnail" />
                    </div>
                    <button type="submit" name="update_media" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>


