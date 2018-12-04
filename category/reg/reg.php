<?php
    class Reg{
        /**
         * При успешной регистрации
         */
        public function regSuccess(){
            include("category/pm/index.html");
            include("category/reg/success.html");
        }

        /**
         * Форма регистрации
         *
         * @param $errorMessage
         */
        public function regForm($errorMessage){
            include("category/reg/reg_form.html");
        }

        /**
         * Регистрация пользователя
         *
         * @return bool|mixed
         */
        public function regUser(){
            $passw = $_POST['password'];
            $salt = $this->salt();
            $pass = md5(md5($passw).$salt);
            $db = DataBase::getDB();

            $sql = 'INSERT INTO `reg`
						VALUES(
								0, {?}, {?}, {?}, {?}
                                )';
            return $db->query($sql, array($_POST['login'], $pass, $salt, md5($salt)));
        }

        /**
         * Проверка вводимых данных перед регистрацией
         *
         * @param $errorMessage
         * @return bool
         */
        public function regCheck(&$errorMessage){
            if(!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['re_password'])){
                $errorMessage = "Не все поля заполнены!";
                return false;
            }
            if(!(trim($_POST['login']))
                || !(trim($_POST['password'])) || !(trim($_POST['re_password']))){
                $errorMessage = "Поля не должны состоять только из пробельных символов!";
                return false;
            }
            $sql = 'SELECT `login`
					FROM `reg`
					WHERE `login` = {?}';
            $db = DataBase::getDB();
            if($db->selectCell($sql, array($_POST['login']))){
                $errorMessage = "Пользователь с таким логином уже зарегистрирован!";
                return false;
            }
            if($_POST['password'] != $_POST['re_password']){
                $errorMessage = "Пароли не совпадают!";
                return false;
            }
            return true;
        }

        /**
         * Соль для шифрования пароля
         *
         * @return bool|string
         */
        private function salt(){
            $salt = substr(md5(uniqid()), -8);
            return $salt;
        }
    }
?>
