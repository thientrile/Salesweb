<?php
include 'model/main.models.php';
$result = $cc->getlist("SELECT * FROM test");
$array=array();
while($row=$result->fetch()){
    array_push($array,$row);
}
echo json_encode($array);
