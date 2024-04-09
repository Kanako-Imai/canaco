<?php
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include "funcs.php";
sschk();
$pdo = db_conn();

// データベースに接続が成功したことを確認
if (!$pdo) {
    echo "データベースに接続できませんでした。";
    exit;
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_task_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ更新</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
    <style>
        label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <style>
        textarea {
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            resize: vertical;
        }
    </style>
</head>

<body>

    <!-- Head[Start] -->
    <?php include("menu.php"); ?>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="task_update.php">
    <div class="jumbotron">
        <fieldset>
            <legend>[タスク編集]</legend>
            <label>タスク名：</label>
            <input type="text" name="title" value="<?= $row['title'] ?>"><br>
            <label>イベント：</label>
            <input type="text" name="taskevent" value="<?= $row['taskevent'] ?>"><br>
            <label>担当者: </label>
            <input type="text" name="assignee" value="<?= $row['assignee'] ?>"><br>
            <label>内容：</label>
            <input type="text" name="box" value="<?= $row['box'] ?>"><br>
            <label>期限：</label>
            <input type="date" min="2024-01-01" max="2050-12-31" name="duedate" value="<?= $row['duedate'] ?>"><br>
            <label>メモ</label>
            <textArea name="memo" rows="4" cols="40"><?= $row['memo'] ?></textArea><br>
            <label>完了/未完了：</label>
            <input type="radio" name="completed" value="1"> 完了
            <input type="radio" name="completed" value="0" checked> 未完了<br>
            <!-- fk_file_idを隠しフィールドとして追加 -->
            <input type="hidden" name="fk_file_id" value="<?= $row['fk_file_id'] ?>">
            <!-- idを隠しフィールドとして追加 -->
            <input type="hidden" name="id" value="<?= $id ?>">
            <!-- 送信ボタン -->
            <input type="submit" value="送信">
        </fieldset>
    </div>
</form>
    <!-- Main[End] -->

</body>

</html>