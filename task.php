<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>タスク登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/task.css">
    <link rel="stylesheet" href="css/calendar.css">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        textarea {
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            resize: vertical;
        }
    </style>
</head>

<body>

    <header>
        <ul class="topnav">
            <li><a class="active" href="select.php">Home</a></li>
        </ul>
    </header>

    <form method="POST" action="task_insert.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>新規タスク登録</legend>
                <label>タスク名：</label>
                <input type="text" name="title"><br>
                <label>イベント：</label>
                <input type="text" name="taskevent"><br>
                <label>担当者:</label>
                <input type="text" name="assignee"><br>
                <label>内容：</label>
                <input type="text" name="box"><br>
                <label>期限：</label>
                <input type="date" min="2024-01-01" max="2050-12-31" name="duedate"></br>
                <label>メモ：</label>
                <textarea name="memo" rows="4" cols="40"></textarea><br>
                <label>完了/未完了：</label>
                <input type="radio" name="completed" value="1"> 完了
                <input type="radio" name="completed" value="0" checked> 未完了<br>
                <input type="hidden" name="fk_file_id" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES); ?>">

                <label>カラム：</label>
                <select name="column_id">
                    <option value="1">（１）見積</option>
                    <option value="2">（２）契約</option>
                    <option value="3">（３）出荷</option>
                    <option value="4">（４）収支</option>
                </select><br>



                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>

</body>

</html>