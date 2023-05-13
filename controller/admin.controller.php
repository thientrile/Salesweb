<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST" && isset($_GET['function'])) {
    switch ($_GET['function']) {
        case "Editproduct": {
                if (isset($_GET['id'])) {


                    $admin->updateProduct($_GET['id'], $_POST['title'], empty($_FILES['img']) ? null : $_FILES['img'], empty($_FILES['src']) ? null : $_FILES['src'], $_POST['type'], $_POST['desc'], $_POST['sdesc'], $_POST['discount'], $_POST['price'], empty($_FILES['gallery']) ? null : $_FILES['gallery']);
                    echo json_encode(array("staut" => "success"));
                } else {

                    echo json_encode(array("staut" => "faile"));
                }
                break;
            }
    }
} elseif ($method == "DELETE" && isset($_GET['function'])) {

    switch ($_GET['function']) {
        case "gallery": {
                if (isset($_GET['id'])) {
                    $admin->delGallery($_GET['id']);
                    echo json_encode(array("status" => "success", "id" => $_GET['id']));
                }

                break;
            }
        case "product": {
                $admin->deleteProduct($_GET['id']);
                echo json_encode(array("status" => "success", "id" => $_GET['id']));

                break;
            }
    }
} else {
    echo json_encode(array("status" => "fail", "method" => $method));
}
