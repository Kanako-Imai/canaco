<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();

// 今日の日付とIDを取得
$today = date("Y-m-d");
$id = isset($_GET["id"]) ? $_GET["id"] : '';


// 期限が今日またはそれ以前で、期限が'0000-00-00'ではなく、かつ未完了（completedが0）のタスクを取得するクエリを準備
$stmt = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id AND duedate <= :today AND duedate <> '0000-00-00' AND completed = 0 ORDER BY duedate ASC");
$stmt->bindValue(':today', $today, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// クエリ結果を取得
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


// 結果を出力して確認
// var_dump($id);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>今日のタスク</title>
    <script src="js/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="css/task.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* 線を連続させる */
        }
        th, td {
            border: 1px solid #dddddd; /* 線のスタイル */
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* 偶数行の背景色 */
        }
    </style>
</head>
<body>
     <!--リンク欄-->
     <ul class="topnav">
        <li><a class="active" href="select.php">Home</a></li>
        <li><a href="./task_select.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">タスク一覧に戻る</a></li>
    </ul>
    <h1>今日のタスク</h1>
    <table>
        <thead>
            <tr>
                <th>タスク名</th>
                <th>イベント</th>
                <th>担当者</th>
                <th>期限</th>
                <th>内容</th>
                <th>メモ</th>
                <th>完了/未完了</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task["title"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task["taskevent"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task["assignee"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task["duedate"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task["box"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task["memo"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= $task["completed"] == 1 ? '完了' : '未完了' ?></td>
                <td>
                    <a href="task_detail.php?id=<?= $task["id"] ?>">編集</a> | 
                    <a href="task_delete.php?id=<?= $task["id"] ?>" onclick="return confirm('削除してよろしいですか？');">削除</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>