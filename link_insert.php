<?php
session_start();
include("funcs.php");
$pdo = db_conn();
//1. POSTデータ取得
$title   = $_POST["title"];
$link   = $_POST["link"];
$memo = $_POST["memo"];


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_link_table(title, link, memo, indate) VALUES(:title, :link, :memo, sysdate())");
$stmt->bindValue(':title', $title);
$stmt->bindValue(':link', $link);
$stmt->bindValue(':memo', $memo);


$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("link_select.php");
}
?>
