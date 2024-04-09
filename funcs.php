<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn()
{
  try {
    $db_name = "gs_db6";    //データベース名
    $db_id   = "root";      //アカウント名
    $db_pw   = "";      //パスワード：XAMPPはパスワード無しに修正してください。
    $db_host = "localhost"; //DBホスト
    return new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
  } catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
  }
}

//SQLエラー
function sql_error($stmt)
{
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLError:" . $error[2]);
}

//リダイレクト
function redirect($file_name)
{
  header("Location: " . $file_name);
  exit();
}
//SessionCheck
function sschk()
{
  if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
    exit("Login Error");
  } else {
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}

//fileUpload("送信名","アップロード先フォルダ");
function fileUpload($fname = "upfile", $path)
{
  // ファイルがアップロードされているかどうかをチェック
  if (isset($_FILES[$fname]) && $_FILES[$fname]["error"] == 0 && $_FILES[$fname]["size"] > 0) {
    // ファイル名取得
    $file_name = $_FILES[$fname]["name"];
    // 一時保存場所取得
    $tmp_path  = $_FILES[$fname]["tmp_name"];
    // 拡張子取得
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    // ユニークファイル名作成
    $file_name = date("YmdHis") . md5(session_id()) . "." . $extension;
    // アップロード先のパス
    $file_dir_path = $path . "/" . $file_name;

// ファイルがアップロードされた情報をログに出力
error_log("Uploaded file: " . $file_name . ", Path: " . $file_dir_path);



    // ファイルを移動してアップロードする
    if (move_uploaded_file($tmp_path, $file_dir_path)) {
      chmod($file_dir_path, 0644);
      return $file_name; // 成功時：ファイル名を返す
    } else {
      return 1; // 失敗時：ファイル移動に失敗
    }
  } else {
    // ファイルがアップロードされていない場合は空文字列を返す
    return "";
  }
}