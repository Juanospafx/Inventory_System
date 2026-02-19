<?php 
$products = [];

if (isset($_GET['cat']) && !empty($_GET['cat'])) {
    $catx = CategoryData::getByPreffix($_GET['cat']);
    if ($catx) {
        $products = PostData::getPublicsByCategoryId($catx->id);
    }
} else if (isset($_GET['opt'])) {
    if ($_GET['opt'] == 'news') {
        $products = PostData::getNews();
    } else if ($_GET['opt'] == 'offers') {
        $products = PostData::getOffers();
    }
} else if (isset($_GET['act']) && $_GET['act'] == 'search') {
    $products = PostData::getLike($_GET['q']);
} else {
    $products = PostData::getAll();
}

$img_default = 'admin/storage/default.png';
?>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h1>Categorias</h1>
        <?php $cats = CategoryData::getPublics(); ?>
        <?php if (!empty($cats)): ?>
          <div class="list-group">
            <?php foreach ($cats as $cat): ?>
              <a href="index.php?view=products&cat=<?php echo htmlspecialchars($cat->short_name); ?>" class="list-group-item">
                <i class="fa fa-chevron-right"></i> <?php echo htmlspecialchars($cat->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-md-9">
        <h2 class="entry-title">
          <span>
            <?php 
            if (isset($_GET['act']) && $_GET['act'] == 'search') {
                echo 'Busqueda: ' . htmlspecialchars($_GET['q']); 
            } else if (isset($_GET['cat']) && isset($catx)) { 
                echo htmlspecialchars($catx->name); 
            } else { 
                echo 'Productos'; 
            }
            ?>
          </span>
        </h2>
        <br>

        <?php if (!empty($products)): ?>
          <div class="row">
            <?php 
            $count = 0;
            foreach ($products as $p): 
              $img = (!empty($p->image)) ? 'admin/storage/products/' . htmlspecialchars($p->image) : $img_default;
            ?>
              <div class="col-md-4 d-flex flex-column align-items-center text-center" style="margin-bottom: 20px; min-height: 250px;">
                <img src="<?php echo $img; ?>" style="width:120px; height:120px; object-fit: contain;">
                <h4 style="min-height: 50px;"><?php echo htmlspecialchars($p->name); ?></h4>
                <a href="index.php?view=product&product_id=<?php echo $p->id; ?>" class="btn btn-info mt-auto">Detalles</a>
              </div>

              <?php if (($count + 1) % 3 == 0): ?>
                <div class="clearfix"></div>
              <?php endif; ?>

              <?php $count++; ?>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="jumbotron text-center">
            <h2>No hay productos</h2>
            <p>No hay productos disponibles en este momento.</p>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
<br><br>
