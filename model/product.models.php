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
        $count =  $cc->getonce('SELECT COUNT(*) FROM `product`WHERE ' . $Where . '  AND deleted=0');

        $page = $pageNumber > 0 && ($pageNumber <= ceil($count[0] / $view)) ? $pageNumber : 1;

        $start = $view * $page - $view;
        $end = $view * $page;
        $select = "select product.id as id, title,img,source,category_id,description,sDescription, discount,price,created_at,updated_at, deleted, category.name as name from product,category WHERE $Where  AND deleted=0 AND product.category_id=category.id LIMIT $start,$end";
        $this->countpage = ceil($count[0] / $view);

        return $cc->getlist($select);
    }
    function viewProductDetails($productsId)
    {
        $cc = new connect();
        $result = $cc->getonce("select product.id as id, title,img,source,category_id,description,sDescription, discount,price,created_at,updated_at, deleted, category.name as name from product,category where product.category_id=category.id AND product.id=" . $productsId);
        return $result;
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
    function viewCategory($cateId = 0, $limted = 4)
    {
        $db = new connect();
        if ($cateId == 0) {

            $result = $db->getlist("SELECT * FROM `category` LIMIT " . $limted);
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
