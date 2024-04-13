<?php
session_start();
include("funcs.php");
$pdo = db_conn();
//1. POSTデータ取得
$filename   = $_POST["filename"];
$buyername   = $_POST["buyername"];
$item   = $_POST["item"];
$deliverydate   = $_POST["deliverydate"];
$inquirydate   = $_POST["inquirydate"];
$name  = $_POST["name"];
$naiyou = $_POST["naiyou"];
// $img   = fileUpload("upfile","upload");



//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_an_table(filename, buyername, item, deliverydate, inquirydate, name, naiyou, img, indate )VALUES(:filename, :buyername, :item, :deliverydate, :inquirydate, :name, :naiyou, :img, sysdate())");
$stmt->bindValue(':filename', $filename);
$stmt->bindValue(':buyername', $buyername);
$stmt->bindValue(':item', $item);
$stmt->bindValue(':deliverydate', $deliverydate);
$stmt->bindValue(':inquirydate', $inquirydate);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':naiyou', $naiyou);
// $stmt->bindValue(':img', $img);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}
?>
