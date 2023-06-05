<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST'  && isset($_SESSION["s_user"])) {


    echo json_encode(array("status" => $Cart->addCart($_SESSION["s_user"], $_POST['id']) ? "success" : "failed"));
} elseif ($method == 'GET' && isset($_SESSION["s_user"])) {


    if (isset($_GET['id'])) {

        $result = $Cart->checkCart($_SESSION["s_user"], $_GET['id']);
        $array = array("result" => $result);
        echo json_encode($array);
    } else {
        $array = array();
        $result = $Cart->viewCart($_SESSION["s_user"]);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, array("id" => $row['id'], "title" => $row['title'], "img" => $row['img'], "price" => $row['price'], "discount" => $row['discount'], "variation" => $row['name'] . " " . $row['value']));
        }
        echo json_encode($array);
    }
} elseif ($method == 'PUT') {
} elseif ($method == 'DELETE') {
    if (isset($_GET['id'])) {

        echo json_encode(array("status" => $Cart->deleteOne($_GET['id'])));
    } else {
        echo json_encode(array("status" =>   $Cart->deleteAll($_SESSION["s_user"])));
    }
}
