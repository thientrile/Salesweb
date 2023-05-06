<?php
include 'model/main.models.php';
if (isset($_GET['name'])) {
    $name = $_POST['name'];

    $email = $_POST['email'];
    echo $email;
    echo $name;
    $cc->send("INSERT INTO test  (name, email)
 VALUES ('$name','$email');");
    echo json_encode(array("name" => $name, "email" => $email));
}
