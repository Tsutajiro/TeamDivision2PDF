<?php

// レートに対応するカラーコードを出す
function get_color_code($rating) {
    if($rating ==   0) return "#000000";
    if($rating <  400) return "#808080";
    if($rating <  800) return "#804000";
    if($rating < 1200) return "#008000";
    if($rating < 1600) return "#00C0C0";
    if($rating < 2000) return "#0000FF";
    if($rating < 2400) return "#C0C000";
    if($rating < 2800) return "#FF8000";
    return "#FF0000";
}

// デバッグ出力に使う
function var_dump_echo($var) {
    echo("<pre>");
    var_dump($var);
    echo("</pre>");
}

function get_table_size($table) {
    $tbl_r = count($table);
    $tbl_c = 0;

    for($i=0; $i<$tbl_r; $i++) {
        $tbl_c = max($tbl_c, count($table[$i]));
    }
    
    return array($tbl_r, $tbl_c);
}

function get_boolean($str) {
    if($str === "0") return false;
    if($str === "1") return true;
    return false;
}

?>