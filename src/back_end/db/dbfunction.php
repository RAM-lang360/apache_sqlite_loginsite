<?php
function check_db($username, $password) {
    $response=NULL;
    if(isset($_COOKIE["session_id"])){
        $response=session_check();
    }else{
        $response=first_session_check($username,$password);
    }
    return $response;
}


function first_session_check($username,$password){
    $error = NULL;
    $re_url = NULL;
    $status = NULL;
    $db_path = "/var/www/html/back_end/db/id.db";
    if (!file_exists($db_path)) {
        die("データベースファイルが見つかりません");
    }

    $id_db = new SQLite3($db_path);
    if (!$id_db) {
        die("データベースに接続できませんでした");
    }
    session_start();
    // セッションIDを取得
    $session_id = session_id();
    setcookie(session_name(), session_id(), time() +3600, '/', '', true, true);

    // ユーザーの認証
    $query = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $id_db->prepare($query);
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row) {
        // セッションIDをユーザーに関連付けて更新
        $update_query = "UPDATE user SET session = :session WHERE username = :username";
        $update_stmt = $id_db->prepare($update_query);
        $update_stmt->bindValue(':session', $session_id, SQLITE3_TEXT);
        $update_stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $update_stmt->execute();

        $status = "success";
        $re_url = $row["url"];
    } else {
        $status = "error";
        $error = "username or password is wrong";
    }

    $response = [
        "status" => $status,
        "re_url" => $re_url,
        "error" => $error
    ];

    // // ログを書く
    // $de_error = $id_db->lastErrorMsg();
    // $today = date("Y-m-d H:i:s");
    // $log_path = "/var/www/html/back_end/db/dblog.csv";
    // $fp = fopen($log_path, "a"); // 追記モードに変更
    // if ($fp) {
    //     fwrite($fp, "$today,$status,$re_url,$de_error\n");
    //     fclose($fp);
    // } else {
    //     error_log("ログファイルのオープンに失敗しました: $log_path");
    // }

    return $response;
}
function session_check(){
    $error = NULL;
    $status = NULL;
    $status = NULL;
    $re_url=NULL;
    //cookieを取得する
    $db_path = "/var/www/html/back_end/db/id.db";
    if (!file_exists($db_path)) {
        die("データベースファイルが見つかりません");
    }

    $id_db = new SQLite3($db_path);
    if (!$id_db) {
        die("データベースに接続できませんでした");
    }
    $session_id=$_COOKIE["PHPSESSID"];
    $query = "SELECT * FROM user WHERE session = :session_id";
    $stmt = $id_db->prepare($query);
    $stmt->bindValue(":session_id", $session_id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if($row){
        $status="success";
    }else{
        $error="SQL上でセッション確認のエラーが発生しました";
    }
    $response = [
        "status" => $status,
        "error" => $error,
        "re_url"=> $row["url"]
    ];
    return $response;
}
function insert_db($username, $password) {
    // insert_db関数の内容をここに追加してください
}


?>
