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

// データを処理
$username = $data['username'];
$password = $data['password'];
// レスポンスを返す

$response=check_db($username,$password);
// Content-Typeを設定してJSONレスポンスを出力
header('Content-Type: application/json');
echo json_encode($response);
?>
