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
    function viewsNews($page = 1)
    {
        $start = ($page - 1) * 6;
        $select = "SELECT blog.id AS id, title, blog.avatar , name, fullname, created_at FROM `blog`,`user`,`newscategory` WHERE blog.deleted=0 AND blog.hidden=0 AND blog.author=user.id AND blog.newsCate_id= newscategory.id LIMIT $start,6";

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
