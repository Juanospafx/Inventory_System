<?php
// Widget.php
// @brief helper widgets

class Widget {

    public static function getPostsWidget(){
        $ret = "";
        $posts = PostData::getAll();
        foreach($posts as $p){
            $ret .= "<li><i class='fa fa-file-text-o'></i> <a href='./?view=product&product_id=".$p->id."'>".$p->title."</a></li>";
        }
        return $ret;
    }

    public static function getCommentsWidget(){
        $ret = "";
        $posts = PostData::getAll();
        foreach($posts as $p){
            $px = PostData::getById($p->id);
            $ret .= "<li><i class='fa fa-comment'></i> $p->content por <b>$p->name</b> en <a href='./?view=product&product_id=".$p->id."'>".$px->title."</a></li>";
        }
        return $ret;
    }
}
?>
