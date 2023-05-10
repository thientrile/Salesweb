<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $result = $User->getInfor($_SESSION['s_user']);
    echo json_encode($result);
} elseif ($method == "POST") {
    if (isset($_GET['function'])) {
        switch ($_GET['function']) {
            case "avatar":
                echo $User->upAvatar($_POST['id'], $_FILES['File_avatar']);
                break;
            case "Upload":
                echo $User->updateUser($_POST[
                    'id'
                ],$_POST['name'],$_POST['phone'],$_POST['address']);
                break;
            case "green":
                echo "Your favorite color is green!";
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }
}
