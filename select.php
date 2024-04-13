<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

// 検索キーワードの取得
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : '';

// SQL文の作成
if (!empty($keyword)) {
    $sql = "SELECT * FROM gs_an_table WHERE id LIKE :keyword OR filename LIKE :keyword OR buyername LIKE :keyword OR item LIKE :keyword OR deliverydate LIKE :keyword OR 
            inquirydate LIKE :keyword OR name LIKE :keyword OR naiyou LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', "%{$keyword}%", PDO::PARAM_STR); // バインドするキーワードに % を付けてあいまい検索を行う
    $stmt->execute();
} else {
    $sql = "SELECT * FROM gs_an_table";
    $stmt = $pdo->query($sql);
}

// データ表示
$view = "";
if ($stmt) {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . $r["id"] . '</td>';
        $view .= '<td>' . $r["filename"] . '</td>';
        $view .= '<td>' . $r["buyername"] . '</td>';
        $view .= '<td>' . $r["item"] . '</td>';
        $view .= '<td>' . $r["deliverydate"] . '</td>';
        $view .= '<td>' . $r["inquirydate"] . '</td>';
        $view .= '<td>' . $r["name"] . '</td>';
        $view .= '<td>' . $r["naiyou"] . '</td>';
        // 編集ボタン
        $view .= '<td><a class="btn btn-primary" href="detail.php?id=' . $r["id"] . '">編集</a></td>';
        // 削除ボタン
        $view .= '<td><a class="btn btn-danger" href="delete.php?id=' . $r["id"] . '">削除</a></td>';
        // タスク登録ボタン
        $view .= '<td><a class="btn btn-success" href="task.php?id=' . $r["id"] . '">タスク登録</a></td>';
        // タスクテンプレート登録ボタン
        $view .= '<td><a class="btn btn-success" href="task_bulkinsert.php?id=' . $r["id"] . '">タスクテンプレ登録</a></td>';
        // タスク表示ボタン
        $view .= '<td><a class="btn btn-success" href="task_select.php?id=' . $r["id"] . '">タスク表示</a></td>';

        // if ($_SESSION["kanri_flg"] == "1") {
        //     $view .= '<td><a class="btn btn-danger" href="delete.php?id=' . $r["id"] . '">[<i class="glyphicon glyphicon-remove"></i>削除]</a></td>';
        // }
        $view .= '</tr>';
    }
} else {
    sql_error($stmt);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>canaco案件一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

        /* 追加のスタイル */
        .wide-column {
            width: auto; /* 自動的に幅を調整するためにautoに変更 */
            white-space: nowrap; /* テキストが折り返されないように */
        }
        
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <?php include("menu.php"); ?>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <legend>案件一覧</legend>
    <!-- 検索フォーム -->
    <form action="select.php" method="get">
        <input type="text" id="keyword" name="keyword" placeholder="検索キーワードを入力" value="<?= $keyword ?>">
        <button type="submit">検索</button>
        <?php if (!empty($keyword)) : ?>
            <button type="button" onclick="clearSearch()">検索を解除</button>
        <?php endif; ?>
    </form>
    <div>
        <!-- <div class="container jumbotron"> -->
        <div class="container-fluid jumbotron">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="wide-column">ID</th>
                        <th class="wide-column">案件名</th>
                        <th class="wide-column">BUYER</th>
                        <th class="wide-column">アイテム</th>
                        <th class="wide-column">納期</th>
                        <th class="wide-column">見積依頼受領日</th>
                        <th class="wide-column">担当者</th>
                        <th class="wide-column">メモ</th>
                        <!-- <th>画像</th> -->
                        <th>action</th>
                        <!-- <?php if ($_SESSION["kanri_flg"] == "1") : ?>-->
                            <!--<th>削除</th> -->
                        <!-- <?php endif; ?> -->
                    </tr>
                </thead>
                <tbody>
                    <?= $view ?>
                </tbody>
            </table>
        </div>

    </div>
    <!-- Main[End] -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // 検索を解除する関数
        function clearSearch() {
            document.getElementById("keyword").value = "";
            document.querySelector("form").submit();
        }
    </script>
</body>

</html>