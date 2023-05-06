<?php
$email = isset($_POST["email"]) ? $_POST["email"] : ""; //lấy email
$result = $userInfor->checkEmailExit($email);
if ($result) {
    echo json_encode(array("data" => true));
} else {
    echo json_encode(array("data" => false));
}
