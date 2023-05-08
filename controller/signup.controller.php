<?php
$username = isset($_POST["username"]) ? $_POST["username"] : ""; //lấy thông username    
$email = isset($_POST["email"]) ? $_POST["email"] : ""; //lấy email
$pswd = isset($_POST["pswd"]) ? $_POST["pswd"] : ""; //lấy password
$User->userSign($username, $email, md5($pswd));
$result = $userInfor->getId($email);
$_SESSION["s_user"] =  $result['id'];
setcookie('c_user', md5($result['id']), time() + 86400);
echo json_encode(array("status"=>"success"));
