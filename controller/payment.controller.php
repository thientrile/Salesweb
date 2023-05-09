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
}
