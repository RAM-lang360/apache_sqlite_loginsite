<?php
require "/var/www/html/back_end/db/dbfunction.php";
if (!isset($_COOKIE['PHPSESSID'])) {
    header('Location: /front_end/login.html'); // 認証されていない場合のリダイレクト
    exit;
}else{
    $curent_path="/back_end/user_page/second.php";
    $response=session_check($curent_path);
    if(!$response["status"]=="success"){
        header("Location:/front_end/login.html");
    exit();
    }
}
function ip_adress (){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $user_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }

    return "あなたのIPアドレス: " . $user_ip;
}
?>
<!-- 認証されたユーザーに表示されるコンテンツ -->
 <h1></h1>
<h1>あなたのIPアドレスが探知されました。</h1>
<!-- 認証されたユーザーに表示されるコンテンツ -->
<h1><?php echo ip_adress(); ?></h1>
