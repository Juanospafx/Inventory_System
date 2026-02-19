<?php
// Model.php
// @brief helper for model loading and hydration

class Model {

    public static function exists($modelname){
        $fullpath = self::getFullpath($modelname);
        return file_exists($fullpath);
    }

    public static function getFullpath($modelname){
        return __DIR__ . '/models/' . $modelname . '.php';
    }

    public static function many($query,$aclass){
        $cnt = 0;
        $array = array();
        while($r = $query->fetch_array()){
            $array[$cnt] = new $aclass;
            $cnt2=1;
            foreach ($r as $key => $v) {
                if($cnt2>0 && $cnt2%2==0){ 
                    $array[$cnt]->$key = $v;
                }
                $cnt2++;
            }
            $cnt++;
        }
        return $array;
    }

    public static function one($query,$aclass){
        $found = null;
        $data = new $aclass;
        while($r = $query->fetch_array()){
            $cnt=1;
            foreach ($r as $key => $v) {
                if($cnt>0 && $cnt%2==0){ 
                    $data->$key = $v;
                }
                $cnt++;
            }

            $found = $data;
            break;
        }
        return $found;
    }
}
?>
