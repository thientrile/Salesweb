<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method = "GET") {
    switch (isset($_GET['function'])?$_GET['function']:'0') {
        default: {
                if (isset($_GET['id'])) {
                    echo $News->viewNews($_GET['id']);
              
                } else {
                    echo $News->viewsNews(isset($_GET['page']) ? $_GET['page'] : 1);
                  
                }
                break;
            }
        case "cate": {
                echo $News->viewNewsCate();
                break;
            }
    }
}else{
    echo json_encode(array("status"=>"failed", "message"=>"not found function"));
}
