<?php
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_link_table WHERE id=:id");
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
  <title>リンク更新</title>
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
  <form method="POST" action="link_update.php">
    <div class="jumbotron">
      <fieldset>
        <legend>[編集]</legend>
        <label>ラベル：</label>
        <!-- データベースから取得した値を表示 -->
        <input type="text" name="title" value="<?= $row['title'] ?>"><br>
        <label>リンク: </label>
        <input type="text" name="link" value="<?= $row['link'] ?>"><br>
        <label>メモ</label>
        <textArea name="memo" rows="4" cols="40"><?= $row['memo'] ?></textArea><br>


        <!-- idを隠して送信 -->
        <input type="hidden" name="id" value="<?= $id ?>">
        <!-- idを隠して送信 -->
        <input type="submit" value="送信">
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->

</body>

</html>