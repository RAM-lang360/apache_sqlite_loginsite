<?php
function check_db($username,$password){
    $error=NULL;
    $url=NULL;
    $id_db=new SQLite3("id.db");
    if (!$id_db){
        die("データベースに接続できませんでした");
    }
    echo "データベースに接続しました";
    
    
    //セッションがない場合
    $query="SELECT * FROM user WHERE username=:username AND password=:password";
    // sqlインジェクション攻撃を防ぐためにこれを使用
    $stmt=$id_db->prepare($query);
    $stmt->bindValue(":username",$username,SQLITE3_TEXT);
    $stmt->bindValue(":password",$password,SQLITE3_TEXT);
    $result=$stmt->execute();
    $row=$result->fetchArray(SQLITE3_ASSOC);
    
    if(!$row){
        $error="usernameかpasswordが間違っています";
    }else{
        $url=$row["url"];
        echo "$url";
    }
    

};


?>