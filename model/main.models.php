<?php
/* It's starting a session. */




header("Content-Type: application/json;");
header("Access-Control-Allow-Origin: *");

session_start();



set_include_path(get_include_path() . PATH_SEPARATOR . './');
spl_autoload_extensions('.models.php');
spl_autoload_register();

/* It's creating a new instance of the `connect` class. */
$cc = new connect();
$User = new user();
$Cart = new cart();
$mail = new mail();
$product = new product();

$statistics = new statistics();
$News = new news();
if (isset($_SESSION['s_user']) && isset($_COOKIE['c_user']) && md5($_SESSION['s_user']) == $_COOKIE['c_user'] && $User->getInfor($_SESSION['s_user'])[0] != "") {

    $checkout = new  invoice($_SESSION['s_user']);
    $admin = new admin($_SESSION['s_user']);
} else {
    // Xoá cookie c_user
    setcookie('c_user', '', time() - 86400);
    if (isset($_SESSION['s_user'])) {
        session_name("s_user");
        session_unset();
        session_destroy();
    }
}


// tạo điều hướng controllers



/* It's checking if the function `currency_format` exists. If it doesn't, it creates it. */
