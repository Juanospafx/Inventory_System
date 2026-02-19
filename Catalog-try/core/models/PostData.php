<?php
class PostData {
    public static $tablename = "post";

    public $id;
    public $title;
    public $content;
    public $image;
    public $link;
    public $category_id;
    public $is_public;
    public $is_featured;
    public $created_at;
    public $short_name;
    public $code;
    public $name;
    public $description;
    public $offer_txt;
    public $order_at;
    public $is_new;
    public $is_offer;
    public $in_existence;
    public $unit_id;

    public function __construct(){
        $this->title = "";
        $this->content = "";
        $this->image = "";
        $this->link = "";
        $this->category_id = null;
        $this->is_public = 0;
        $this->is_featured = 0;
        $this->created_at = "NOW()";
    }

    public function getUnit(){ return UnitData::getById($this->unit_id); }

    public function add(){
        $con = Database::getCon();
        $short_name  = $con->real_escape_string((string)$this->short_name);
        $code        = $con->real_escape_string((string)$this->code);
        $name        = $con->real_escape_string((string)$this->name);
        $description = $con->real_escape_string((string)$this->description);
        $image       = $con->real_escape_string((string)$this->image);
        $link        = $con->real_escape_string((string)$this->link);

        $category_id_sql = is_null($this->category_id) ? "NULL" : (int)$this->category_id;
        $is_public       = (int)$this->is_public;
        $is_featured     = (int)$this->is_featured;
        $created_at_sql  = $this->created_at;

        $sql  = "INSERT INTO ".self::$tablename." (short_name,code,name,description,image,link,category_id,is_public,is_featured,created_at) ";
        $sql .= "VALUES (\"$short_name\",\"$code\",\"$name\",\"$description\",\"$image\",\"$link\",$category_id_sql,$is_public,$is_featured,$created_at_sql)";
        Executor::doit($sql);
    }

    public static function delById($id){
        $id = (int)$id;
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public function del(){
        $id = (int)$this->id;
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public function update(){
        $con = Database::getCon();
        $code        = $con->real_escape_string((string)$this->code);
        $name        = $con->real_escape_string((string)$this->name);
        $description = $con->real_escape_string((string)$this->description);
        $link        = $con->real_escape_string((string)$this->link);

        $category_id_sql = is_null($this->category_id) ? "NULL" : (int)$this->category_id;
        $is_public       = (int)$this->is_public;
        $is_featured     = (int)$this->is_featured;
        $id              = (int)$this->id;

        $sql  = "UPDATE ".self::$tablename." SET ";
        $sql .= "code=\"$code\",name=\"$name\",description=\"$description\",link=\"$link\",is_public=$is_public,is_featured=$is_featured,category_id=$category_id_sql ";
        $sql .= "WHERE id=$id";
        Executor::doit($sql);
    }

    public function update_image(){
        $con = Database::getCon();
        $image = $con->real_escape_string((string)$this->image);
        $id = (int)$this->id;
        $sql = "UPDATE ".self::$tablename." SET image=\"$image\" WHERE id=$id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $id = (int)$id;
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new PostData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getPublicsByCategoryId($id){
        $id = (int)$id;
        $sql = "SELECT * FROM ".self::$tablename." WHERE category_id=$id AND is_public=1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function get4News(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE is_new=1 AND is_public=1 ORDER BY created_at DESC LIMIT 4";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function get4Offers(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE is_offer=1 AND is_public=1 ORDER BY created_at DESC LIMIT 4";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getNews(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE is_new=1 AND is_public=1 ORDER BY created_at DESC LIMIT 4";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getFeatureds(){
        $sql = "SELECT * FROM ".self::$tablename." WHERE is_featured=1 AND is_public=1 ORDER BY created_at DESC LIMIT 6";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getRelated($post_id, $limit=6){
        $post_id = (int)$post_id;
        $limit = (int)$limit;
        $sql = "SELECT p.* FROM ".self::$tablename." p
                INNER JOIN post_relations r ON p.id = r.related_id
                WHERE r.post_id = $post_id
                  AND p.is_public = 1
                LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getRelatedByCategory($current_id, $category_id, $limit=6){
        $current_id = (int)$current_id;
        $category_id = (int)$category_id;
        $limit = (int)$limit;
        $sql = "SELECT * FROM ".self::$tablename." 
                WHERE category_id = $category_id 
                  AND id != $current_id 
                  AND is_public = 1 
                ORDER BY created_at DESC 
                LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getRelatedBySubcategory($current_id, $subcategory_id, $limit = 6){
        $current_id = (int)$current_id;
        $subcategory_id = (int)$subcategory_id;
        $limit = (int)$limit;
        $sql = "SELECT p.* FROM ".self::$tablename." p
                INNER JOIN product_subcategories ps ON p.id = ps.post_id
                WHERE ps.subcategory_id = $subcategory_id
                  AND p.id != $current_id
                  AND p.is_public = 1
                ORDER BY p.created_at DESC
                LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getRelatedBySimilarity($current_id, $name, $limit=6){
        $current_id = (int)$current_id;
        $limit = (int)$limit;
        $tokens = explode(" ", $name);
        $tokens = array_map('trim', $tokens);

        $sql = "SELECT * FROM ".self::$tablename."
                WHERE id != $current_id
                  AND is_public = 1";

        $sql .= " AND (";
        $parts = array();
        foreach($tokens as $t){
            $t = mysqli_real_escape_string(Database::getCon(), $t);
            $parts[] = "name LIKE '%$t%' OR description LIKE '%$t%'";
        }
        $sql .= implode(" OR ", $parts) . ")";

        $sql .= " ORDER BY created_at DESC LIMIT $limit";

        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }

    public static function getLike($q){
        $con = Database::getCon();

        $q_raw = trim($q);
        $q = strtolower($q_raw);

        if (preg_match('/\b(\d+(\/\d+)?)(?=\s+(emt|conduit|pipe|tubo))/', $q, $matches)) {
            $measure = $matches[1];
            $q = preg_replace('/\b' . preg_quote($measure, '/') . '\b/', $measure . '"', $q, 1);
        }

        $q = preg_replace("/[^a-z0-9\/\"\s]/", " ", $q);
        $tokens = array_filter(explode(" ", $q));

        $relevance = [];
        $relevance[] = "CASE WHEN LOWER(name) = '".mysqli_real_escape_string($con, $q)."' THEN 100 ELSE 0 END";
        $relevance[] = "CASE WHEN LOWER(name) LIKE '%".mysqli_real_escape_string($con, $q)."%' THEN 50 ELSE 0 END";

        $firstTwo = implode(" ", array_slice($tokens, 0, 2));
        if (!empty($firstTwo)) {
            $relevance[] = "CASE WHEN LOWER(name) LIKE '".mysqli_real_escape_string($con, $firstTwo)."%' THEN 40 ELSE 0 END";
        }

        foreach ($tokens as $t) {
            $t = mysqli_real_escape_string($con, $t);
            $relevance[] = "CASE WHEN LOWER(name) LIKE '%$t%' THEN 10 ELSE 0 END";
            $relevance[] = "CASE WHEN LOWER(short_name) LIKE '%$t%' THEN 8 ELSE 0 END";
            $relevance[] = "CASE WHEN LOWER(code) LIKE '%$t%' THEN 6 ELSE 0 END";
            $relevance[] = "CASE WHEN LOWER(description) LIKE '%$t%' THEN 4 ELSE 0 END";
        }

        $sql = "SELECT *, (" . implode(" + ", $relevance) . ") AS relevance
                FROM ".self::$tablename."
                WHERE is_public = 1";

        foreach ($tokens as $t) {
            $t = mysqli_real_escape_string($con, $t);
            $sql .= " AND (
                LOWER(name) LIKE '%$t%' OR
                LOWER(description) LIKE '%$t%' OR
                LOWER(code) LIKE '%$t%' OR
                LOWER(short_name) LIKE '%$t%'
            )";
        }

        $sql .= " ORDER BY relevance DESC, created_at DESC";

        $query = Executor::doit($sql);
        return Model::many($query[0], new PostData());
    }
}
?>
