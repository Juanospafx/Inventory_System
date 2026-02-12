﻿<?php
  $page_title = 'Images list';
  require_once(__DIR__ . '/../includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php $media_files = find_all('media');?>
<?php
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $photo->upload($_FILES['file_upload']);
    if($photo->process_media()){
        $session->msg('s','Image uploaded to the server.');
        redirect('media.php');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('media.php');
    }

  }

?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
     <div class="row">
        <div class="col-md-6">
          <?php echo display_msg($msg); ?>
        </div>

      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <i class="fa-solid fa-camera"></i>
            <span>Image list</span>
            <div class="float-end">
              <form class="d-flex align-items-center" action="media.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                  <input type="file" name="file_upload" multiple="multiple" class="form-control"/>
                  <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                </div>
             </form>
            </div>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Description</th>
                  <th class="text-center" style="width: 20%;">Type</th>
                  <th class="text-center" style="width: 50px;">Actions</th>
                </tr>
              </thead>
                <tbody>
                <?php foreach ($media_files as $media_file): ?>
                <tr class="list-inline">
                 <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center">
                      <img src="<?php echo base_url('uploads/products/' . $media_file['file_name']); ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" 
                           data-bs-toggle="modal" data-bs-target="#imagePreviewModal" 
                           data-img-url="<?php echo base_url('uploads/products/' . $media_file['file_name']); ?>" alt="Thumbnail">
                  </td>
                <td class="text-center">
                  <?php echo $media_file['description'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="edit_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-warning btn-xs"  title="Edit">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Delete">
                    <i class="fa-solid fa-trash-can"></i>
                  </a>
                </td>
               </tr>
              <?php endforeach;?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

<!-- Modal de Previsualización -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body text-center p-0">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <img id="modalImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 90vh;" alt="Full Preview">
      </div>
    </div>
  </div>
</div>

<script>
  const imageModal = document.getElementById('imagePreviewModal');
  imageModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const imageUrl = button.getAttribute('data-img-url');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
  });
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
