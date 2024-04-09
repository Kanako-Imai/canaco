<?php
session_start();

// 1. POSTデータ取得
$filename = $_POST["filename"];
$buyername = $_POST["buyername"];
$item = $_POST["item"];
$deliverydate = $_POST["deliverydate"];
$inquirydate = $_POST["inquirydate"];
$name = $_POST["name"];
$naiyou = $_POST["naiyou"];
$id = $_POST["id"];
// 画像ファイルアップロード処理
$img = '';
// ファイルがアップロードされているかどうかを確認
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] === 0 && $_FILES['upfile']['size'] > 0) {
  // 画像がアップロードされている場合の処理
  include("funcs.php");
  $img = fileUpload("upfile", "upload");
  // ファイルがアップロードされている場合、SQLにファイル名を追加
  $sql = "UPDATE gs_an_table SET filename=:filename, buyername=:buyername, item=:item, deliverydate=:deliverydate, inquirydate=:inquirydate, name=:name, naiyou=:naiyou, img=:img WHERE id=:id";
} else {
  // ファイルがアップロードされていない場合、SQLにファイル名を含めない
  $sql = "UPDATE gs_an_table SET filename=:filename, buyername=:buyername, item=:item, deliverydate=:deliverydate, inquirydate=:inquirydate, name=:name, naiyou=:naiyou WHERE id=:id";
}

// 2. DB接続します
include("funcs.php");
$pdo = db_conn();

// 3．データ登録
$stmt = $pdo->prepare($sql);
// バインド変数を設定する
$stmt->bindValue(':filename', $filename);
$stmt->bindValue(':buyername', $buyername);
$stmt->bindValue(':item', $item);
$stmt->bindValue(':deliverydate', $deliverydate);
$stmt->bindValue(':inquirydate', $inquirydate);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':naiyou', $naiyou);
$stmt->bindValue(':id', $id);
// ファイルがアップロードされている場合のみ、ファイル名をバインドする
if (!empty($img)) {
  $stmt->bindValue(':img', $img);
}

// SQLを実行する
$status = $stmt->execute();


// 4．データ登録処理後
if ($status == false) {
  sql_error($stmt);
} else {
  redirect("select.php");
}


?>
