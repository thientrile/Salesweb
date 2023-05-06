<?php

class cart
{
   function addCart($userId, $id)
   {
      $db = new connect();
      $query = "insert into cart(id, user_id, product_id) values (NULL,$userId,$id)";
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
   function checkCart($userId, $id)
   {
      $db = new connect();
      $select = "SELECT COUNT(*) FROM cart WHERE user_id=$userId and product_id=$id";
      $result = $db->getonce($select);
      if ($result['COUNT(*)'] == 0) {
         return false;
      }
      return true;
   }
   function viewCart($userId)
   {
      $db = new connect();
      $select = "select *  from cart, product where user_id=$userId and product_id=product.id";

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
         $sum += $set[11];
      }
      return $sum;
   }
   function cartDiscount($userId)
   {
      $result = $this->viewCart($userId);

      $discount = 0;
      while ($set = $result->fetch()) {

         $discount +=  $set[10] * $set[11];
      }
      return $discount;
   }
}
