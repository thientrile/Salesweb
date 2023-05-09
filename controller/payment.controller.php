<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {

    if (isset($_POST['id'])) {
        $resutl = $checkout->order_One($_POST['id'], $_POST['discount'], $_POST['price']);
        echo $resutl;
    } else {
        $resutl = $checkout->order();
        echo $resutl;
    }
} elseif ($method == 'GET') {
    if (isset($_GET['function'])) {
        switch ($_GET['function']) {
            case "check_Library":
                $resutl = $checkout->check_Library($_GET['id']);
                echo $resutl;
                break;
            case "blue":
                echo "Your favorite color is blue!";
                break;
            case "green":
                echo "Your favorite color is green!";
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }
}
