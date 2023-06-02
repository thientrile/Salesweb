<?php

class cart
{
   function addCart($userId, $product_item_id)
   {
      $db = new connect();
      $product_id = $db->send("SELECT product_id FROM product_item WHERE id=$product_item_id")[0];
      $query = "insert into cart(`id`, `user_id`, `product_id`, `product_item_id`) values (NULL,$userId, $product_id,$product_item_id)";
      return $db->send($query);
   }
   function deletecart($id)
   {
      $db = new connect();
      $query = "delete from cart WHERE id=$id";
      return $db->send($query);
   }
   function countCart($userId)
   {
      $db = new connect();
      $select = "SELECT COUNT(*) FROM cart WHERE user_id=$userId";
      $result = $db->getonce($select);

      return $result;
   }
   //    kiểm tra xem sản phẩm đã thêm vào giỏ hàng chữa
   function checkCart($userId, $product_item_id)
   {
      $db = new connect();
      $select = "SELECT COUNT(*) FROM cart WHERE user_id=$userId and product_item_id=$product_item_id";
      $result = $db->getonce($select);
      if ($result['COUNT(*)'] == 0) {
         return false;
      }
      return true;
   }
   function viewCart($userId)
   {
      $db = new connect();
      $select = "select cart.id as id , product_id, title, img, discount  from cart, product where user_id=$userId and product_id=product.id";

      $result = $db->getlist($select);
      return $result;
   }
   function deleteOne($id)
   {
      $db = new connect();
      $query = "delete from cart where id=$id";
      return $db->send($query);
   }
   function deleteAll($userId)
   {
      $db = new connect();
      $query = "delete from cart where user_id=$userId";
      return $db->send($query);
   }
   function cartPrice($userId)
   {
      $result = $this->viewCart($userId);
      $sum = 0;

      while ($set = $result->fetch()) {
         $sum += $set['price'];
      }
      return $sum;
   }
   function cartDiscount($userId)
   {
      $result = $this->viewCart($userId);

      $discount = 0;
      while ($set = $result->fetch()) {

         $discount +=  $set['discount'] * $set['price'];
      }
      return $discount;
   }
}
