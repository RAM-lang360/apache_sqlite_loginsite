<?php
// JSONデータを取得
require_once "db/dbfunction.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// データが正しく受け取られているか確認
if ($data === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$db_path = "/var/www/html/back_end/db/id.db";
if (!file_exists($db_path)) {
    die("データベースファイルが見つかりません");
}

$id_db = new SQLite3($db_path);
if (!$id_db) {
    die("データベースに接続できませんでした");
}
//dbfunction.phpのセッション確認を使う
$response=session_check($id_db);
// Content-Typeを設定してJSONレスポンスを出力
header('Content-Type: application/json');
echo json_encode($response);
?>
