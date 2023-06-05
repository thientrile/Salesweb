
<?php


if (isset($_GET['function']) && $_GET['function'] == "category") {
    $result = $product->viewCategory();
    $array = array();
    while ($row = $result->fetch()) {
        array_push($array, $row);
    }
    echo json_encode($array);
} else if (isset($_GET['id'])) {



    if (isset($_GET['function']) && $_GET['function'] == "gallery") {

        $result = $product->viewProductGallery($_GET['id']);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        echo json_encode($array);
    } else {


        echo $product->viewProductDetails($_GET['id']);
    }
} else if (isset($_GET['options'])) {

    echo $product->options($_GET['options']);
} else {



    $result =   $product->viewProduct(isset($_GET['page']) && $_GET['page'] != "" ? (int) $_GET['page'] : 1, isset($_GET['cate']) && $_GET['cate'] != "" ? $_GET['cate'] : 0, isset($_GET['keySearch']) ? $_GET['keySearch'] : "");

    echo $result;
}


?>