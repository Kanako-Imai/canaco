<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();



// 1. MySQLのテンプレートから全タスクを取得する
$stmt = $pdo->prepare("SELECT * FROM gs_tasktemplete_table");
$stmt->execute();
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. 案件ファイルごとに取得したタスクを登録する
$fk_file_id = isset($_GET["id"]) ? $_GET["id"] : null;

foreach ($templates as $template) {
    // タスクテンプレートからデータを取得して、新しいテーブルに登録
    $title = $template["title"];
    $taskevent = $template["taskevent"];
    $assignee = $template["assignee"];
    $duedate = $template["duedate"];
    $box = $template["box"];
    $memo = $template["memo"];
    $completed = $template["completed"];
    $column_id = $template["column_id"];

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

    // 登録処理のエラーハンドリング
    if ($status == false) {
        sql_error($stmt);
        exit; // エラーが発生したら処理を中断
    }
}

// 3. 登録処理の自動化
redirect("select.php"); // 登録が完了したら案件一覧ページにリダイレクト
?>