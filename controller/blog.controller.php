<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method = "GET") {
    switch (isset($_GET['function']) ? $_GET['function'] : '0') {
        default: {
                if (isset($_GET['id'])) {
                    echo $News->viewNews($_GET['id']);
                } else {
                    echo $News->viewsNews(isset($_GET['view']) ? $_GET['view'] : 10, isset($_GET['keysearch']) ? $_GET['keysearch'] : "");
                }
                break;
            }
        case "cate": {
                echo $News->viewNewsCate();
                break;
            }
    }
} else {
    echo json_encode(array("status" => "failed", "message" => "not found function"));
}
