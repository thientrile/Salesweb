<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST' && isset($_GET['id']) && isset($_SESSION["s_user"])) {
    $Cart->addCart($_SESSION["s_user"], $_GET['id']);
} elseif ($method == 'GET' && isset($_SESSION["s_user"])) {
    $array = array();
    $result = $Cart->viewCart($_SESSION["s_user"]);
    while ($row = $result->fetch()) {
        array_push($array, $row);
    }
    echo json_encode($array);
} elseif ($method == 'PUT') {
} elseif ($method == 'DELETE') {
    // Method is DELETE
}
