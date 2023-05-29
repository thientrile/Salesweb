
<?php
$method = $_SERVER['REQUEST_METHOD'];
/* This is a PHP code that handles different HTTP requests and performs different actions based on the
value of the `['function']` parameter. */
switch (isset($_GET['function']) ? $_GET['function'] : 0) {
    default: {
            echo json_encode(array("status" => "success"));
            break;
        }
    case "product": {
            // Product Management
            switch ($method) {
                case "GET": {
                        $result = $admin->getProduct(isset($_GET['page']) && $_GET['page'] != "" ? (int) $_GET['page'] : 1, isset($_GET['cate']) && $_GET['cate'] != "" ? $_GET['cate'] : 0, isset($_GET['keySearch']) ? $_GET['keySearch'] : "");
                        $array = array();
                        while ($row = $result->fetch()) {
                            array_push($array, $row);
                        }

                        echo json_encode(array("status" => "success", "data" => $array, "page" => $admin->countpage));
                        break;
                    }
                case "POST": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {


                                        $admin->updateProduct($_GET['id'], $_POST['title'], empty($_FILES['img']) ? null : $_FILES['img'], empty($_FILES['src']) ? null : $_FILES['src'], $_POST['type'], $_POST['desc'], $_POST['sdesc'], $_POST['discount'], $_POST['price'], empty($_FILES['gallery']) ? null : $_FILES['gallery']);
                                        echo json_encode(array("staut" => "success"));
                                    } else {


                                        $admin->insertProduct($_POST['title'], empty($_FILES['img']) ? null : $_FILES['img'], empty($_FILES['src']) ? null : $_FILES['src'], $_POST['type'], $_POST['desc'], $_POST['sdesc'], $_POST['discount'], $_POST['price'],  empty($_FILES['gallery']) ? null : $_FILES['gallery']);
                                        echo json_encode(array("staut" => "success"));
                                    }
                                    break;
                                }
                            case "hidden": {

                                    echo json_encode(array("staut" =>  $admin->hideProduct($_POST['id'])) ? "success" : "failed");

                                    break;
                                }
                            case "category": {
                                    echo $admin->addProductCate($_POST['name']);
                                    break;
                                }
                            case "arrow": {
                                    if (isset($_GET['id'])) {
                                        echo $admin->movieProduct($_GET['id'], isset($_POST['arrow']) ? $_POST['arrow'] : 1);
                                    } else {
                                        echo json_encode(array("staut" => "failed"));
                                    }
                                    break;
                                }
                        }
                        break;
                    }
                case "DELETE": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {;
                                    echo json_encode(array("status" =>   $admin->deleteProduct($_GET['id']) ? "success" : "failed"));
                                    break;
                                }
                            case "gallery": {;
                                    echo json_encode(array("status" =>   $admin->delGallery($_GET['id']) ? "success" : "failed"));
                                    break;
                                }
                        }
                        break;
                    }
            }
            break;
        }
        // news management

    case "news": {
            switch ($method) {
                case "GET": {
                        echo $admin->viewsNews(isset($_GET['page']) ? $_GET['page'] : 1, isset($_GET['keySearch']) ? $_GET['keySearch'] : "", isset($_GET['cate']) ? $_GET['cate'] : 0);
                        break;
                    }
                case "POST": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {
                                        echo $admin->updateNews($_GET['id'], $_POST['title'], $_POST['avatar'], $_POST['cateNews'], $_POST['content']);
                                    } else {
                                        echo $admin->addnews($_POST['title'], $_POST['avatar'], $_POST['cateNews'], $_SESSION["s_user"], $_POST['content']);
                                    }
                                    break;
                                }
                            case "category": {
                                    echo $admin->addNewsCate($_POST['name']);
                                    break;
                                }
                            case "hidden": {
                                    if (isset($_POST['cate_id'])) {
                                        echo $admin->hiddenProductCate($_POST['cate_id']);
                                    } else {

                                        echo $admin->hiddenNews($_POST['id']);
                                    }
                                    break;
                                }
                            case "arrow": {
                                    if (isset($_GET['id'])) {
                                        echo $admin->newsPosition($_GET['id'], isset($_POST['arrow']) ? $_POST['arrow'] : 1);
                                    } else {
                                        echo json_encode(array("staut" => "failed"));
                                    }
                                    break;
                                }
                        }
                        break;
                    }
                case "DELETE": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    echo $admin->delNews($_GET['id']);
                                    break;
                                }
                        }
                        break;
                    }
            }
            break;
        }
}
