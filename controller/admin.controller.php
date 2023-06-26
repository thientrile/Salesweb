
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
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {
                                        echo $admin->viewProductDetails($_GET['id']);
                                    } else {

                                        echo $admin->getProduct(isset($_GET['page']) && $_GET['page'] != "" ? (int) $_GET['page'] : 1, isset($_GET['cate']) && $_GET['cate'] != "" ? $_GET['cate'] : 0, isset($_GET['keySearch']) ? $_GET['keySearch'] : "");
                                    }
                                    break;
                                }
                        }

                        break;
                    }
                case "POST": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {
                                        echo   $admin->updateProduct($_GET, $_POST, $_FILES);
                                    } else {
                                        echo  $admin->insertProduct($_POST, $_FILES);
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
                            case "hiddenCate": {
                                    echo $admin->hiddenProductCate($_POST['id']);
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
                            case "cate": {
                                    echo json_encode($admin->delProductCate(isset($_GET['id']) && $_GET['id'] != 0 ? $_GET['id'] : ""));
                                    break;
                                }
                            case "productItem": {
                                    echo   json_encode(array("status" =>   $admin->delProductItem($_GET['id']) ? "success" : "failed"));
                                    break;
                                }
                        }
                        break;
                    }
            }
            break;
        }


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

                                    echo $admin->hiddenNews($_POST['id']);
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
                            case "hiddenCate": {
                                    echo $admin->hiddenNewsCate($_POST['id']);
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
                            case "cate": {
                                    echo json_encode($admin->delNewsCate(isset($_GET['id']) && $_GET['id'] != 0 ? $_GET['id'] : ""));
                                    break;
                                }
                        }
                        break;
                    }
            }
            break;
        }
    case "member": {

            switch ($method) {

                default: {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {
                                        echo json_encode(array("status" => "success", "data" => $User->getInfor($_GET['id'])));
                                    } else {

                                        echo $admin->viewListUser(isset($_GET['page']) && $_GET['page'] != "" ? (int) $_GET['page'] : 1, isset($_GET['keySearch']) ? $_GET['keySearch'] : "", isset($_GET['role']) ? $_GET['role'] : 0);
                                    }
                                    break;
                                }
                            case "role": {
                                    echo $admin->viewRoles();
                                    break;
                                }
                        }

                        break;
                    }
                case "POST": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {

                                        $admin->updateAvatar($_GET['id'], $_FILES['avatar']);
                                        $admin->updateUsername($_GET['id'], $_POST['username']);
                                        $admin->updatePhonenumber($_GET['id'], $_POST['phone']);
                                        $admin->updateAddress($_GET['id'], $_POST['address']);
                                        $admin->updateRole($_GET['id'], $_POST['role']);
                                        $admin->updateBalance($_GET['id'], $_POST['balance']);
                                        if (!empty($_POST['pswd'])) {
                                            $admin->updatePasswor($_GET['id'], md5($_POST['pswd']));
                                        }
                                        echo json_encode(array('success' => "success"));
                                    } else {
                                        echo $admin->userRegister($_POST['username'], $_POST['email'], $_POST['pswd'], $_POST['phone'], $_POST['address'], $_POST['role']);
                                    }
                                    break;
                                }
                        }
                        break;
                    }
                case "DELETE": {
                        switch (isset($_GET['type']) ? $_GET['type'] : "0") {
                            default: {
                                    if (isset($_GET['id'])) {
                                        echo $admin->deleteUser($_GET['id']);
                                    } else {
                                        // echo $admin->userRegister($_POST['username'], $_POST['email'], $_POST['pswd'], $_POST['phone'], $_POST['address'], $_POST['role']);
                                    }
                                    break;
                                }
                        }
                        break;
                    }
            }
            break;
        }
}
