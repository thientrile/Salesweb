<?php
class invoice
{
    var $userId = null;
    var $orderId = 0;
    var $check = false;
    var $countLibary = 1;
    var $countOrder = 1;
    function __construct($userId)
    {
        $this->userId = $userId;
    }
    function order()
    {
        $db = new connect();
        $cart = new cart();
        $total = $cart->cartPrice($this->userId) - $cart->cartDiscount($this->userId);
        $user = new user();
        $balance = $user->getInfor($this->userId)[3];
        if ($balance - $total >= 0) {
            $insert = "INSERT INTO `order` (`id`, `total`, `user_id`, `date_order`) VALUES (NULL, $total, $this->userId, current_timestamp())";
            $db->send($insert);
            $select = "SELECT MAX(id) FROM `order`";
            $result = $db->getonce($select);
            $this->orderId = $result[0];
            $c = $cart->viewCart($this->userId);
            while ($item = $c->fetch()) {
                $inserts = "INSERT INTO `order_details`(`id`, `order_id`, `product_id`, `product_item_id`, `price`, `discount`) VALUES (NULL,$this->orderId,$item[1],$item[2],$item[5],$item[6])";
                $db->send($inserts);
            }
            $update = "UPDATE user SET balance=balance-$total WHERE id=$this->userId";
            $db->send($update);
            $cart->deleteAll($this->userId);
            return json_encode(array("status" => "success", "message" => "Payment success", "orderId" => $this->orderId));
        } else {
            return json_encode(array("status" => "fail", "message" => "Please add more money to your account"));
        }
    }
    function order_One($product_item_id)
    {
        $db = new connect();
        $row = $db->getonce("SELECT price, discount, product_id, product_item.id FROM `product_item` RIGHT JOIN product ON product_id=product.id WHERE product_item.id=$product_item_id");
        $price = $row['price'];
        $discount = $row['discount'];
        $total = $price - $price * $discount;
        $user = new user();
        $balance = $user->getInfor($this->userId)[3];
        if ($balance - $total >= 0) {
            $insert = "INSERT INTO `order` (`id`, `total`, `user_id`, `date_order`) VALUES (NULL, $total, $this->userId, current_timestamp())";
            $db->send($insert);
            $select = "SELECT MAX(id) FROM `order`";
            $result = $db->getonce($select);
            $this->orderId = $result[0];
          
            $inserts = "INSERT INTO `order_details`(`id`, `order_id`, `product_id`, `product_item_id`, `price`, `discount`) VALUES (NULL,$this->orderId,$row[2],$row[3],$price,$discount)";
            $db->send($inserts);

            $update = "UPDATE user SET balance=balance-$total WHERE id=$this->userId";
            $db->send($update);
            $query = "delete from cart where user_id=$this->userId and product_item_id=$product_item_id";
            $db->send($query);
            return json_encode(array("status" => "success", "message" => "Payment success", "orderId" => $this->orderId));
        } else {
            return json_encode(array("status" => "fail", "message" => "Please add more money to your account"));
        }
    }
    // Libary
    function check_Library($product_item_id)
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM `order_details` WHERE product_item_id=" . $product_item_id . " and order_id IN( SELECT id FROM `order` WHERE user_id=" . $this->userId . ")";
        $result = $db->getonce($select);
        return  $result[0] > 0;
    }
    function view_Library($currentPage = 1)
    {
        $db = new connect();
        $start = 6 * $currentPage - 6;
        $end = 6 * $currentPage;
        $select = "SELECT product.id as id, title,img,source,category_id, price,created_at,updated_at, deleted, category.name as name FROM product,category WHERE  product.id IN (SELECT product_id FROM `order_details` WHERE  order_id IN( SELECT id FROM `order` WHERE user_id=" . $this->userId . "))AND product.category_id=category.id  LIMIT $start,$end";
        $this->countLibary = ceil($db->getonce("SELECT COUNT(*) FROM product WHERE id IN (SELECT product_id FROM `order_details` WHERE  order_id IN( SELECT id FROM `order` WHERE user_id=" . $this->userId . ")) ")[0] / 6);
        $result = $db->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        return json_encode(array("status" => "success", "data" => $array, "page" => $this->countLibary));
    }
    function view_Order($currentPage = 1)
    {

        $db = new connect();
        $start = 6 * $currentPage - 6;

        $select = "SELECT * FROM `order`WHERE user_id=" . $this->userId . " ORDER BY date_order DESC LIMIT $start,6";
        $this->countOrder = ceil($db->getonce("SELECT count(*) FROM `order`WHERE user_id=" . $this->userId . " ORDER BY date_order DESC ")[0] / 6);
        $result = $db->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        return json_encode(array("status" => "succsee", "data" => $array, "page" => $this->countOrder));
    }
    function view_OrderDetail($orderId)
    {
        $db = new connect();
        $select = "SELECT product_id as id, title ,order_details.price, order_details.discount ,img FROM product, order_details WHERE order_details.order_id=$orderId AND product.id=order_details.product_id";
        $result = $db->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        return json_encode($array);
    }
}
