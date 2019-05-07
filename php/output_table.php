<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

require_once "./utils.php";

function output_table($data, $show_atcoder_id, $show_affiliation, $colorize_atcoder_id, $stripe_manually = false) {
    list($tbl_r, $tbl_c) = get_table_size($data);

    $header = ""; $table = "";
    
    if($tbl_r == 0) {
        $header .= <<<EOT
                <div class="alert alert-danger" role="alert">
                    <span class="fas fa-exclamation-triangle"></span> json ファイルが空です。
                </div>
EOT;
    }
    else {
        $header .= <<<EOT
<form role="form" id="export_pdf" action="./export_pdf.php" method="post" enctype="multipart/form-data" target="_blank">
<input id="export_pdf_btn" type="submit" class="btn btn-primary mb-3 btn-block" value="PDF をエクスポート">
</form>
EOT;

        $header .= <<<EOT
            <section>
                <div class="form" role="form" style="text-align:center;">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-primary btn-block mb-3" onClick="location.href='../index.php'">トップに戻る</button>
                        </div>
                    </div>
                </div>
            </section>
EOT;

        $table .= <<<EOT
<table class="table table-striped mb-3">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
EOT;

        /* header */
        for($i=1; $i<=$tbl_c; $i++) {
            $table .= "            <th scope=\"col\">Member " . (string)$i . "</th>";
        }

        $table .= <<<EOT
        </tr>
    </thead>
    <tbody>
EOT;

        /* body */
        for($i=0; $i<$tbl_r; $i++) {
            $option = "";
            if($stripe_manually and $i % 2 == 0) {
                $option = " style=\"background-color:#EEEEEE;\"";
            }
            
            $table .= "<tr" . $option . ">";
            $table .= "<td style=\"text-align:center;\">Team " . (string)($i+1) . "</td>";
            for($j=0; $j<$tbl_c; $j++) {
                $table .= "<td><div style=\"text-align:center;\">";
                if($j < count($data[$i])) {
                    $user = &$data[$i][$j];
                    
                    $handle = $user['handle'];
                    $atcoder_id = $user['user_name'];
                    $rating = $user['rating'];
                    $affiliation = $user['affiliation'];

                    $color_code = "#000000";
                    if($colorize_atcoder_id) {
                        $color_code = get_color_code($rating);
                    }

                    // handle (atcoder id)
                    $table .= $handle;
                    if($show_atcoder_id and $atcoder_id !== "") {
                        $table .= " (<span class=\"atcoder_user_name\" style=\"font-weight:bold;color:" . $color_code . ";\">" . $atcoder_id . "</span>)";
                    }

                    // affiliation
                    if($show_affiliation) {
                        $table .= "<br />";
                        // $table .= "<span style=\"font-size:14px;\">";
                        $table .= $affiliation;
                        // $table .= "</span>";
                    }
                }
                $table .= "</div></td>";
            }
            $table .= "</tr>";
        }

        $table .= <<<EOT
    </tbody>
    </table>
EOT;
    }

    return array($header, $table);
}

?>
