<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>マニュアル、システムリンク登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
  <style>label { display: block; margin-bottom: 5px; }</style>
  <style>textarea {padding: 8px;margin-bottom: 10px;box-sizing: border-box;resize: vertical;}</style>
  <style>
    .navbar-default {
        background-color: #3949AB;
        border-color:    #3949AB;;
    }
</style>
</head>
<body>

<!-- Head[Start] -->
<header>
    <?php include("menu.php"); ?> 
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="link_insert.php" enctype="multipart/form-data">
    <div class="jumbotron">
        <fieldset>
            <legend>新規リンク登録</legend>
            <label>タイトル：</label>
              <input type="text" name="title"><br>
            <label>リンク: </label>
              <input type="text" name="link"><br>
            <label>メモ</label>
              <textArea name="memo" rows="4" cols="40"></textArea><br>
            <input type="submit" value="送信">
        </fieldset>
    </div>
</form>
<!-- Main[End] -->

</body>
</html>
