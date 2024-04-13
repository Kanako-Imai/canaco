<?php
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id=:id");
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
  <form method="POST" action="update.php">
    <div class="jumbotron">
      <fieldset>
        <legend>[編集]</legend>
        <label>案件名：</label>
        <!-- データベースから取得した値を表示 -->
        <input type="text" name="filename" value="<?= $row['filename'] ?>"><br>
        <label>BUYER: </label>
        <input type="text" name="buyername" value="<?= $row['buyername'] ?>"><br>
        <label>アイテム：</label>
        <input type="text" name="item" value="<?= $row['item'] ?>"><br>
        <label>納期：</label>
        <input type="date" min="2024-01-01" max="2050-12-31" name="deliverydate" value="<?= $row['deliverydate'] ?>"></br>
        <label>見積依頼受領日：</label>
        <input type="date" min="2024-01-01" max="2050-12-31" name="inquirydate" value="<?= $row['inquirydate'] ?>"></br>
        <label>担当者：</label>
        <input type="text" name="name" value="<?= $row['name'] ?>"><br>
        <label>メモ</label>
        <textArea name="naiyou" rows="4" cols="40"><?= $row['naiyou'] ?></textArea><br>
        <!-- <label><input type="file" name="upfile"></label><br> -->

        <!-- <label>現在の画像：</label> -->
        <!-- <img src="upload/<?= $row['img'] ?>" alt="現在の画像" style="max-width: 200px;"><br> -->
        <!-- <label>新しい画像を選択：</label>
        <input type="file" name="upfile"><br> -->



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