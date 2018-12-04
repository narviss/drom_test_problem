<?php

class Router {
    public function __construct($user){
        include('category/main/head.html');
        switch ($_GET['action']){
            case 'exit':
                session_destroy();
                include("category/main/index.html");
                break;
            case 'auth':
                if($user){
                    include("category/pm/index.html");
                } else {
                    include("category/auth/auth.php");
                    $auth = new Auth();
                    $errorMessage = "";
                    if(isset($_POST['send_auth_form']) && $auth->authCheck($errorMessage)){
                        $auth->authSuccess();
                    } else {
                        $auth->authForm($errorMessage);
                    }
                }
                break;
            case 'reg':
                if($user){
                    include("category/pm/index.html");
                } else {
                    include("category/reg/reg.php");
                    $reg = new Reg();
                    $errorMessage = "";
                    if(isset($_POST['send_reg_form']) && $reg->regCheck($errorMessage) && $reg->regUser()){
                        $reg->regSuccess();
                    } else {
                        $reg->regForm($errorMessage);
                    }
                }
                break;
            default:
                if($user){
                    include("category/pm/index.html");
                } else {
                    include("category/main/index.html");
                }
                break;
        }
        include('category/main/footer.html');
    }
}

?>
