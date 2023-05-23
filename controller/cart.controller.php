<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST'  && isset($_SESSION["s_user"]) && !$Cart->checkCart($_SESSION["s_user"], $_POST['id'])) {

    $Cart->addCart($_SESSION["s_user"], $_POST['id']);
    echo json_encode(array("status" => "success"));
} elseif ($method == 'GET' && isset($_SESSION["s_user"])) {


    if (isset($_GET['id'])) {

        $result = $Cart->checkCart($_SESSION["s_user"], $_GET['id']);
        $array = array("result" => $result);
    } else {
        $array = array();
        $result = $Cart->viewCart($_SESSION["s_user"]);
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
    }
    echo json_encode($array);
} elseif ($method == 'PUT') {
} elseif ($method == 'DELETE') {
    if (isset($_GET['id'])) {

        echo json_encode(array("status" => $Cart->deleteOne($_GET['id'])));
    } else {
        echo json_encode(array("status" =>   $Cart->deleteAll($_SESSION["s_user"])));
    }
}
