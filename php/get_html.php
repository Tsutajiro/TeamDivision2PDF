<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// 外部ファイルのインポート
require_once "./output_table.php";

function get_html($json_file, $show_atcoder_id, $show_affiliation, $colorize_atcoder_id) {
    $header = <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <title>TeamDivision2PDF</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="競技プログラミング">
        <meta name="description" content="Competitive Programming Team Maker のチーム分け出力を整形して表示・PDF に保存するアプリケーションです。">
        <meta name="author" content="tsutaj">
        <meta http-equiv="content-language" content="ja">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="../lib/main.css">

        <!-- fonts -->
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet"> 
    </head>
    <body>

        <!-- main-container -->
        <div class="container" id="main-container">
EOT;

    $css = <<<EOT
<style>
.atcoder_user_name {
    font-family: 'Lato', sans-serif;
}

th {
    text-align: center;
}

td {
    font-size: 12px;
}
</style>
EOT;
    
    list($_, $main_contents) = output_table($json_file, $show_atcoder_id, $show_affiliation, $colorize_atcoder_id, true);

    $footer = <<<EOT
</div>
</body>
</html>
EOT;

    $html = $css . $main_contents;
    return $html;
}

?>
