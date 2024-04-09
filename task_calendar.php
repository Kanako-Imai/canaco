<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();

$id = isset($_GET["id"]) ? $_GET["id"] : '';

// カレンダー上で選択された日付に関連するタスクを取得するクエリを準備
$stmt = $pdo->prepare("SELECT * FROM gs_task_table WHERE fk_file_id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 現在の年と月を取得
$currentYear = date('Y');
$currentMonth = date('n');

// echo "id: $id<br>";

// if (!$stmt) {
//     echo "クエリ実行中にエラーが発生しました。";
//     print_r($pdo->errorInfo());
// } else {
//     echo "クエリが正常に実行されました。";
// }

// タスクの内容を表示
// echo "<pre>";
// print_r($tasks);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>カレンダー表示</title>
<link rel="stylesheet" href="css/task.css">
<link rel="stylesheet" href="css/calendar.css">
<style>



</style>
</head>
<body>
<ul class="topnav">
    <li><a class="active" href="select.php">Home</a></li>
    <li><a href="./task_today.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">Todaysタスク</a></li>
    <li><a href="./task_select.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">タスク一覧</a></li>
    <li><a href="./diagnose.html">限度要否判定ツール</a></li>
</ul>
<h1>カレンダー</h1>
<h2 id="ym"><?= $currentYear ?>年<span><?= $currentMonth ?>月</span></h2>

<div id="calendar"></div>

<btn class="button-container-calendar">
<button id="prevMonth">前の月</button>
<button id="nextMonth">次の月</button>
</btn>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    let currentYear = <?= $currentYear ?>;
    let currentMonth = <?= $currentMonth ?> - 1; // JavaScriptの月は0から始まるため、1を引く
    const calendarEl = document.getElementById('calendar');
    const ymEl = document.getElementById('ym');
    
    // PHPのタスク情報をJavaScriptの配列に変換
    const tasks = <?php echo json_encode($tasks); ?>;

    function generateCalendar(year, month) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let calendarHtml = '<table><thead><tr>';
        for (let i = 0; i < 7; i++) {
            calendarHtml += `<th>${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][i]}</th>`;
        }
        calendarHtml += '</tr></thead><tbody><tr>';

        for (let i = 1; i <= daysInMonth; i++) {
            const dayOfWeek = new Date(year, month, i).getDay();
            if (i === 1) {
                calendarHtml += '<tr>';
                for (let j = 0; j < dayOfWeek; j++) {
                    calendarHtml += '<td></td>';
                }
            }
            calendarHtml += `<td>${i}`;
            // タスク情報を表示
            tasks.forEach(task => {
                const taskDate = new Date(task.duedate);
                if (taskDate.getFullYear() === year && taskDate.getMonth() === month && taskDate.getDate() === i) {
                    calendarHtml += `<div class="event">${task.taskevent}</div>`;
                }
            });
            calendarHtml += '</div></td>';
            if (dayOfWeek === 6) {
                calendarHtml += '</tr>';
                if (i < daysInMonth) {
                    calendarHtml += '<tr>';
                }
            } else if (i === daysInMonth) {
                for (let j = dayOfWeek + 1; j <= 6; j++) {
                    calendarHtml += '<td></td>';
                }
                calendarHtml += '</tr>';
            }
        }
        calendarHtml += '</tbody></table>';
        calendarEl.innerHTML = calendarHtml;
        ymEl.innerHTML = `${year}年<span>${month + 1}月</span>`;
    }

    $('#prevMonth').on('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    $('#nextMonth').on('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });

    // 初期表示のカレンダー生成
    generateCalendar(currentYear, currentMonth);
});
</script>
</body>
</html>