<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// 外部ファイルのインポート
require_once "./json2array.php";
require_once "./utils.php";
require_once "./output_table.php";
require_once "./reduce_table.php";
require_once "./get_html.php";

// セッション開始
session_start();

// HTML特殊文字をエスケープする関数
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

?>

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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <!-- javascript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/import_file.js"></script>
        <script type="text/javascript" src="../js/show_textfile.js"></script>
    </head>
    <body>
        <!-- main-container -->
        <div class="container" id="main-container">            
            <h1>TeamDivision2PDF</h1>

            <?php
            $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW);
            if(empty($token) or !hash_equals($token, $_SESSION['token'])) {
                echo <<<EOT
                <div class="alert alert-danger" role="alert">
                    <span class="fas fa-exclamation-triangle"></span> 不正なアクセスです。
                </div>
EOT;
            }
            else {
                $ignore_atcoder_id_list = preg_split("/\s+/", $_POST['ignore_atcoder_id']);
                $ignore_affiliation_list = preg_split("/\s+/", $_POST['ignore_affiliation']);
                
                $json_file = json2array($_FILES['json_file']);
                reduce_table($json_file, $ignore_atcoder_id_list, 'user_name');
                reduce_table($json_file, $ignore_affiliation_list, 'affiliation');
                
                $show_atcoder_id = get_boolean($_POST['show_atcoder_id']);
                $show_affiliation = get_boolean($_POST['show_affiliation']);
                $colorize_atcoder_id = get_boolean($_POST['colorize_atcoder_id']);
                
                list($header, $table) = output_table($json_file, $show_atcoder_id, $show_affiliation, $colorize_atcoder_id);
                echo($header);
                echo($table);

                $_SESSION['html'] = get_html($json_file, $show_atcoder_id, $show_affiliation, $colorize_atcoder_id);
            }
            ?>

            <section>
                <div class="form" role="form" style="text-align:center;">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-primary btn-block mb-3" onClick="location.href='../index.php'">トップに戻る</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
