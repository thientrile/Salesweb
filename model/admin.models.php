<?php
class admin
{
    var $countOrder = 1;
    var $check = false;
    var $userid = null;
    var $countpage = 1;
    var $role = "";


    function __construct($userid)
    {
        $userInfor = new user();
        $this->userid = $userid;
        $this->check = $userInfor->getInfor($userid)['role_id'] != 2;
        $this->role = $userInfor->getInfor($userid)['role_id'];
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
                $result = $db->send($query);
                $select = "SELECT id FROM `user` where email = '$email' and deleted=0";
                $db->getonce($select);
                mkdir("assets/user/" . md5($db->getonce($select)[0]), 0700);
                mkdir("assets/user/" . md5($db->getonce($select)[0]) . "/avatar", 0700);
                return json_encode(array("status" => $result ? "success" : "failed"));
            }
        }

        return json_encode(array("status" =>  "failed"));;
    }
    // display list all users
    function viewListUser($pageNumber = 1, $keyword = "", $role_id = 0)
    {
        $db = new connect();
        $result = null;
        $views = 6;
        if ($this->check) {
            $Where = "1=1";
            if ($keyword != "") {
                $Where .= " AND (fullname LIKE '%$keyword%' OR email LIKE '%$keyword%' or user.id LIKE '%$keyword%')";
            }
            if ($role_id != 0) {
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
            $page = $pageNumber > 0 && ($pageNumber <= ceil($count[0] / $views)) ? $pageNumber : 1;
            $start =  $views * $page -  $views;
            $select = "SELECT user.id as id, avatar, fullname,balance,email,phone_number,address,role_id,role.name as roleName, deleted FROM `user`,`role` WHERE $Where and user.role_id=role.id  and deleted =0 and user.id <>" . $this->userid . " LIMIT $start, $views";
            $result = $db->getlist($select);
            $this->countpage = ceil($count[0] /  $views);
            $arrray = array();
            while ($row = $result->fetch()) {
                array_push($arrray, $row);
            }
        }
        return json_encode(array("status" => "success", "data" => $arrray, "page" => $this->countpage));
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
                $array = array();
                while ($row = $result->fetch()) {
                    array_push($array, $row);
                }
            }
        }
        return json_encode(array("stauts" => "success", "data" => $array));
    }

    // delete account
    function deleteUser($userid)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 9)) {
            $update = "UPDATE `user` SET `deleted`= " . time() . " WHERE id= $userid;";
            $result = $db->send($update);
        }
        return json_encode(array("status" => $result ? "success" : "failed"));
    }
    // update avatar user

    function updateAvatar($id, $file)
    {
        if ($this->check && ($this->role == 1 || $this->role == 3 || $this->role == 5) && !empty($file['name'])) {

            $target_dir = "assets/user/" . md5($id) . "/avatar/";
            $target_file = $target_dir . basename($file["name"]);

            move_uploaded_file($file["tmp_name"], $target_file);
            $update = "UPDATE `user` SET avatar='assets/user/" . md5($id) . "/avatar/" . $file["name"] . "' WHERE id=" . $id;
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
    function updatePasswor($id, $pwsd)
    {
        $pwsd = md5($pwsd);
        $update = "UPDATE `user` SET `pass`='$pwsd' WHERE id=" . $id;
        $db = new connect();
        $db->send($update);
    }
    function updateBalance($id, $balance)
    {
        if ($balance >= 0) {

            $update = "UPDATE `user` SET `balance`='$balance' WHERE id=" . $id;
            $db = new connect();
            $db->send($update);
        }
    }
    // Admin Proudct
    function getProduct($pageNumber = 1, $cate = 0, $keyword = "", $view = 10)
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


        $start = ($pageNumber - 1) * $view;

        $select = "select product.id as id, title,img,category_id, discount, category.name as name,hide from product,category WHERE $Where   AND product.category_id=category.id AND deleted=0  ORDER BY position ASC LIMIT $start,$view";
        $this->countpage = ceil($count[0] / $view);

        $result = $cc->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {

            $product_id = $row['id'];
            $option = array();
            $select_items = "SELECT price FROM product_item WHERE product_id=$product_id AND deleted=0 LIMIT 2";
            $resutl_items = $cc->getlist($select_items);
            while ($item = $resutl_items->fetch()) {


                array_push($option, array("price" => $item['price']));
            }

            array_push($array, array("id" => $row['id'], "title" => $row['title'], "img" => $row['img'], "discount" => $row['discount'], "name" => $row['name'], "hidden" => $row['hide'], "options" => $option, "multiple" => $resutl_items->rowCount() > 1));
        }
        return json_encode(array("status" => "success", "data" => $array, "page" => ceil($count[0] / $view)));
    }
    function viewProductDetails($productsId)
    {
        $cc = new connect();
        $result = $cc->getonce("select product.id as id, title,img,category_id,description,sDescription, discount,created_at,updated_at, category.name as name from product,category where product.category_id=category.id AND product.id=" . $productsId);




        $option = array();
        $select_items = "SELECT DISTINCT product_item.id, price,sources  FROM `product_item` LEFT JOIN product_cofiguration ON product_item.id=product_cofiguration.product_item_id LEFT JOIN
            variation_option ON product_cofiguration.variation_option_id= variation_option.id LEFT JOIN variation ON variation.id=variation_option.variation_id WHERE deleted=0 AND product_id=$productsId";
        $resutl_items = $cc->getlist($select_items);
        while ($item = $resutl_items->fetch()) {
            $product_items_id = $item['id'];
            $name = array();
            $result_name = $cc->getlist("SELECT name FROM variation WHERE id in (SELECT DISTINCT variation_id FROM `variation_option` WHERE variation_option.product_item_id=$product_items_id)");
            while ($itemName = $result_name->fetch()) {
                array_push($name, $itemName[0]);
            }
            $name = implode(' x ', $name);
            $value = array();
            $result_value = $cc->getlist("SELECT value FROM `variation_option` WHERE product_item_id=$product_items_id");
            while ($itemValue = $result_value->fetch()) {
                array_push($value, $itemValue[0]);
            }
            $value = implode("_", $value);
            array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'], "name" => $name, "value" =>  $value));
        }


        return json_encode(array("id" => $result['id'], "title" => $result['title'], "img" => $result['img'], "category_id" => $result['category_id'], "sDescription" => $result['sDescription'], "description" => $result['description'], "discount" => $result['discount'], "created_at" => $result['created_at'], "updated_at" => $result['updated_at'], "name" => $result['name'], "image" => $result['img'], "options" => $option, "multiple" => $resutl_items->rowCount() > 1));
    }
    // get variables

    function insertProduct($post, $files)
    {
        $db = new connect();
        $id = $db->getonce("SELECT MAX(id) FROM product")[0] + 1;
        $title = $post['title'];
        $img = "assets/products/" . md5($id) . "/img/" . uniqid() . '.' . pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
        $category_id = $post['category'];
        $desc = $post['desc'];
        $sdesc = $post['sdesc'];
        $discount = $post['discount'];
        $position = $db->getonce("SELECT COUNT(*) FROM product WHERE deleted=0")[0] + 1;
        $gallery = $files['gallery'];
        $insertProduct = "INSERT INTO `product`(`id`, `title`, `img`, `category_id`, `description`, `sDescription`, `discount`, `created_at`, `updated_at`, `deleted`, `hide`, `position`)       
            VALUES ('$id','$title','$img','$category_id','$desc','$sdesc','$discount',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'0','0',' $position ')";
        $check = $db->send($insertProduct);
        if ($check) {
            if (!is_dir("assets/products/" . md5($id))) {

                mkdir("assets/products/" . md5($id), 0700);
            }
            if (!is_dir("assets/products/" . md5($id) . "/img")) {
                mkdir("assets/products/" . md5($id) . "/img", 0700);
            }
            if (!is_dir("assets/products/" . md5($id) . "/gallery")) {

                mkdir("assets/products/" . md5($id) . "/gallery", 0700);
            }
            if (!is_dir("assets/products/" . md5($id) . "/src")) {

                mkdir("assets/products/" . md5($id) . "/src", 0700);
            }
            move_uploaded_file($files['avatar']['tmp_name'], $img);
            foreach ($gallery['tmp_name'] as $key => $tmp_name) {
                $thumnali = "assets/products/" . md5($id) . "/gallery/" .  uniqid() . '.' . pathinfo($gallery['name'][$key], PATHINFO_EXTENSION);
                $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$id',' $thumnali','" . pathinfo($gallery["name"][$key], PATHINFO_EXTENSION) . "')";
                $db->send($insert);
                move_uploaded_file($tmp_name, $thumnali);
            }
            $src = $files['src'];
            $dataJson = json_decode($post['variables'], true);
            for ($i = 0; $i < count($post['price']); $i++) {
                $price = $post['price'][$i];
                $sources = "assets/products/" . md5($id) . "/src/" . uniqid() . '.' . pathinfo($src['name'][$i], PATHINFO_EXTENSION);
                $db->send("INSERT INTO `product_item`(`id`, `product_id`, `price`, `sources`, `deleted`) VALUES ('NULL','$id',' $price ',' $sources','0')");

                $product_items = $db->getonce("SELECT MAX(id) FROM `product_item` WHERE 1")[0];
                move_uploaded_file($src['tmp_name'][$i], $sources);
                if (count($dataJson) > 0) {
                    $keys = array_keys($dataJson[$i]);
                    $parent_id = 0;
                    for ($j = 0; $j < count($keys); $j++) {
                        $name = $keys[$j];
                        $value = $dataJson[$i][$keys[$j]];
                        if ($db->getonce("SELECT  COUNT(id) FROM `variation` WHERE category_id=$category_id AND name LIKE '$name'")[0] == 0) {

                            $db->send("INSERT INTO `variation`(`id`, `category_id`, `name`) VALUES ('NULL','$category_id','$name')");
                        }
                        $variation_id = $db->getonce("SELECT DISTINCT id FROM `variation` WHERE category_id=$category_id AND name LIKE '$name'")[0];
                        $db->send("INSERT INTO `variation_option`(`id`, `variation_id`, `value`, `parent_id`, `product_item_id`) VALUES ('NULL','$variation_id','$value','$parent_id','$product_items')");

                        $parent_id = $db->getonce("SELECT DISTINCT `id` FROM `variation_option` WHERE variation_id=$variation_id AND value LIKE '$value' AND parent_id=$parent_id AND product_item_id=$product_items")[0];
                    }
                    $db->send("INSERT INTO `product_cofiguration`(`id`, `variation_option_id`, `product_item_id`) VALUES ('NULL','$parent_id','$product_items')");
                }
            }
            return json_encode(array("status" => "success"));
        }

        return json_encode(array("status" => "failed"));
    }
    // delted product
    function deleteProduct($proudctid)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 10)) {
            $update = "UPDATE `product` SET `deleted`= " . time() . " WHERE id=" . $proudctid;
            $result = $db->send($update);
        }
        return $result;
    }
    function delProductItem($id)
    {
        $db = new connect();
        $result = $db->send("UPDATE `product_item` SET `deleted`=" . time() . " WHERE id=$id");
        return $result;
    }

    function updateProduct($get, $post, $files)

    {
        $db = new connect();
        $id = $get['id'];
        $title = $post['title'];
        $img = $db->getonce("SELECT img FROM `product` WHERE id= $id")[0];

        if ($files['avatar']['name'] != '') {

            $img = "assets/products/" . md5($id) . "/img/" . uniqid() . '.' . pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($files['avatar']['tmp_name'], $img);
        }
        $category_id = $post['category'];
        $desc = $post['desc'];
        $sdesc = $post['sdesc'];
        $discount = $post['discount'];

        $gallery = $files['gallery'];
        $db->send("UPDATE `product` SET `title`=' $title',`img`='$img',`category_id`=' $category_id',`description`=' $desc',`sDescription`=' $sdesc',`discount`='   $discount',`updated_at`=CURRENT_TIMESTAMP WHERE id=$id");
        if ($gallery['tmp_name']) {

            foreach ($gallery['tmp_name'] as $key => $tmp_name) {
                $thumnali = "assets/products/" . md5($id) . "/gallery/" .  uniqid() . '.' . pathinfo($gallery['name'][$key], PATHINFO_EXTENSION);
                $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$id',' $thumnali','" . pathinfo($gallery["name"][$key], PATHINFO_EXTENSION) . "')";
                $db->send($insert);
                move_uploaded_file($tmp_name, $thumnali);
            }
        }
        if (!empty($post['price'])) {
            $src = $files['src'];
            $dataJson = json_decode($post['variables'], true);
            for ($i = 0; $i < count($post['price']); $i++) {
                $price = $post['price'][$i];
                $sources = "assets/products/" . md5($id) . "/src/" . uniqid() . '.' . pathinfo($src['name'][$i], PATHINFO_EXTENSION);
                $db->send("INSERT INTO `product_item`(`id`, `product_id`, `price`, `sources`, `deleted`) VALUES ('NULL','$id',' $price ',' $sources','0')");

                $product_items = $db->getonce("SELECT MAX(id) FROM `product_item` WHERE 1")[0];
                move_uploaded_file($src['tmp_name'][$i], $sources);
                if (count($dataJson) > 0) {
                    $keys = array_keys($dataJson[$i]);
                    $parent_id = 0;
                    for ($j = 0; $j < count($keys); $j++) {
                        $name = $keys[$j];
                        $value = $dataJson[$i][$keys[$j]];
                        if ($db->getonce("SELECT  COUNT(id) FROM `variation` WHERE category_id=$category_id AND name LIKE '$name'")[0] == 0) {

                            $db->send("INSERT INTO `variation`(`id`, `category_id`, `name`) VALUES ('NULL','$category_id','$name')");
                        }
                        $variation_id = $db->getonce("SELECT DISTINCT id FROM `variation` WHERE category_id=$category_id AND name LIKE '$name'")[0];
                        $db->send("INSERT INTO `variation_option`(`id`, `variation_id`, `value`, `parent_id`, `product_item_id`) VALUES ('NULL','$variation_id','$value','$parent_id','$product_items')");

                        $parent_id = $db->getonce("SELECT DISTINCT `id` FROM `variation_option` WHERE variation_id=$variation_id AND value LIKE '$value' AND parent_id=$parent_id AND product_item_id=$product_items")[0];
                    }
                    $db->send("INSERT INTO `product_cofiguration`(`id`, `variation_option_id`, `product_item_id`) VALUES ('NULL','$parent_id','$product_items')");
                }
            }
        }
        if (isset($post['product-item-id'])) {

            for ($i = 0; $i < count($post['product-item-id']); $i++) {
                $itemId = $post['product-item-id'][$i];
                $price = $post['priceOld'][$i];

                $sources = $db->getonce("SELECT sources FROM `product_item` WHERE id= $itemId")[0];
                if ($files['srcOld']['tmp_name'][$i] != '') {
                    $sources = "assets/products/" . md5($id) . "/src/" . uniqid() . '.' . pathinfo($files['srcOld']['name'][$i], PATHINFO_EXTENSION);
                    move_uploaded_file($files['srcOld']['tmp_name'][$i], $sources);
                }
                $db->send("UPDATE `product_item` SET`price`='$price',`sources`='$sources' WHERE id=$itemId");
            }
        }






        return json_encode(array($get, $post, $files));
    }
    function hideProduct($proudctid)
    {
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 8)) {
            $db = new connect();


            $update = "UPDATE `product` SET `hide`= IF(`hide` = 1, 0, 1) WHERE id=" . $proudctid;
            $result = $db->send($update);
            return json_encode(array("status" => $result));
        }
    }
    function hiddenProductCate($cate_id)
    {
        $db = new connect();


        $update = "UPDATE `category` SET hidden = IF(hidden = 1, 0, 1) WHERE id = $cate_id;

        UPDATE `product` SET hide = (SELECT hidden FROM `category` WHERE id = $cate_id) WHERE category_id = $cate_id;
        ";
        $result = $db->send($update);
        return json_encode(array("status" => $result));
    }
    function delProductCate($cateid)
    {
        $db = new connect();
        $query = "UPDATE `product` SET `category_id`=0 WHERE category_id=$cateid;DELETE FROM `category` WHERE id='$cateid'";
        $result = $db->send($query);
        return json_encode(array("status" => $result));
    }
    function addProductCate($name)
    {
        if (empty($name)) {
            return json_encode(array("status" => "failed"));
        }
        $db = new connect();
        $insert = "INSERT INTO `category`(`id`, `name`) VALUES (default,'$name')";
        $result = $db->send($insert);
        return json_encode(array("status" => $result));
    }
    function delGallery($id)
    {
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 6)) {

            $db = new connect();
            $db->send("DELETE FROM `gallery` WHERE id=" . $id);
        }
    }

    // movies product
    function movieProduct($id, $arrow = 1)
    {

        // với $arrow =1 là di chuyển lên còn lại là di chuyển xuống
        $db = new connect();
        $position = $db->getonce("SELECT position FROM `product` WHERE id=" . $id)[0];

        switch ($arrow) {
            case 1: {
                    $db->send("UPDATE product set position=position+1 WHERE position =$position - 1 AND position+1<=(SELECT COUNT(*) FROM product )");
                    $db->send("UPDATE product set position=position-1 WHERE id =$id AND position-1>=0");
                    break;
                }
            default: {
                    $db->send("UPDATE product set position=position-1 WHERE position =$position + 1 AND position-1>=0");
                    $db->send("UPDATE product set position=position+1 WHERE id =$id AND position+1<=(SELECT COUNT(*) FROM product )");
                    break;
                }
        }
        return json_encode(array("status" => "success"));
    }
    function view_Order($year = "", $month = "", $currentPage = 1)
    {
        if ($this->check) {
            $db = new connect();
            $start = 6 * $currentPage - 6;
            $end = 6 * $currentPage;
            $Where = "1=1";
            if ($month != "") {
                $Where .= " AND MONTH(date_order)=" . $month;
            }
            if ($year != "") {
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
    {
        if ($this->check) {
            $db = new connect();
            $select = "SELECT title, img, id FROM `product` WHERE id IN(SELECT product_id FROM order_details WHERE order_id=" . $orderId . ")";
            $result = $db->getlist($select);
            return $result;
        }
        return null;
    }
    // News
    // function add news
    function addnews($title, $avatar, $cateNews, $authorid, $content)
    {
        $db = new connect();
        $title = addslashes($title);
        $count = $db->getonce("SELECT COUNT(*) FROM `blog`")[0] + 1;

        $insert = "INSERT INTO `blog`(`id`, `title`, `avatar`, `content`, `newsCate_id`, `author`, `created_at`, `deleted`, `hidden`, `position`) VALUES (NULL,'$title','$avatar','$content','$cateNews','$authorid',DEFAULT,DEFAULT,DEFAULT,'$count')";
        $result = $db->send($insert);
        echo json_encode(array("status" => $result));
    }
    // function add news categories
    function addNewsCate($name)
    {
        $db = new connect();
        $insert = "INSERT INTO `newscategory`(`id`, `name`) VALUES (default,'$name')";
        $result = $db->send($insert);
        echo json_encode(array("status" => $result));
    }
    //    update news
    function updateNews($id, $title, $avatar, $cateNews, $content)
    {
        $db = new connect();
        $title = addslashes($title);
        $content = addslashes($content);

        $update = "UPDATE `blog` SET `title`='$title',`avatar`='$avatar',`content`='$content',`newsCate_id`=' $cateNews',`created_at`= current_timestamp() WHERE id=$id";
        $result = $db->send($update);
        echo json_encode(array("status" => $result));
    }
    // view news
    function viewsNews($page = 1, $keysearch = "", $cate = 0)
    {

        $start = ($page - 1) * 6;
        $where = "";
        if ($keysearch != "") {
            $where .= " AND blog.title like '%$keysearch%'  ";
        }
        if ($cate != 0) {
            $where .= " AND blog.newsCate_id=$cate";
        }
        $select = "SELECT blog.id AS id, title, blog.avatar , name, fullname, created_at, blog.hidden as 'hidden' FROM `blog`,`user`,`newscategory` WHERE blog.deleted=0 AND  blog.author=user.id AND blog.newsCate_id= newscategory.id $where ORDER BY position ASC LIMIT $start,6";
        $db = new connect();

        $result = $db->getlist($select);
        $select = "SELECT COUNT(blog.id) FROM `blog`,`user`,`newscategory` WHERE blog.deleted=0 AND  blog.author=user.id AND blog.newsCate_id= newscategory.id $where ";
        $count = $db->getonce($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        return json_encode(array("status" => "success", "data" => $array, "page" => ceil($count[0] / 6)));
    }
    function delNews($id)
    {
        $db = new connect();

        $update = "UPDATE `blog` SET `deleted`= " . time() . " WHERE id=" . $id;
        $result = $db->send($update);

        return json_encode(array("status" => $result ? "success" : "failed"));
    }
    function hiddenNews($id)
    {
        $db = new connect();
        $update = "UPDATE `blog` SET `hidden`= IF(`hidden` = 1, 0, 1) WHERE id=$id";
        $result = $db->send($update);
        return json_encode(array("status" => $result ? "success" : "failed"));
    }
    function newsPosition($id, $arrow = 1)
    {

        // với $arrow =1 là di chuyển lên còn lại là di chuyển xuống
        $db = new connect();
        $position = $db->getonce("SELECT position FROM `blog` WHERE id=" . $id)[0];

        switch ($arrow) {
            case 1: {
                    $db->send("UPDATE blog set position=position+1 WHERE position =$position - 1 AND position+1<=(SELECT COUNT(*) FROM blog )");
                    $db->send("UPDATE blog set position=position-1 WHERE id =$id AND position-1>=0");
                    break;
                }
            default: {
                    $db->send("UPDATE blog set position=position-1 WHERE position =$position + 1 AND position-1>=0");
                    $db->send("UPDATE blog set position=position+1 WHERE id =$id AND position+1<=(SELECT COUNT(*) FROM blog )");
                    break;
                }
        }
        return json_encode(array("status" => "success"));
    }
    function hiddenNewsCate($cate_id)
    {
        $db = new connect();


        $update = "UPDATE `newscategory` SET hidden = IF(hidden = 1, 0, 1) WHERE id = $cate_id;

        UPDATE `blog` SET `hidden` = (SELECT hidden FROM `newscategory` WHERE id = $cate_id) WHERE newsCate_id = $cate_id;
        ";
        $result = $db->send($update);
        return json_encode(array("status" => $result));
    }
    function delNewsCate($cateid)
    {
        $db = new connect();
        $query = "UPDATE `blog` SET `newsCate_id`=0 WHERE newsCate_id=$cateid;DELETE FROM `newscategory` WHERE id='$cateid'";
        $result = $db->send($query);
        return json_encode(array("status" => $result));
    }
}
