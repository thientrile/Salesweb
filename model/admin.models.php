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
            $select_items = "SELECT * FROM `product_item` WHERE deleted=0 AND product_id=" . $row['id'];
            $resutl_items = $cc->getlist($select_items);


            $option = array();
            $select_items = "SELECT DISTINCT product_item.id, price,sources,name,value  FROM `product_item` LEFT JOIN product_cofiguration ON product_item.id=product_cofiguration.product_item_id LEFT JOIN
                variation_option ON product_cofiguration.variation_option_id= variation_option.id LEFT JOIN variation ON variation.id=variation_option.variation_id WHERE product_id=" . $row['id'];
            $resutl_items = $cc->getlist($select_items);
            while ($item = $resutl_items->fetch()) {


                array_push($option, array("id" => $item['id'], "price" => $item['price'], "sources" => $item['sources'], "name" => $item['name'], "value" => $item['value']));
            }

            array_push($array, array("id" => $row['id'], "title" => $row['title'], "img" => $row['img'], "discount" => $row['discount'], "name" => $row['name'], "hidden" => $row['hide'], "options" => $option, "multiple" => $resutl_items->rowCount() > 1));
        }
        return json_encode(array("status" => "success", "data" => $array, "page" => ceil($count[0] / $view)));
    }
    // get variables

    // insert product
    // function insertProduct($title, $fileAvatar, $fileSrc, $cate, $desc, $sdesc, $discount, $price, $filesGallery)
    // {
    //     $db = new connect();
    //     $result = false;
    //     if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 8)) {
    //         $count = $db->getonce("SELECT COUNT(*) FROM product")[0] + 1;
    //         $product_id = $db->getonce("SELECT MAX(id) FROM `product`")[0] + 1;
    //         // $result = $price;
    //         $insert = "INSERT INTO `product`(`id`, `title`, `img`,  `category_id`, `description`, `sDescription`, `discount`, `created_at`, `updated_at`, `deleted`,`hide`,`position`) VALUES ('NULL','$title','assets/products/" . md5($product_id) . "/img/" . $fileAvatar['name'] . "','assets/products/" . md5($product_id) . "/src/" . $fileSrc['name'] . "','$cate','$desc','$sdesc','$discount','$price',default,default,default,default, $count)";
    //         $result = $db->send($insert);

    //         mkdir("assets/products/" . md5($product_id), 0700);
    //         mkdir("assets/products/" . md5($product_id) . "/img", 0700);

    //         move_uploaded_file($fileAvatar["tmp_name"], "assets/products/" . md5($product_id) . "/img/" . basename($fileAvatar["name"]));
    //         mkdir("assets/products/" . md5($product_id) . "/src", 0700);
    //         move_uploaded_file($fileSrc["tmp_name"], "assets/products/" . md5($product_id) . "/src/" . basename($fileSrc["name"]));
    //         // add gallery
    //         mkdir("assets/products/" . md5($product_id) . "/gallery", 0700);


    //         foreach ($filesGallery['tmp_name'] as $key => $tmp_name) {
    //             $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$product_id',' assets/products/" . md5($product_id) . "/gallery/" . $filesGallery["name"][$key] . "','" . pathinfo($filesGallery["name"][$key], PATHINFO_EXTENSION) . "')";
    //             $db->send($insert);
    //             move_uploaded_file($tmp_name, "assets/products/" . md5($product_id) . "/gallery/" . basename($filesGallery["name"][$key]));
    //         }
    //     }
    //     return $result;
    // }
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
        $multiple = $post['multiple'];
        $gallery = $files['gallery'];
        $insertProduct = "INSERT INTO `product`(`id`, `title`, `img`, `category_id`, `description`, `sDescription`, `discount`, `created_at`, `updated_at`, `deleted`, `hide`, `position`)       
            VALUES ('NULL','$title','$img','$category_id','$desc','$sdesc','$discount','default','default','default','default',' $position ')";
        $db->send($insertProduct);
        mkdir("assets/products/" . md5($id), 0700);
        mkdir("assets/products/" . md5($id) . "/img", 0700);
        mkdir("assets/products/" . md5($id) . "/gallery", 0700);
        mkdir("assets/products/" . md5($id) . "/src", 0700);
        move_uploaded_file($files['avatar']['tmp_name'], $img);
        foreach ($gallery['tmp_name'] as $key => $tmp_name) {
            $thumnali = "assets/products/" . md5($id) . "/gallery/" .  uniqid() . '.' . pathinfo($gallery['name'][$key], PATHINFO_EXTENSION);
            $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$id',' $thumnali','" . pathinfo($gallery["name"][$key], PATHINFO_EXTENSION) . "')";
            $db->send($insert);
            move_uploaded_file($tmp_name, $thumnali);
        }
        $src = $files['src'];
        if ($multiple == 'false') {
            $price = $post['price'];
            $sources = "assets/products/" . md5($id) . "/src/" . uniqid() . '.' . pathinfo($src['name'][0], PATHINFO_EXTENSION);
            $insertProductItem = "INSERT INTO `product_item`(`id`, `product_id`, `price`, `sources`, `deleted`) VALUES ('NULL','$id','$price','$sources',0)";
            $db->send($insertProductItem);
            move_uploaded_file($src['tmp_name'][0], $sources);
        } else {
            $dataJson = json_decode($post['variables'], true);
            foreach ($dataJson as $items) {
                $name = $items['name'];

                if ($db->getonce("SELECT COUNT(id) FROM `variation` WHERE name LIKE '$name'")[0] == 0) {
                    $db->send("INSERT INTO `variation`(`id`, `category_id`, `name`) VALUES ('NULL','0','$name')");
                }
                $variables_id = $db->getonce("SELECT id FROM `variation` WHERE name LIKE '$name'")[0];
                foreach ($items['data'] as $dataItems) {
                    $value = $dataItems['value'];
                    $price = $dataItems['price'];
                    $sources = "assets/products/" . md5($id) . "/src/" . uniqid() . '.' . pathinfo($src['name'][$dataItems['sources']], PATHINFO_EXTENSION);
                    $result =  $db->send("INSERT INTO `product_item`(`id`, `product_id`, `price`, `sources`, `deleted`) VALUES ('NULL','$id','$price','$sources','0')");
                    if ($result) {
                        if ($db->getonce("SELECT COUNT(id) FROM `variation_option` WHERE variation_id=$variables_id AND value LIKE '$value'")[0] == 0) {
                            $db->send("INSERT INTO `variation_option`(`id`, `variation_id`, `value`) VALUES ('NULL',' $variables_id ',' $value')");
                        }
                        move_uploaded_file($src['tmp_name'][$dataItems['sources']], $sources);
                        $variation_option_id = $db->getonce("SELECT MAX(id) FROM `variation_option` WHERE variation_id=$variables_id AND value LIKE '%$value%'")[0];
                        $product_items_id = $db->getonce("SELECT MAX(id) FROM `product_item` WHERE 1")[0];
                        $db->send("INSERT INTO `product_cofiguration`(`id`, `variation_option_id`, `product_item_id`) VALUES ('NULL','$variation_option_id ','$product_items_id')");
                    }
                }
            }
        }

        return json_encode(array($files, $post));
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
    function updateProduct($id, $title, $fileAvatar, $fileSrc, $cate, $desc, $sdesc, $discount, $price, $filesGallery)
    {
        $db = new connect();
        $result = false;
        if ($this->check && ($this->role == 1 || $this->role == 4 || $this->role == 6)) {
            $current_time = date("Y-m-d H:i:s");
            $up = " `title`='$title',`category_id`='$cate',`description`='$desc',`sDescription`='$sdesc',`discount`='$discount',`price`=' $price',`updated_at`=' $current_time'";
            $product_id = $id;
            if ($fileAvatar != null) {
                $up .= ",`img`='assets/products/" . md5($product_id) . "/img/" . $fileAvatar['name'] . "'";
                move_uploaded_file($fileAvatar["tmp_name"], "assets/products/" . md5($product_id) . "/img/" . basename($fileAvatar["name"]));
            }
            if ($fileSrc != null) {
                $up .= ",`source`='assets/products/" . md5($product_id) . "/src/"  . $fileSrc['name'] . "'";
                move_uploaded_file($fileSrc["tmp_name"], "assets/products/" . md5($product_id) . "/src/" . basename($fileSrc["name"]));
            }
            $update = "UPDATE `product` SET $up  WHERE id=" . $id;
            $result = $db->send($update);
            if ($filesGallery != null) {
                foreach ($filesGallery['tmp_name'] as $key => $tmp_name) {
                    $insert = "INSERT INTO `gallery`(`id`, `product_id`, `thumnali`, `type`) VALUES ('NULL','$product_id','assets/products/" . md5($product_id) . "/gallery/" . $filesGallery["name"][$key] . "','" . pathinfo($filesGallery["name"][$key], PATHINFO_EXTENSION) . "')";
                    $db->send($insert);
                    move_uploaded_file($tmp_name, "assets/products/" . md5($product_id) . "/gallery/" . basename($filesGallery["name"][$key]));
                }
            }
        }
        return $result;
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
