<?php
require "/var/www/html/back_end/db/dbfunction.php";
if (!isset($_COOKIE['PHPSESSID'])) {
    header('Location: /front_end/login.html'); // 認証されていない場合のリダイレクト
    exit;
}else{
    $curent_path="/back_end/user_page/first.php";
    $response=session_check($curent_path);
    if(!$response["status"]=="success"){
        header("Location:/front_end/login.html");
    exit();
    }
}
?>
<!-- 認証されたユーザーに表示されるコンテンツ -->
<h1>First</h1>
