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

//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM gs_task_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


// 4．データ登録処理後
if ($status === false) {
  sql_error($stmt);
} else {
  // リダイレクト先のURLにidパラメータを含めてtask_select.phpにリダイレクトする
  redirect("task_select.php?id=" . $id);
}

?>


