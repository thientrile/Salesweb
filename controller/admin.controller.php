<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST" && isset($_GET['function'])) {
    switch ($_GET['function']) {
        case "product": {
                if (isset($_GET['id'])) {


                    $admin->updateProduct($_GET['id'], $_POST['title'], empty($_FILES['img']) ? null : $_FILES['img'], empty($_FILES['src']) ? null : $_FILES['src'], $_POST['type'], $_POST['desc'], $_POST['sdesc'], $_POST['discount'], $_POST['price'], empty($_FILES['gallery']) ? null : $_FILES['gallery']);
                    echo json_encode(array("staut" => "success"));
                } else {


                    $admin->insertProduct($_POST['title'], empty($_FILES['img']) ? null : $_FILES['img'], empty($_FILES['src']) ? null : $_FILES['src'], $_POST['type'], $_POST['desc'], $_POST['sdesc'], $_POST['discount'], $_POST['price'],  empty($_FILES['gallery']) ? null : $_FILES['gallery']);
                    echo json_encode(array("staut" => "success"));
                }
                break;
            }
        case "productHidden": {
                $admin->hideProduct($_POST['id']);
                echo json_encode(array("staut" => "success"));

                break;
            }
        case "cate_news": {
                if (isset($_POST['name'])) {

                    echo $admin->addNewsCate($_POST['name']);
                } else {
                    echo json_encode(array("staut" => "falied"));
                }
                break;
            }
        case "insert_news": {
                // echo json_encode( array($_POST['avatar']));
                echo $admin->addnews($_POST['title'], $_POST['avatar'], $_POST['cateNews'], $_SESSION["s_user"], $_POST['content']);
                // echo json_encode(array($_POST['title'], $_POST['avatar'], $_POST['cateNews'], $_SESSION["s_user"], $_POST['content']));
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
} elseif ($method == "GET" && isset($_GET['function'])) {
    switch ($_GET['function']) {
        case "product": {

                $result = $admin->getProduct(isset($_GET['page']) && $_GET['page'] != "" ? (int) $_GET['page'] : 1, isset($_GET['cate']) && $_GET['cate'] != "" ? $_GET['cate'] : 0, isset($_GET['keySearch']) ? $_GET['keySearch'] : "");
                $array = array();
                while ($row = $result->fetch()) {
                    array_push($array, $row);
                }

                echo json_encode(array("status" => "success", "data" => $array, "page" => $admin->countpage));
                break;
            }
        case "cate_news": {
                echo $admin->viewNewsCate();
                break;
            }
        case "news": {
                echo $admin->viewNews(isset($_GET['page']) ? $_GET['page'] : 1);
                break;
            }
    }
} else {
    echo json_encode(array("status" => "success"));
}
