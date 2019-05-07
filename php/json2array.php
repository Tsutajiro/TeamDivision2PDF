<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// json を連想配列に変換 (単一ファイルを想定)
function json2array($json_file) {
    // なにもない
    if(!isset($json_file["tmp_name"])) {
        return array();
    }
    
    if(is_uploaded_file($json_file["tmp_name"])) {
        // JSON が SJIS だとうくちゃん
        // ref: https://www.marineroad.com/staff-blog/12831.html
        $unknown_encoding_data = file_get_contents($json_file["tmp_name"]);
        if($unknown_encoding_data === false) {
            return array();
        }
        
        $utf8_data = mb_convert_encoding($unknown_encoding_data, "UTF-8", "auto");
        $json_array = json_decode($utf8_data, true);
        
        return $json_array;
    }

    return array();
}

?>