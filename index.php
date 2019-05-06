<?php

// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// セッション開始
session_start();

// HTML特殊文字をエスケープする関数
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// トークンの作成
if(!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// このトークンが $_SESSION のものと一致してなければ
// maker.php に直接アクセスして悪さされる可能性が・・・
$token = $_SESSION['token'];

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
        <link rel="stylesheet" href="./lib/main.css">

        <!-- fonts -->
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <!-- javascript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type="text/javascript" src="./js/import_file.js"></script>
        <script type="text/javascript" src="./js/show_textfile.js"></script>
    </head>
    <body>
        <!-- main-container -->
        <div class="container" id="main-container">
            <h1>TeamDivision2PDF</h1>

            <!-- introduction -->
            <div class="card">
                <div class="card-header">
                    <span class="far fa-file-pdf"></span> チーム分け結果を整形して PDF 出力
                </div>
                <div class="card-body">
                    これは <a href="https://compro.tsutajiro.com/cp-teammaker/">Competitive Programming Team Maker</a> で生成されたチーム分けを、整形して PDF に出力するためのアプリケーションです。AtCoder ID や所属を外部に公開したくない方に配慮し、所望のフォーマットで結果を出力します。
                </div>
            </div>
            <!-- introduction end -->

            <!-- form section -->
            <form role="form" id="main_form" action="./php/make_table.php" method="post" enctype="multipart/form-data">                
                <!-- import json file -->
                <h3><span class="fas fa-table"></span> チーム分け結果をインポート</h3>

                <p class="my-2">チーム分け結果をあらわす json ファイルを読み込みます。</p>

                <!-- json file import form -->
                <div id="json_import_section">
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary">
                                ファイルを選択<input type="file" name="json_file" accept="application/json" style="display:none">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                </div>

                <!-- import json file end -->

                <!-- ignore list: Team ID, AtCoder ID, Affiliation -->
                <h3><span class="fas fa-times-circle"></span> 出力時に無視する項目の設定</h3>

                <p class="my-2">表の出力時に無視する項目を設定します。Team ID, AtCoder ID, Affiliation それぞれに対して、出力時に表示してほしくない人の <span style="font-weight:bold;">ハンドルネーム</span> を改行区切りで指定してください。テキストファイルを読み込むことも可能です。</p>

                <!-- ignore contents section -->
                <div id="ignore_section">
                    <div id="ignore_team_id_section">
                        <h4 class="mt-3"><span class="fas fa-list-ul"></span> Team ID を無視する人の一覧</h4>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    ファイルを選択<input type="file" name="ignore_team_id_file" accept="application/json" style="display:none">
                                </span>
                            </label>
                            <textarea name="ignore_team_id"></textarea>
                        </div>
                    </div>

                    <div id="ignore_atcoder_id_section">
                        <h4 class="mt-3"><span class="fas fa-list-ul"></span> AtCoder ID を無視する人の一覧</h4>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    ファイルを選択<input type="file" name="ignore_atcoder_id_file" accept="application/json" style="display:none">
                                </span>
                            </label>
                            <textarea name="ignore_atcoder_id"></textarea>
                        </div>
                    </div>

                    <div id="ignore_affiliation_section">
                        <h4 class="mt-3"><span class="fas fa-list-ul"></span> 所属を無視する人の一覧</h4>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    ファイルを選択<input type="file" name="ignore_affiliation_file" accept="application/json" style="display:none">
                                </span>
                            </label>
                            <textarea name="ignore_affiliation"></textarea>
                        </div>
                    </div>
                </div>
                <!-- ignore contents section end -->

                <!-- option -->
                <h3><span class="fas fa-cog"></span> オプション</h3>
                <div id="option_section">
                    <p class="my-2">Team ID, AtCoder ID, 所属のそれぞれについて表に表示させるかを選択します。選択しなかった場合は、その項目が全員について非表示になります。</p>

                    <p class="my-2">AtCoder ID について、レートに応じた色をつけるかどうかを選択します。</p>
                </div>
                <!-- option end -->

                <!-- submit form (to PDF) -->
                <input id="run_pdf_making_btn" type="submit" name="send" class="btn btn-primary mb-3 mt-4 btn-block" value="表の作成を実行">
                <!-- submit form (to PDF) end -->
            </form>
            <!-- form section end -->
        </div>
        
        <!-- bootstrap (head で読み込もうとしたらダメだった、ふしぎ) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdoZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <!-- bootstrap end -->
    </body>
</html>
    
