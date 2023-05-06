<?php
class invoice
{
    var $userId = null;
    var $orderId = 0;
    var $check = false;
    var $countLibary=1;
    var $countOrder=1;
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
                $inserts = "INSERT INTO `order_details`(`id`, `order_id`, `product_id`, `price`, `discount`) VALUES (NULL,$this->orderId,$item[2],$item[11],$item[10])";
                $db->send($inserts);
            }
            $update = "UPDATE user SET balance=balance-$total WHERE id=$this->userId";
            $db->send($update);
            $cart->deleteAll($this->userId);
            echo "<script>alert('thanh toán thành công');</script>";
            echo '<meta http-equiv="refresh" content="0; url=index.php?action=home"/>';
        } else {
            echo "<script>alert('vui lòng nạp thêm tiền');</script>";
            echo '<meta http-equiv="refresh" content="0; url=index.php?action=cart"/>';
        }
    }
    function order_One($product_id, $discount, $price)
    {
        $db = new connect();
        
        $total = $price - $price * $discount;
        $user = new user();
        $balance = $user->getInfor($this->userId)[3];
        if ($balance - $total >= 0) {
            $insert = "INSERT INTO `order` (`id`, `total`, `user_id`, `date_order`) VALUES (NULL, $total, $this->userId, current_timestamp())";
            $db->send($insert);
            $select = "SELECT MAX(id) FROM `order`";
            $result = $db->getonce($select);
            $this->orderId = $result[0];
            // echo $this->orderId;

            $inserts = "INSERT INTO `order_details`(`id`, `order_id`, `product_id`, `price`, `discount`) VALUES (NULL,$this->orderId,$product_id,$price,$discount)";
            $db->send($inserts);

            $update = "UPDATE user SET balance=balance-$total WHERE id=$this->userId";
            $db->send($update);
            $query = "delete from cart where user_id=$this->userId and product_id=$product_id";
            $db->send($query);
            echo "<script>alert('thanh toán thành công');</script>";
            echo '<meta http-equiv="refresh" content="0; url=index.php?action=shop&act=detail&id=' . $product_id . '"/>';
        } else {
            echo "<script>alert('vui lòng nạp thêm tiền');</script>";
            echo '<meta http-equiv="refresh" content="0; url=index.php?action=shop&act=detail&id=' . $product_id . '"/>';
        }
    }
    function check_Libary( $product_id)
    {
        $db = new connect();
        $select="SELECT COUNT(*) FROM `order_details` WHERE product_id=".$product_id." and order_id IN( SELECT id FROM `order` WHERE user_id=".$this->userId.")";
        $result=$db->getonce($select);
        return $result[0]>0?true:false;
    }
    function view_Libary($currentPage = 1){
        $db = new connect();
        $start = 6 * $currentPage - 6;
        $end = 6 * $currentPage;
        $select="SELECT * FROM product WHERE id IN (SELECT product_id FROM `order_details` WHERE  order_id IN( SELECT id FROM `order` WHERE user_id=".$this->userId."))  LIMIT $start,$end";
        $this->countLibary=ceil($db->getonce("SELECT COUNT(*) FROM product WHERE id IN (SELECT product_id FROM `order_details` WHERE  order_id IN( SELECT id FROM `order` WHERE user_id=" . $this->userId . ")) ")[0]/6);
        $result=$db->getlist($select);
        return $result;
    }
    function view_Order($currentPage=1){

        $db=new connect();
        $start = 6 * $currentPage - 6;
        $end = 6 * $currentPage;
        $select="SELECT * FROM `order`WHERE user_id=".$this->userId. " ORDER BY date_order DESC LIMIT $start,$end";
        $this->countOrder=ceil($db->getonce("SELECT count(*) FROM `order`WHERE user_id=" . $this->userId . " ORDER BY date_order DESC ")[0]/6);
        $result=$db->getlist($select);
        return $result;
    }
    function view_OrderDetail($orderId)
    {
        $db=new connect();
        $select="SELECT title, img, id FROM `product` WHERE id IN(SELECT product_id FROM order_details WHERE order_id=".$orderId.")";        
        $result=$db->getlist($select);
        return $result;
    }
}
