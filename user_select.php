<?php
session_start();

//1.外部ファイル読み込み＆DB接続
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
//include "../../includes/funcs.php";
include "funcs.php";
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    ?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>USER表示</title>
        <link rel="stylesheet" href="css/range.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            div {
                padding: 10px;
                font-size: 16px;
            }
        </style>
    </head>

    <body id="main">
        <!-- Head[Start] -->
        <header>
            <!-- <?php echo $_SESSION["name"]; ?>さん　 -->
            <?php include("menu.php"); ?>
        </header>
        <!-- Head[End] -->

        <!-- Main[Start] -->
        <div class="container jumbotron">
            <h1>ユーザー一覧</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>ログインID</th>
                        <th>権限</th>
                        <th>アクション</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$result['name']}</td>";
                        echo "<td>{$result['lid']}</td>";
                        echo "<td>" . ($result['kanri_flg'] == 1 ? '管理者' : '一般') . "</td>";
                        echo "<td><a href='user_delete.php?id={$result['id']}'>削除</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Main[End] -->

    </body>

    </html>
    <?php
    // ２回目のループのために$stmtを再実行する
    $stmt->execute();
}
?>