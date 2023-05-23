<?php
$log_mail = isset($_POST['email']) ? $_POST['email'] : "";
$log_pswd = isset($_POST['pswd']) ? $_POST['pswd'] : "";
$result = $User->userLogin($log_mail, md5($log_pswd));
if ($result != false) {

    $_SESSION["s_user"] =  $result['id'];
    setcookie('c_user', md5($result['id']), time() + 86400);
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "fall", "error" => "Email or password is incorrect"));
}
