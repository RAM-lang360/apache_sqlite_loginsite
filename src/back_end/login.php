<?php
// JSONデータを取得
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
$re_url="http://localhost/back_end/test.html";
// レスポンスを返す
$response = [
    'status' => 'success',
    'username' => $username,
    'password' => $password,
    'response_url' =>$re_url
];

// Content-Typeを設定してJSONレスポンスを出力
header('Content-Type: application/json');
echo json_encode($response);
?>
