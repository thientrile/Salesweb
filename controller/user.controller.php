<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $result = $User->getInfor($_SESSION['s_user']);
    echo json_encode($result);
}
