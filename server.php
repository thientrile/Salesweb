<?php


// Tiến hành include các file cần thiết
include_once './model/main.models.php';
$ctrl = 'product';
if (isset($_GET['action'])) {
    $mydir = './controller';

    $myfiles = array_diff(scandir($mydir), array('.', '..'));
    $ctrl = array_search($_GET['action'] . ".controller.php", $myfiles, false) ? $_GET['action'] : 'product';
}
include_once './controller/' . $ctrl . '.controller.php';
