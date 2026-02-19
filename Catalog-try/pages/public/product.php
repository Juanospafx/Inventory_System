<?php
$p = PostData::getById($_GET['product_id']);

if (!$p) {
    echo "<script>alert('Producto no encontrado.'); window.location='index.php';</script>";
    exit;
}
$default_img = 'res/img/default.png';
?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h1>Category</h1>
        <?php
        $cats = CategoryData::getPublics();
        if (count($cats) > 0): ?>
          <div class="list-group">
            <?php foreach($cats as $cat): ?>
              <a href="index.php?view=products&cat=<?php echo htmlspecialchars($cat->short_name); ?>" class="list-group-item">
                <i class="fa fa-chevron-right"></i> <?php echo htmlspecialchars($cat->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-md-9">
        <h2 class="entry-title"><span><?php echo htmlspecialchars($p->name); ?></span></h2>
        <br>
        <?php if ($p != null):
          $img = "admin/storage/products/" . $p->image;
          if ($p->image == ""){
            $img = $default_img;
          }
        ?>
          <div class="row">
            <div class="col-md-12 text-center">
              <img src="<?php echo htmlspecialchars($img); ?>" 
                   class="img-responsive" 
                   style="width:120px; height:120px; object-fit: contain; margin: 0 auto;">
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-md-12">
              <hr>
              <h4>Part Code: <?php echo htmlspecialchars($p->code); ?></h4>
              <p><?php echo htmlspecialchars($p->description); ?></p>

              <form action="api/legacy/cart-add.php" method="get">
                <input type="hidden" name="product_id" value="<?php echo $p->id; ?>">
                <input type="hidden" name="redirect_product_id" value="<?php echo $p->id; ?>">
                
                <div class="form-group row" style="margin-bottom:10px;">
                  <label for="quantity" class="col-sm-3 col-form-label">Quantity:</label>
                  <div class="col-sm-9">
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="max-width:100px;" id="quantity">
                  </div>
                </div>
                
                <div class="form-group row" style="margin-bottom:10px;">
                  <label for="unit" class="col-sm-3 col-form-label">Measure Type:</label>
                  <div class="col-sm-9">
                    <select name="unit" id="unit" class="form-control" style="max-width:120px;">
                      <option value="ea">ea</option>
                      <option value="ft">ft</option>
                      <option value="inch">Inch</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row" style="margin-bottom:10px;">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-success btn-block">
                      <i class="fa fa-shopping-cart"></i> Add to cart
                    </button>
                  </div>
                  <div class="col-sm-6">
                    <a href="index.php?view=cart" class="btn btn-primary btn-block">
                      <i class="fa fa-shopping-bag"></i> Show Cart
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<br>

<?php 
$subcat = ProductSubcategoriesData::getByProductId($p->id);
if ($subcat) {
    $related_items = PostData::getRelatedBySubcategory($p->id, $subcat->id, 6);
} else {
    $related_items = PostData::getRelatedByCategory($p->id, $p->category_id, 6);
}
?>
<?php if (!empty($related_items)): ?>
  <section style="margin-top:40px;">
    <div class="container">
      <h3>Related Products</h3>
      <form action="api/legacy/cart-add.php" method="get" onsubmit="return checkSelected();">
        <input type="hidden" name="redirect_product_id" value="<?php echo $p->id; ?>">

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php foreach ($related_items as $r):
            $r_img = (!empty($r->image))
              ? "admin/storage/products/" . htmlspecialchars($r->image)
              : $default_img;
          ?>
            <div class="col">
              <div class="card h-100" style="position: relative; border:1px solid #ddd; padding:10px; overflow:visible;">
                <img src="<?php echo $r_img; ?>"
                     class="card-img-top img-fluid"
                     style="object-fit:contain; max-height:120px;"
                     alt="<?php echo htmlspecialchars($r->name); ?>">

                <input type="checkbox" 
                       name="items[<?php echo $r->id; ?>][selected]" 
                       value="1"
                       class="related-checkbox">

                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo htmlspecialchars($r->name); ?></h5>
                  <p class="card-text"><?php echo substr(htmlspecialchars($r->description), 0, 100); ?>...</p>

                  <input type="hidden" name="items[<?php echo $r->id; ?>][post_id]"
                         value="<?php echo $r->id; ?>">

                  <div class="mb-2">
                    <label style="font-size:13px;">Qty:</label>
                    <input type="number"
                           name="items[<?php echo $r->id; ?>][quantity]"
                           value="1"
                           min="1"
                           class="form-control"
                           style="max-width:80px; display:inline-block;">
                  </div>
                  <div class="mb-2">
                    <label style="font-size:13px;">Unit:</label>
                    <select name="items[<?php echo $r->id; ?>][unit]"
                            class="form-select"
                            style="max-width:80px; display:inline-block;">
                      <option value="ea">ea</option>
                      <option value="ft">ft</option>
                      <option value="inch">Inch</option>
                    </select>
                  </div>
                  <a href="index.php?view=product&product_id=<?php echo $r->id; ?>"
                     class="btn btn-link btn-sm">View Detail</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="row mt-4">
          <div class="col text-center">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-shopping-cart"></i> Add Selected to Cart
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
<?php endif; ?>

<script>
  function checkSelected(){
    var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="items"]:checked');
    if(checkboxes.length === 0){
      alert('Please select at least one product to add to cart.');
      return false;
    }
    return true;
  }
</script>
