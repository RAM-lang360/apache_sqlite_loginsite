<?php
// セッションの終了
session_start();
session_unset(); // セッション変数を全て削除
session_destroy(); // セッション自体を破棄

// セッションIDが保存されているクッキーを削除
$cookie_params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000, 
    $cookie_params["path"], 
    $cookie_params["domain"], 
    $cookie_params["secure"], 
    $cookie_params["httponly"]
);

// クッキー削除の確認メッセージやリダイレクト
echo "ログアウトしました";
// header('Location: /login.php'); // ログアウト後にリダイレクトする場合

?>
