<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
  <style>label { display: block; margin-bottom: 5px; }</style>
  <style>textarea {padding: 8px;margin-bottom: 10px;box-sizing: border-box;resize: vertical;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">案件一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert.php" enctype="multipart/form-data">
    <div class="jumbotron">
        <fieldset>
            <legend>新規案件登録</legend>
            <label>案件名：</label>
              <input type="text" name="filename"><br>
            <label>BUYER: </label>
              <input type="text" name="buyername"><br>
            <label>アイテム：</label>
              <input type="text" name="item"><br>
            <label>納期：</label>
              <input type="date" min="2024-01-01" max="2050-12-31" name="deliverydate"></br>
            <label>見積依頼受領日：</label>
              <input type="date" min="2024-01-01" max="2050-12-31" name="inquirydate"></br>
            <label>担当者：</label>
              <input type="text" name="name"><br>
            <label>メモ</label>
              <textArea name="naiyou" rows="4" cols="40"></textArea><br>
            <label><input type="file" name="upfile"></label><br>
            <input type="submit" value="送信">
        </fieldset>
    </div>
</form>
<!-- Main[End] -->

</body>
</html>
