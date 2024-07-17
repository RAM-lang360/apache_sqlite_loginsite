<?php
// SQLite データベースファイルへのパス
$db_file = 'id.db';

try {
    // SQLite に接続
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブル作成のクエリ
    $create_table_query = "
        CREATE TABLE IF NOT EXISTS user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(50) NOT NULL,
            url VARCHAR(100) NOT NULL
        )
    ";

    // テーブル作成の実行
    $db->exec($create_table_query);
    echo "テーブル 'user' が作成されました。\n";

    // データの挿入例
    $insert_query = "
        INSERT INTO user (username, password, url)
        VALUES ('Ryo', '1234', 'first.html')
    ";

    // データの挿入
    $db->exec($insert_query);
    echo "データが挿入されました。\n";

    // データの取得例
    $select_query = "SELECT * FROM user";
    $result = $db->query($select_query);

    // 結果の表示
    foreach ($result as $row) {
        echo "ID: " . $row['id'] . ", ユーザー名: " . $row['username'] . ", URL: " . $row['url'] . "\n";
    }

    // データベース接続の解放
    $db = null;
} catch(PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
