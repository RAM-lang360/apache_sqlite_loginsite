<?php
function check_db($username,$password){
    $id_db=new SQLite3("id.db");
    if (!$id_db){
        die("データベースに接続できませんでした");
    }
    echo "データベースに接続しました";
    $query="SELECT 'username' FROM user";
};
?>