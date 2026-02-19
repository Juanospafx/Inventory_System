<?php
include "../../core/autoload.php"; // Ajusta si tienes otro bootstrap central

header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if($q != ""){
    $posts = PostData::getLike($q);

    foreach($posts as $p){
        $results[] = [
            "id" => $p->id,
            "name" => $p->name,
            "image" => !empty($p->image) ? "admin/storage/products/" . $p->image : "res/images/no-image.png",
            "url" => "index.php?view=post&product_id=" . $p->id
        ];
    }
}

echo json_encode($results);
?>
