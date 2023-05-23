<?php
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST": {
            switch (isset($_GET['function']) ? $_GET['function'] : "0") {
                case "email": {
                        $email = isset($_POST["email"]) ? $_POST["email"] : ""; //lấy email
                        $result = $User->checkEmailExit($email);
                        echo json_encode(array("status" => $result ? true : false));
                        break;
                    }
                case "codeSigup": {
                        $email = isset($_POST["email"]) ? $_POST["email"] : "";
                        $pswd = isset($_POST['pswd']) ? $_POST['pswd'] : "";
                        $username = isset($_POST['username']) ? $_POST['username'] : "";
                        //lấy ema
                        $code = rand(1000, 9999);
                        $mail->confirmMail($email, $code, "");
                        $_SESSION["code"] = array("username" => $username, "email" => $email, "pswd" => md5($pswd), "code" => $code);
                        echo json_encode(array("status" => "success"));
                        break;
                    }
            }
            break;
        }
    case "GET": {


            break;
        }
    default: {
            echo json_encode(array("status" => "success", "method" => $method));
            break;
        }
}
