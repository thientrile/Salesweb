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
                case "codeForgot": {
                        $email = isset($_POST["email"]) ? $_POST["email"] : ""; //lấy email
                        $result = $User->checkEmailExit($email);
                        if ($result) {
                            $code = rand(1000, 9999);
                            $mail->confirmMail($email, $code, "");
                            $_SESSION['code'] = array("email" => $email, "code" => $code);
                            echo json_encode(array("status" => "success"));
                        } else {
                            echo json_encode(array("status" => "failed"));
                        }
                        break;
                    }
                case "checkCode": {
                        if (isset($_SESSION['code']) && isset($_POST['code']) && $_SESSION['code']['code'] == $_POST['code']) {
                            $_SESSION['checkCode'] = array("check" => $_SESSION['code']['code'] == $_POST['code'], "email" => $_SESSION['code']['email']);

                            echo json_encode(array("status" => "success"));
                        } else {
                            echo json_encode(array("status" => "failed"));
                        }

                        break;
                    }
                case "newPass": {
                        if (isset($_SESSION['checkCode']) && $_SESSION['checkCode']['check']) {
                            $User->updatePassword($_SESSION['checkCode']['email'], md5($_POST['pswd']));

                            echo json_encode(array("status" => "success"));
                        } else {
                            echo json_encode(array("status" => "failed"));
                        }
                        break;
                    }
                case "signup": {



                        if (isset($_POST['code']) && $_POST['code'] == $_SESSION['code']['code']) {
                            echo  $User->userSign($_SESSION['code']['username'], $_SESSION['code']['email'], $_SESSION['code']['pswd']);

                            $result = $User->getId($_SESSION['code']['email']);
                            $_SESSION["s_user"] =  $result['id'];

                            setcookie('c_user', md5($result['id']), time() + 86400);
                            if (isset($_SESSION['code'])) {
                                session_name("code");
                                session_unset();
                                session_destroy();
                            }
                        } else {

                            echo json_encode(array("status" => "failed"));
                        }


                        break;
                    }
                case "login": {
                        $log_mail = isset($_POST['email']) ? $_POST['email'] : "";
                        $log_pswd = isset($_POST['pswd']) ? $_POST['pswd'] : "";
                        $result = $User->userLogin($log_mail, md5($log_pswd));
                        if ($result != false) {

                            $_SESSION["s_user"] =  $result['id'];
                            setcookie('c_user', md5($result['id']), time() + 86400);
                            echo json_encode(array("status" => "success"));
                        } else {
                            echo json_encode(array("status" => "fall", "error" => "Email or password is incorrect"));
                        }

                        break;
                    }
            }
            break;
        }

    default: {
            echo json_encode(array("status" => "success", "method" => $method));
            break;
        }
}
