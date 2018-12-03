<?php

final class Router {
    public function __construct(){
        switch ($_GET['action']){
            case 'auth':
                include("category/auth/auth_form.php");
                include("category/auth/auth_form.html");
                break;
            case 'reg':
                include("category/reg/reg_form.html");
                include("category/reg/reg_form.php");
                break;
            default:
                include("category/main/index.html");
                break;
        }
    }
}

?>
