<?php
session_start();
include "funcs.php";
sschk();

// 1. POSTデータ取得
$fk_file_id = $_POST["fk_file_id"];
$title = $_POST["title"];
$taskevent = $_POST["taskevent"];
$assignee = $_POST["assignee"];
$duedate = $_POST["duedate"];
$box = $_POST["box"];
$memo = $_POST["memo"];
$completed = $_POST["completed"];
$id = $_POST["id"];

//2.DB接続します
$pdo = db_conn();

// データベースに接続が成功したことを確認
if (!$pdo) {
    echo "データベースに接続できませんでした。";
    exit;
}

// 3．データ登録
$sql = "UPDATE gs_task_table SET fk_file_id = :fk_file_id, title = :title,taskevent = :taskevent, assignee = :assignee, duedate = :duedate, box = :box, memo = :memo, completed = :completed WHERE id = :id";
$stmt = $pdo->prepare($sql);

// バインド変数を設定する
$stmt->bindValue(':fk_file_id', $fk_file_id, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':taskevent', $taskevent, PDO::PARAM_STR);
$stmt->bindValue(':assignee', $assignee, PDO::PARAM_STR);
$stmt->bindValue(':duedate', $duedate, PDO::PARAM_STR);
$stmt->bindValue(':box', $box, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':completed', $completed, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// SQLを実行する
$status = $stmt->execute();

// // 4．データ登録処理後
// if ($status === false) {
//   sql_error($stmt);
// } else {
//   // リダイレクト先のURLにidパラメータを含めてtask_select.phpにリダイレクトする
//   header("Location: task_select.php?id=" . $id);
//   exit; // リダイレクトした後は処理を終了する
// }

// 4．データ登録処理後
if ($status === false) {
  sql_error($stmt);
} else {
  // リダイレクト先のURLにidパラメータを含めてtask_select.phpにリダイレクトする前に、更新後のデータを再度取得してからリダイレクトする
  // データ取得処理を追加
  $stmt = $pdo->prepare("SELECT * FROM gs_task_table WHERE id=:id");
  $stmt->bindValue(":id", $id, PDO::PARAM_INT);
  $status = $stmt->execute();

  if ($status === false) {
    sql_error($stmt);
  } else {
    // 更新後のデータを取得
    $updated_task = $stmt->fetch(PDO::FETCH_ASSOC);
    // リダイレクト先のURLにidパラメータを含めてtask_select.phpにリダイレクトする
    header("Location: task_select.php?id=" . $updated_task['fk_file_id']);
    exit; // リダイレクトした後は処理を終了する
  }
}





?>