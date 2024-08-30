<?php
require_once "db/dbfunction.php";

$input =file_get_contents("php://input");
$data=json_decode($input,true);

if($data == null){
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$username=$data["username"];
$password=$data["password"];

$response=signin_db($username,$password);
header("Content-Type: application/json");
echo json_encode($response);
?>