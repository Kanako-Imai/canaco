<?php
session_start();

// 1. POSTデータ取得
$title = $_POST["title"];
$link = $_POST["link"];
$memo = $_POST["memo"];
$id = $_POST["id"];

// 2. DB接続します
include("funcs.php");
$pdo = db_conn();

// 3．データ更新のためのSQLクエリを作成する
$sql = "UPDATE gs_link_table SET title = :title, link = :link, memo = :memo WHERE id = :id";

// 4．SQLを実行する準備
$stmt = $pdo->prepare($sql);

// 5．バインド変数を設定する
$stmt->bindValue(':title', $title);
$stmt->bindValue(':link', $link);
$stmt->bindValue(':memo', $memo);
$stmt->bindValue(':id', $id);

// 6．SQLを実行する
$status = $stmt->execute();

// 7．データ登録処理後の処理
if ($status == false) {
  sql_error($stmt);
} else {
  redirect("link_select.php");
}
?>
