<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    if (!isset($_POST['id'])) {
        $resutl = $checkout->order();
        echo $resutl;
    }
} else {
    echo json_encode(true);
}
