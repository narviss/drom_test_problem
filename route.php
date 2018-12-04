<?php

class Router {
    public function __construct($user){
        include('category/main/head.html');
        switch ($_GET['action']){
            case 'exit': // Выход
                session_destroy();
                include("category/main/clear.html");
                include("category/main/index.html");
                break;
            case 'auth': // Авторизация
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
            case 'reg': // Регистрация
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
            case 'save': // Сохранение
                include("category/pm/todo.php");
                $todo = new Todo($user);
                $errorMessage = "";
                if(isset($_POST['send_save_form'])){
                    if($_POST['id'])
                        $todo->update($_POST['id'], $errorMessage);
                    else
                        $todo->save($errorMessage);
                    $todo->saveSuccess();
                } else {
                    $todo->saveForm($errorMessage);
                }
                break;
            case 'del': // Удаление
                include("category/pm/todo.php");
                $todo = new Todo($user);
                $errorMessage = "";
                if(isset($_GET['id']) && $todo->del($_GET['id'], $errorMessage)){
                    $todo->delSuccess();
                } else {
                    include("category/pm/index.html");
                }
                break;
            case 'list': // Просмотр сохраненных листов
                if(isset($_GET['list'])){
                    include("category/pm/todo.php");
                    $todo = new Todo($user);
                    $errorMessage = "";
                    $todo->getList($_GET['list']);
                } else {
                    include("category/pm/index.html");
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
