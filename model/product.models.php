<?php
class product
{
    var $countpage = 1;
    function viewProduct($pageNumber = 1, $cate = 0, $keyword = "", $view = 6)
    {
        $cc = new connect();

        $Where = "1=1";
        if ($cate != 0) {
            $Where .= " AND category_id=$cate";
        }

        if ($keyword != "") {
            $Where .= " AND title LIKE '%$keyword%'";
        }
        $count =  $cc->getonce('SELECT COUNT(*) FROM `product`WHERE ' . $Where . '  AND deleted=0 AND hide=0');


        $start = ($pageNumber - 1) * $view;

        $select = "select product.id as id, title,img,category_id,description,sDescription, discount,created_at,updated_at, category.name as name from product,category WHERE $Where   AND product.category_id=category.id AND deleted=0 AND hide=0 ORDER BY position ASC LIMIT $start,$view";
        $this->countpage = ceil($count[0] / $view);

        $result = $cc->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            $select_items = "SELECT * FROM `product_item` WHERE product_id=" . $row['id'];
            $resutl_items = $cc->getlist($select_items);
            $option = array();
            while ($item = $resutl_items->fetch()) {
                $check = false;
                if (isset($_SESSION['s_user'])) {
                    $checkLibary = new invoice($_SESSION['s_user']);
                    $check = $checkLibary->check_Library($item['id']);
                }
                array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'], "checked" =>  $check));
            }
            if (sizeof($option) > 1) {
                $option = array();
                $select_items = "SELECT product_item.id, price,sources,name,value  FROM `product_item` LEFT JOIN product_cofiguration ON product_item.id=product_cofiguration.product_item_id LEFT JOIN
                variation_option ON product_cofiguration.variation_option_id= variation_option.id RIGHT JOIN variation ON variation.id=variation_option.variation_id WHERE product_id=" . $row['id'];
                $resutl_items = $cc->getlist($select_items);
                while ($item = $resutl_items->fetch()) {
                    $check = false;
                    if (isset($_SESSION['s_user'])) {
                        $checkLibary = new invoice($_SESSION['s_user']);
                        $check = $checkLibary->check_Library($item['id']);
                    }
                    array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'], "name" => $item['name'], "value" => $item['value'], "checked" => $check));
                }
            }
            array_push($array, array("id" => $row['id'], "title" => $row['title'], "img" => $row['img'], "discount" => $row['discount'], "name" => $row['name'], "options" => $option, "multiple" => sizeof($option) > 1));
        }
        echo json_encode(array("status" => "success", "data" => $array, "page" => ceil($count[0] / $view)));
    }
    function viewProductDetails($productsId)
    {
        $cc = new connect();
        $result = $cc->getonce("select product.id as id, title,img,category_id,description,sDescription, discount,created_at,updated_at, category.name as name from product,category where product.category_id=category.id AND product.id=" . $productsId);
        $select_items = "SELECT * FROM `product_item` WHERE product_id=" . $productsId;
        $resutl_items = $cc->getlist($select_items);
        // echo json_encode($resutl_items);
        $option = array();
        while ($item = $resutl_items->fetch()) {
            $check = false;
            if (isset($_SESSION['s_user'])) {
                $checkLibary = new invoice($_SESSION['s_user']);
                $check = $checkLibary->check_Library($item['id']);
            }
            array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'],"check" => $check));
        }
        if (sizeof($option) > 1) {
            $option = array();
            $select_items = "SELECT product_item.id, price,sources,name,value  FROM `product_item` LEFT JOIN product_cofiguration ON product_item.id=product_cofiguration.product_item_id LEFT JOIN
            variation_option ON product_cofiguration.variation_option_id= variation_option.id RIGHT JOIN variation ON variation.id=variation_option.variation_id WHERE product_id=$productsId";
            $resutl_items = $cc->getlist($select_items);
            while ($item = $resutl_items->fetch()) {
                $check = false;
                if (isset($_SESSION['s_user'])) {
                    $checkLibary = new invoice($_SESSION['s_user']);
                    $check = $checkLibary->check_Library($item['id']);
                }
                array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'], "name" => $item['name'], "value" => $item['value'],"check" => $check));
            }
        }
        return json_encode(array("id" => $result['id'], "title" => $result['title'], "img" => $result['img'], "category_id" => $result['category_id'], "sDescription" => $result['sDescription'], "description" => $result['description'], "discount" => $result['discount'], "created_at" => $result['created_at'], "updated_at" => $result['updated_at'], "name" => $result['name'], "image" => $result['img'], "options" => $option, "multiple" => sizeof($option) > 1));
    }
    function viewProductGallery($productsId)
    {
        $cc = new connect();
        $result
            = $cc->getlist("select * from gallery where  product_id =" . $productsId);
        return $result;
    }
    function countProductGallery($productsId)
    {
        $cc = new connect();
        $result
            = $cc->getonce("select COUNT(*) from gallery where product_id =" . $productsId);
        return $result;
    }
    function viewCategory($cateId = 0)
    {
        $db = new connect();
        if ($cateId == 0) {

            $result = $db->getlist("SELECT * FROM `category` where 1");
        } else {
            $result = $db->getonce("SELECT * FROM `category` WHERE id=" . $cateId);
        }
        return
            $result;
    }
    function countCategory($cateId)
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM `product` WHERE `category_id`=$cateId AND `deleted`=0";
        $result = $db->getonce($select);
        return $result;
    }
}
