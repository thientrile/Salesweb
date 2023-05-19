<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method = "GET") {
    switch ($_GET['function']) {
        case "views": {
                if (isset($_GET['id'])) {
                    echo $News->viewNews($_GET['id']);
                    break;
                } else {
                    echo $News->viewsNews(isset($_GET['page']) ? $_GET['page'] : 1);
                    break;
                }
            }
        case "cate": {
                echo $News->viewNewsCate();
                break;
            }
    }
}else{
    echo json_encode(array("status"=>"failed", "message"=>"not found function"));
}
