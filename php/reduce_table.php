<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

function reduce_table(&$data, $ignore_list, $chg_element) {
    for($i=0; $i<count($data); $i++) {
        for($j=0; $j<count($data[$i]); $j++) {
            $user = &$data[$i][$j];

            // 要素が存在すれば FALSE にはならない
            if(array_search($user['handle'], $ignore_list) !== false) {
                if($user[$chg_element] === "") continue;
                $user[$chg_element] = "***";
                if($chg_element == 'user_name') {
                    $user['rating'] = 0;
                }
            }
        }
    }
}

?>
