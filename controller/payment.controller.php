<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {

    if (isset($_POST['id'])) {
        $result = $checkout->order_One($_POST['id']);
        echo $result;
    } else {
        $resutl = $checkout->order();
        echo $resutl;
    }
} elseif ($method == 'GET') {
    if (isset($_GET['function'])) {
        switch ($_GET['function']) {
            case "check_Library":
                $resutl = $checkout->check_Library($_GET['id']);
                echo json_encode(array("status" => "success", "message" => $resutl));
                break;
            case "view_Library":
                $result = $checkout->view_Library(isset($_GET['page']) ? $_GET['page'] : 1);
                echo  $result;
                break;
            case "order":
                if (isset($_GET['id'])) {
                    echo $checkout->view_OrderDetail($_GET['id']);
                } else {
                    echo $checkout->view_Order(isset($_GET['page']) ? $_GET['page'] : 1);
                }
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }
}
