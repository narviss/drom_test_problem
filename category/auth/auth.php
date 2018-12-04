<?php
class Auth {
    public function authForm($errorMessage){
        include("category/auth/auth_form.html");
    }
    public function authSuccess(){
        include("category/pm/index.html");
        include("category/auth/success.html");
    }
    public function authCheck(&$errorMessage){
        if(!isset($_POST['login']) || !isset($_POST['password'])){
            $errorMessage = "Не все поля заполнены!";
            return false;
        }
        $sql = 'SELECT *
					FROM `reg`
					WHERE `login` = {?}';
        $db = DataBase::getDB();
        if($row = $db->select($sql, array($_POST['login']))){
            $row = $row[0];
			if(md5(md5($_POST['password']).$row['salt']) == $row['pass'])
			{
				$_SESSION['user'] = $row['id'];
			} else {
                $errorMessage = "Пароль не подходит!";
                return false;
            }
        } else {
            $errorMessage = "Пользователь с таким логином не найден!";
            return false;
        }
        return true;
    }
}
?>
