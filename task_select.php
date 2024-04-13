<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();

// idとkeywordの取得
$id = isset($_GET["id"]) ? $_GET["id"] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// キーワードがある場合は条件に含める
$condition = !empty($keyword) ? " AND (title LIKE :keyword OR taskevent LIKE :keyword OR assignee LIKE :keyword OR duedate LIKE :keyword OR box LIKE :keyword OR memo LIKE :keyword OR completed LIKE :keyword)" : "";

// カラムごとにタスクを取得するクエリを準備
$stmt1 = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id AND column_id = 1" . $condition);
$stmt2 = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id AND column_id = 2" . $condition);
$stmt3 = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id AND column_id = 3" . $condition);
$stmt4 = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id AND column_id = 4" . $condition);

// パラメーターのバインド
$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt3->bindParam(':id', $id, PDO::PARAM_INT);
$stmt4->bindParam(':id', $id, PDO::PARAM_INT);

// キーワードがある場合はバインドする
if (!empty($keyword)) {
    $keyword = '%' . $keyword . '%';
    $stmt1->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmt2->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmt3->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmt4->bindParam(':keyword', $keyword, PDO::PARAM_STR);
}

// クエリの実行
$stmt1->execute();
$stmt2->execute();
$stmt3->execute();
$stmt4->execute();

// クエリ結果を取得
$tasks1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$tasks2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$tasks3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$tasks4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

// 結果を出力して確認
// var_dump($tasks1);
// var_dump($tasks2);
// var_dump($tasks3);
// var_dump($tasks4);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク一覧</title>
    <script src="js/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="css/task.css">

    <style>
        /* 完了したタスクの背景色 */
        .completed {
            background-color: lightgray;
        }
    </style>

</head>

<body>
    <!--リンク欄-->
    <ul class="topnav">
        <li><a class="active" href="select.php">Home</a></li>
        <li><a href="./task_today.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">Todaysタスク</a></li>
        <li><a href="./task_calendar.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">カレンダー表示</a></li>
        <li><a href="./diagnose.html">限度要否判定ツール</a></li>
    </ul>
    <h1 class="title">canacoチェックリスト</h1>

    <!-- 検索フォーム -->
    <form action=" " method="get">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="text" id="sbox1" name="keyword" placeholder="検索キーワードを入力">
        <button id="sbtn1" type="submit">検索</button>
        <?php if (!empty($keyword)) : ?>
            <button id="sbtn2" type="button" onclick="window.location.href='task_select.php?id=<?= $id ?>'">検索を解除</button>
        <?php endif; ?>
    </form>
    </form>

    <!--カンバンボード-->
    <div class="kanban-board">
        <!-- カラム1 -->
        <div class="kanban-column" id="column-id-1">
            <h2>(1)見積</h2>
            <?php foreach ($tasks1 as $task) : ?>
                <div class="kanban-item <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                    <!-- <div class="kanban-item"> -->
                    <!-- 詳細部分 -->
                    <div class="details <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                        <p class="heading">タスク名：</p>
                        <p><?= $task["title"] ?></p>
                        <p class="heading">イベント：</p>
                        <p><?= $task["taskevent"] ?></p>
                        <p class="heading">担当者：</p>
                        <p><?= $task["assignee"] ?></p>
                        <p class="heading">期限：</p>
                        <p><?= $task["duedate"] ?></p>
                        <p class="heading">内容：</p>
                        <p><?= $task["box"] ?></p>
                        <p class="heading">メモ：</p>
                        <p><?= $task["memo"] ?></p>
                        <p class="heading">完了/未完了：</p>
                        <p><?= $task["completed"] == 1 ? '完了' : '未完了' ?></p>

                    </div>
                    <!-- 編集ボタン -->
                    <td><a class="btn btn-primary" href="task_detail.php?id=<?= $task["id"] ?>">編集</a></td>
                    <!-- 削除ボタン -->
                    <td><a class="btn btn-danger" href="task_delete.php?id=<?= $task["id"] ?>">削除</a></td>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- カラム2 -->
        <div class="kanban-column" id="column-id-2">
            <h2>(2)契約</h2>
            <?php foreach ($tasks2 as $task) : ?>
                <div class="kanban-item <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                    <!-- <div class="kanban-item"> -->
                    <!-- 詳細部分 -->
                    <div class="details <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                        <p class="heading">タスク名：</p>
                        <p><?= $task["title"] ?></p>
                        <p class="heading">イベント：</p>
                        <p><?= $task["taskevent"] ?></p>
                        <p class="heading">担当者：</p>
                        <p><?= $task["assignee"] ?></p>
                        <p class="heading">期限：</p>
                        <p><?= $task["duedate"] ?></p>
                        <p class="heading">内容：</p>
                        <p><?= $task["box"] ?></p>
                        <p class="heading">メモ：</p>
                        <p><?= $task["memo"] ?></p>
                        <p class="heading">完了/未完了：</p>
                        <p><?= $task["completed"] == 1 ? '完了' : '未完了' ?></p>

                    </div>
                    <!-- 編集ボタン -->
                    <td><a class="btn btn-primary" href="task_detail.php?id=<?= $task["id"] ?>">編集</a></td>
                    <!-- 削除ボタン -->
                    <td><a class="btn btn-danger" href="task_delete.php?id=<?= $task["id"] ?>">削除</a></td>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- カラム3 -->
        <div class="kanban-column" id="column-id-3">
            <h2>(3)出荷</h2>
            <?php foreach ($tasks3 as $task) : ?>
                <div class="kanban-item <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                    <!-- <div class="kanban-item"> -->
                    <!-- 詳細部分 -->
                    <div class="details <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                        <p class="heading">タスク名：</p>
                        <p><?= $task["title"] ?></p>
                        <p class="heading">イベント：</p>
                        <p><?= $task["taskevent"] ?></p>
                        <p class="heading">担当者：</p>
                        <p><?= $task["assignee"] ?></p>
                        <p class="heading">期限：</p>
                        <p><?= $task["duedate"] ?></p>
                        <p class="heading">内容：</p>
                        <p><?= $task["box"] ?></p>
                        <p class="heading">メモ：</p>
                        <p><?= $task["memo"] ?></p>
                        <p class="heading">完了/未完了：</p>
                        <p><?= $task["completed"] == 1 ? '完了' : '未完了' ?></p>

                    </div>
                    <!-- 編集ボタン -->
                    <td><a class="btn btn-primary" href="task_detail.php?id=<?= $task["id"] ?>">編集</a></td>
                    <!-- 削除ボタン -->
                    <td><a class="btn btn-danger" href="task_delete.php?id=<?= $task["id"] ?>">削除</a></td>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- カラム4 -->
        <div class="kanban-column" id="column-id-4">
            <h2>(4)収支</h2>
            <?php foreach ($tasks4 as $task) : ?>
                <div class="kanban-item <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                    <!-- <div class="kanban-item"> -->
                    <!-- 詳細部分 -->
                    <div class="details <?= $task["completed"] == 1 ? 'completed' : '' ?>">
                        <p class="heading">タスク名：</p>
                        <p><?= $task["title"] ?></p>
                        <p class="heading">イベント：</p>
                        <p><?= $task["taskevent"] ?></p>
                        <p class="heading">担当者：</p>
                        <p><?= $task["assignee"] ?></p>
                        <p class="heading">期限：</p>
                        <p><?= $task["duedate"] ?></p>
                        <p class="heading">内容：</p>
                        <p><?= $task["box"] ?></p>
                        <p class="heading">メモ：</p>
                        <p><?= $task["memo"] ?></p>
                        <p class="heading">完了/未完了：</p>
                        <p><?= $task["completed"] == 1 ? '完了' : '未完了' ?></p>

                    </div>
                    <!-- 編集ボタン -->
                    <td><a class="btn btn-primary" href="task_detail.php?id=<?= $task["id"] ?>">編集</a></td>
                    <!-- 削除ボタン -->
                    <td><a class="btn btn-danger" href="task_delete.php?id=<?= $task["id"] ?>">削除</a></td>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Main[End] -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // 削除ボタンがクリックされたときの処理
        $('.kanban-item .btn-danger').on('click', function(e) {
            e.preventDefault(); // デフォルトのイベントをキャンセル
            var card = $(this).closest('.kanban-item'); // クリックされた削除ボタンの親要素であるカードを取得
            var url = $(this).attr('href'); // 削除ボタンのhref属性から削除処理を行うURLを取得
            // AJAXを使用して削除処理を行う
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // 削除処理が成功したら、該当のカードを即座に削除
                    card.fadeOut('fast', function() {
                        $(this).remove();
                    });
                },
                error: function(xhr, status, error) {
                    // 削除処理が失敗した場合の処理
                    console.error(error);
                    alert('削除に失敗しました。');
                }
            });
        });
    </script>
</body>

</html>