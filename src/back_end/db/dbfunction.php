<?php
function check_db($username, $password) {
    $response=NULL;
        $response=first_session_check($username,$password);
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

    // ユーザーの認証
    $query = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $id_db->prepare($query);
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row) {
        // セッションIDをユーザーに関連付けて更新
        session_regenerate_id(true);
        $session_id = session_id();
        setcookie(session_name(), session_id(), time() +3600, '/', '', true, true);
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
    return $response;
}
function session_check($url){
    $error = NULL;
    $status = NULL;
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
    if($row["url"]==$url){
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
function signin_db($username, $password) {
    $error = null;
    $status = null;
    $db_path = "/var/www/html/back_end/db/id.db";
    
    if (!file_exists($db_path)) {
        die("データベースファイルが見つかりません");
    }

    $id_db = new SQLite3($db_path);
    if (!$id_db) {
        die("データベースに接続できませんでした");
    }

    $query = "INSERT INTO user (username, password, url) VALUES (:username, :password, '/back_end/user_page/second.php')";
    $stmt = $id_db->prepare($query);
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);

    // エラーレポートを抑制
    $result = @$stmt->execute();
    
    if ($result === false) {
        $errormessage = $id_db->lastErrorMsg();
        $status = "error";
        if (strpos($errormessage, "UNIQUE constraint failed: user.username") !== false) {
            $error = "そのユーザーネームはすでに使用されています";
        } else {
            $error = "不正なサインインを感知しました";
        }
    } else {
        $status = "success";
    }

    $response = [
        "status" => $status,
        "error" => $error
    ];
    return $response;
}

?>
