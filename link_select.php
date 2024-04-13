<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

// 検索キーワードまたはIDの取得
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : '';

// SQL文の作成
if (!empty($keyword)) {
    // もしキーワードが数字の場合はID検索、そうでない場合はキーワード検索として扱う
    if (is_numeric($keyword)) {
        $sql = "SELECT * FROM gs_link_table WHERE id = :id";
    } else {
        $sql = "SELECT * FROM gs_link_table WHERE id LIKE :keyword OR title LIKE :keyword OR link LIKE :keyword OR memo LIKE :keyword";
    }
    $stmt = $pdo->prepare($sql);
    if (is_numeric($keyword)) {
        $stmt->bindValue(':id', $keyword, PDO::PARAM_INT);
    } else {
        $stmt->bindValue(':keyword', "%{$keyword}%", PDO::PARAM_STR); // バインドするキーワードに % を付けてあいまい検索を行う
    }
    $stmt->execute();
} else {
    $sql = "SELECT * FROM gs_link_table";
    $stmt = $pdo->query($sql);
}

// データ表示
$view = "";
if ($stmt) {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . $r["id"] . '</td>';
        $view .= '<td>' . $r["title"] . '</td>';
        $view .= '<td><a href="' . $r["link"] . '">' . $r["link"] . '</a></td>';
        $view .= '<td>' . $r["memo"] . '</td>';
        // 編集ボタン
        $view .= '<td><a class="btn btn-primary" href="link_detail.php?id=' . $r["id"] . '">編集</a></td>';
        // 削除ボタン
        $view .= '<td><a class="btn btn-danger" href="link_delete.php?id=' . $r["id"] . '">削除</a></td>';

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
    <title>マニュアル、システムリンク一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>

        div {
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

        .wide-column {
            width: auto;
            max-width: 20%;
            white-space: normal;
            word-wrap: break-word;
        }

        .container-fluid.jumbotron {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }


    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <?php include("menu.php"); ?>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <legend>マニュアル、システムリンク一覧</legend>
    <!-- 検索フォーム -->
    <form action="link_select.php" method="get">
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
                        <th class="wide-column">タイトル</th>
                        <th class="wide-column">リンク</th>
                        <th class="wide-column">メモ</th>
                        <th>action</th>
                        <?php if ($_SESSION["kanri_flg"] == "1") : ?>
                            <th>削除</th>
                        <?php endif; ?>
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