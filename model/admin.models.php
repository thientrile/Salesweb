<?php
class admin
{
    var $countOrder = 1;
    var $check = false;
    var $userid = null;
    var $countpage = 1;
    var $role = "";
    var $hiddenProductUpdate = true;
    var $hiddenProductImport = true;
    var $hiddenProductDelete = true;
    var $hiddenMemberUpdate = true;
    var $hiddenMemberImport = true;
    var $hiddenMemberDelete = true;

    function __construct($userid)
    {
        $userInfor = new user();
        $this->userid = $userid;
        $this->check = $userInfor->getInfor($userid)[8] != 2;
        $this->role = $userInfor->getInfor($userid)[8];
        switch ($this->role) {
            case 1: {
                    $this->hiddenProductUpdate = false;
                    $this->hiddenProductImport = false;
                    $this->hiddenProductDelete = false;
                    $this->hiddenMemberUpdate = false;
                    $this->hiddenMemberImport = false;
                    $this->hiddenMemberDelete = false;

                    break;
                }
            case 3: {
                    $this->hiddenMemberUpdate = false;
                    $this->hiddenMemberImport = false;
                    $this->hiddenMemberDelete = false;
                    break;
                }
            case 4: {
                    $this->hiddenProductUpdate = false;
                    $this->hiddenProductImport = false;
                    $this->hiddenProductDelete = false;
                    break;
                }
            case 5: {
                    $this->hiddenMemberUpdate = false;

                    break;
                }
            case 6: {
                    $this->hiddenProductUpdate = false;
                    break;
                }
            case 7: {
                    $this->hiddenMemberImport = false;
                    break;
                }
            case 8: {
                    $this->hiddenProductImport = false;
                    break;
                }
            case 9: {
                    $this->hiddenMemberDelete = false;
                    break;
                }
            case 10: {
                    $this->hiddenProductDelete = false;
                    break;
                }
        }
    }
    // Admin user || member
    // new user
    function checkEmailExit($email)
    {
        // check exist
        $db = new connect();
        $email = strtolower($email);
        $check = $db->getlist("select * from user where email='$email'and deleted=0");
        $set = $check->fetch();
        return $set;
    }
    // đăng ký
    function userRegister($username, $email, $pass, $phonenumber = null, $address = null, $type)
    {
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 7)) {
            $db = new connect();
            $pass = md5($pass);
            // check exist
            $email = strtolower($email);
            if ($this->checkEmailExit($email) == false) {

                $query = "insert into user(id, avatar, fullname, balance, email, phone_number, address, pass, role_id, deleted) values (NULL,default,'$username',default,'$email','$phonenumber','$address','$pass','$type',default)";
                $db->send($query);
                $select = "SELECT id FROM `user` where email = '$email' and deleted=0";
                $db->getonce($select);
                mkdir("assets/user/" . md5($db->getonce($select)[0]), 0700);
                mkdir("assets/user/" . md5($db->getonce($select)[0]) . "/avatar", 0700);
                copy("assets/avatar/people.png", "assets/user/" . md5($db->getonce($select)[0]) . "/avatar/people.png");
                return true;
            }
        }

        return false;
    }
    // display list all users
    function viewListUser($pageNumber = 1, $keyword = "", $role_id = "")
    {
        $db = new connect();

        $result = null;
        if ($this->check) {
            $Where = "1=1";
            if ($keyword != "") {
                $Where .= " AND (fullname LIKE '%$keyword%' OR email LIKE '%$keyword%' or id LIKE '%$keyword%')";
            }
            if ($role_id != "") {
                $Where .= " AND role_id='$role_id'";
            }
            if ($this->role % 2 == 0) {
                $Where .= " AND role_id =2";
            } else  if ($this->role == 3) {
                $Where .= " AND role_id >1";
            } else if ($this->role > 3) {
                $Where .= " AND role_id >3";
            }
            $count = $db->getonce("SELECT COUNT(*) FROM `user` WHERE $Where and deleted =0 and id <>" . $this->userid);
            $page = $pageNumber > 0 && ($pageNumber <= ceil($count[0] / 6)) ? $pageNumber : 1;

            $start = 6 * $page - 6;
            $end = 6 * $page;
            $select = "SELECT * FROM `user` WHERE $Where and deleted =0 and id <>" . $this->userid . " LIMIT $start,$end";

            $result = $db->getlist($select);
            $this->countpage = ceil($count[0] / 6);
        }
        return $result;
    }
    // show account permissions
    function viewRole($roleid)
    {
        $db = new connect();
        $result = null;
        if ($this->check) {

            $select = "SELECT * FROM `role` WHERE id=" . $roleid;
            $result = $db->getonce($select);
        }
        return $result;
    }
    // display all the role permissions
    function viewRoles()
    {
        $result = null;
        if ($this->check) {
            $db = new connect();
            if ($this->check) {
                $Where = "1=1";
                if ($this->role % 2 == 0) {
                    $Where .= " AND id =2";
                } else  if ($this->role == 3) {
                    $Where .= " AND id >1";
                } else if ($this->role > 3) {
                    $Where .= " AND id >3";
                }


                $select = "SELECT * FROM `role` WHERE $Where";
                $result = $db->getlist($select);
            }
        }
        return $result;
    }

    // delete account
    function deleteUser($userid)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 9)) {
            $update = "UPDATE `user` SET `deleted`=1 WHERE id=" . $userid;
            $result = $db->send($update);
        }
        return $result;
    }
    // update avatar user
    function updateAvatar($id, $file)
    {
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5)) {

            $target_dir = "assets/user/" . md5($id) . "/avatar/";
            $target_file = $target_dir . basename($file["name"]);

            move_uploaded_file($file["tmp_name"], $target_file);
            $update = "UPDATE `user` SET avatar='" . $file["name"] . "' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    function updateUsername($id, $username)
    {
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5)) {
            $update = "UPDATE `user` SET `fullname`='$username' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    function updatePhonenumber($id, $phonenumber)
    {

        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5)) {
            $update = "UPDATE `user` SET `phone_number`='$phonenumber' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    function updateAddress($id, $address)
    {

        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5)) {
            $update = "UPDATE `user` SET `address`='$address' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    function updateRole($id, $roleid)
    {

        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5)) {
            $update = "UPDATE `user` SET `role_id`='$roleid' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    // Admin Proudct
    // insert product
    function insertProduct($title, $fileAvatar, $fileSrc, $cate, $desc, $sdesc, $discount, $price, $filesGallery)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 8)) {
            $insert = "INSERT INTO `product`(`id`, `title`, `img`, `source`, `category_id`, `description`, `sDescription`, `discount`, `price`, `created_at`, `updated_at`, `deleted`) VALUES ('NULL','$title','" . $fileAvatar['name'] . "','" . $fileSrc['name'] . "','$cate','$desc','$sdesc','$discount','$price',default,default,default)";
            $result = $db->send($insert);
            $product_id = $db->getonce("SELECT MAX(id) FROM `product`")[0];

            mkdir("assets/products/" . md5($product_id), 0700);
            mkdir("assets/products/" . md5($product_id) . "/img", 0700);

            move_uploaded_file($fileAvatar["tmp_name"], "assets/products/" . md5($product_id) . "/img/" . basename($fileAvatar["name"]));
            mkdir("assets/products/" . md5($product_id) . "/src", 0700);
            move_uploaded_file($fileSrc["tmp_name"], "assets/products/" . md5($product_id) . "/src/" . basename($fileSrc["name"]));
            // add gallery
            mkdir("assets/products/" . md5($product_id) . "/gallery", 0700);


            foreach ($filesGallery['tmp_name'] as $key => $tmp_name) {
                $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$product_id','" . $filesGallery["name"][$key] . "','" . pathinfo($filesGallery["name"][$key], PATHINFO_EXTENSION) . "')";
                $db->send($insert);
                move_uploaded_file($tmp_name, "assets/products/" . md5($product_id) . "/gallery/" . basename($filesGallery["name"][$key]));
            }
        }
        return $result;
    }
    // delted product
    function deleteProduct($proudctid)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 10)) {
            $update = "UPDATE `product` SET `deleted`=1 WHERE id=" . $proudctid;
            $result = $db->send($update);
        }
        return $result;
    }
    function updateProduct($id, $title, $fileAvatar, $fileSrc, $cate, $desc, $sdesc, $discount, $price, $filesGallery)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 6)) {
            $current_time = date("Y-m-d H:i:s");
            $up = " `title`='$title',`category_id`='$cate',`description`='$desc',`sDescription`='$sdesc',`discount`='$discount',`price`=' $price',`updated_at`=' $current_time'";
            $product_id = $id;
            if ($fileAvatar['name'] != "") {
                $up .= ",`img`='" . $fileAvatar['name'] . "'";
                move_uploaded_file($fileAvatar["tmp_name"], "assets/products/" . md5($product_id) . "/img/" . basename($fileAvatar["name"]));
            }
            if ($fileSrc['name'] != "") {
                $up .= ",`source`" . $fileSrc['name'] . "'";
                move_uploaded_file($fileSrc["tmp_name"], "assets/products/" . md5($product_id) . "/src/" . basename($fileSrc["name"]));
            }
            $update = "UPDATE `product` SET $up  WHERE id=" . $id;
            $result = $db->send($update);








            foreach ($filesGallery['tmp_name'] as $key => $tmp_name) {
                if ($filesGallery["name"][$key] != "") {

                    $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$product_id','" . $filesGallery["name"][$key] . "','" . pathinfo($filesGallery["name"][$key], PATHINFO_EXTENSION) . "')";
                    $db->send($insert);
                    move_uploaded_file($tmp_name, "assets/products/" . md5($product_id) . "/gallery/" . basename($filesGallery["name"][$key]));
                }
            }
        }
        return $result;
    }
    function delGallery($id)
    {
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 6)) {

            $db = new connect();
            $db->send("DELETE FROM `gallery` WHERE id=" . $id);
        }
    }
    function view_Order($year="",$month="",$currentPage = 1)
    {
        if ($this->check) {
            $db = new connect();
            $start = 6 * $currentPage - 6;
            $end = 6 * $currentPage;
            $Where="1=1";
            if($month!=""){
                $Where.= " AND MONTH(date_order)=" . $month;
            }
            if($year!=""){
                $Where .= " AND YEAR(date_order)=" . $year;
            }
            $select = "SELECT * FROM `order`WHERE  $Where ORDER BY date_order DESC LIMIT $start,$end";
            $this->countOrder = ceil($db->getonce("SELECT count(*) FROM `order`WHERE  $Where ORDER BY date_order DESC ")[0] / 6);
            $result = $db->getlist($select);
            return $result;
        }
        return null;
    }
    function view_OrderDetail($orderId)
    {   if($this->check){
        $db = new connect();
        $select = "SELECT title, img, id FROM `product` WHERE id IN(SELECT product_id FROM order_details WHERE order_id=" . $orderId . ")";
        $result = $db->getlist($select);
        return $result;
        }
        return null;
    }
}
