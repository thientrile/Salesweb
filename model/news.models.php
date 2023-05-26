<?php
class news
{

    function viewNewsCate()
    {
        $db = new connect();
        $select = "SELECT * FROM `newscategory` WHERE 1";
        $result = $db->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        echo json_encode(array("status" => "success", "data" => $array));
    }
    function viewsNews($view = 6, $keysearch = "")
    {
        $where = "1=1";
        if ($keysearch != "") {
            $where .= " AND blog.title LIKE '%$keysearch%'";
        }
        $select = "SELECT blog.id AS id, title, blog.avatar , name, fullname, created_at ,content,user.avatar as 'authorAvatar' FROM `blog`,`user`,`newscategory` WHERE $where AND blog.deleted=0 AND blog.hidden=0 AND blog.author=user.id AND blog.newsCate_id= newscategory.id ORDER BY position ASC LIMIT 0,$view";
        // echo $select;
        $db = new connect();
        $result = $db->getlist($select);
        $array = array();
        while ($row = $result->fetch()) {
            array_push($array, $row);
        }
        return json_encode(array("status" => "success", "data" => $array));
    }
    function viewNews($id)
    {
        $db = new connect();
        $select = "SELECT blog.id AS id, title, blog.avatar , name, fullname,newsCate_id, content, created_at FROM `blog`,`user`,`newscategory` WHERE blog.id=$id AND blog.author=user.id AND blog.newsCate_id= newscategory.id ";

        $result = $db->getonce($select);

        return json_encode($result);
    }
}
