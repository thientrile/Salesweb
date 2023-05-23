<?php
$method = $_SERVER['REQUEST_METHOD'];

if (isset($_POST['code']) && $_POST['code'] == $_SESSION['code']['code'] && $method == "POST") {
    echo json_encode(array("status" => "success"));
    $User->userSign($_SESSION['code']['username'], $_SESSION['code']['email'], $_SESSION['code']['pswd']);
    $result = $User->getId($_SESSION['code']['email']);
    $_SESSION["s_user"] =  $result['id'];
    setcookie('c_user', md5($result['id']), time() + 86400);
}
echo json_encode(array("status" => "failed"));
