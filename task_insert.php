<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();

// 1. POSTデータ取得（fk_file_idはオプショナルと仮定し、存在しない場合はNULLを設定）
$title = $_POST["title"];
$taskevent = $_POST["taskevent"];
$assignee = $_POST["assignee"];
$duedate = $_POST["duedate"] ?? NULL; // PHP 7.0+ のnull合体演算子を使用
$box = $_POST["box"];
$memo = $_POST["memo"] ?? NULL; // memoが空の場合はNULLを設定
$completed = $_POST["completed"];
$fk_file_id = $_POST["fk_file_id"] ?? NULL; // fk_file_idが空の場合はNULLを設定
$column_id = $_POST["column_id"];


// データベース登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_task_table (fk_file_id, title,taskevent, assignee, duedate, box, memo, completed, column_id, indate) VALUES (:fk_file_id, :title, :taskevent, :assignee, :duedate, :box, :memo, :completed, :column_id, sysdate())");
$stmt->bindValue(':fk_file_id', $fk_file_id, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':taskevent', $taskevent, PDO::PARAM_STR);
$stmt->bindValue(':assignee', $assignee, PDO::PARAM_STR);
$stmt->bindValue(':duedate', $duedate, PDO::PARAM_STR);
$stmt->bindValue(':box', $box, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':completed', $completed, PDO::PARAM_INT);
$stmt->bindValue(':column_id', $column_id, PDO::PARAM_INT);
$status = $stmt->execute();

// ４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("select.php");
}

?>