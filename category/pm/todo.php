<?php

class Todo {
    private $user = null; // Id зарегестрированного пользователя

    public function __construct($user){
        $this->user = $user;
    }

    /**
     * Удаление списка
     *
     * @param $id
     * @param $errorMessage
     * @return bool|mixed
     */
    public function del($id, $errorMessage){
        $todoList = $_POST['todo_list'];
        $title = $_POST['title'];
        $db = DataBase::getDB();
        $sql = 'DELETE FROM `todo_list`
                        WHERE user_id = {?} AND id = {?}';
        return $db->query($sql, array($this->user, $id));
    }

    /**
     * Обновление списка
     *
     * @param $id
     * @param $errorMessage
     * @return bool|mixed
     */
    public function update($id, $errorMessage){
        $todoList = $_POST['todo_list'];
        $title = $_POST['title'];
        $db = DataBase::getDB();

        $sql = 'UPDATE `todo_list`
						SET title = {?},
                            context = {?}
                        WHERE user_id = {?} AND id = {?}';
        return $db->query($sql, array($title, $todoList, $this->user, $id));
    }

    /**
     * Сохранение списка
     *
     * @param $errorMessage
     * @return bool|mixed
     */
    public function save($errorMessage){
        $todoList = $_POST['todo_list'];
        $title = $_POST['title'];
        $db = DataBase::getDB();

        $sql = 'INSERT INTO `todo_list`
						VALUES(
								0, {?}, {?}, {?}, {?}
                                )';
        return $db->query($sql, array($this->user, $title, $todoList, 0));
    }

    /**
     * Форма сохранения
     *
     * @param $errorMessage
     */
    public function saveForm($errorMessage){
        include("category/pm/save_form.html");
    }


    /**
     * При успешном удалении
     *
     */
    public function delSuccess(){
        include("category/pm/index.html");
        $this->newList();
    }

    /**
     * При успешном сохранении
     */
    public function saveSuccess(){
        include("category/pm/index.html");
        include("category/pm/save_success.html");
    }

    /**
     * Получения списка, либо отдельного листа, либо всех
     *
     * @param $list
     */
    public function getList($list){
        if($list == 'all'){
            $this->getAllList();
        } elseif($list == 'new'){
            $this->newList();
        } else {
            $this->getOneList($list);
        }
    }

    /**
     *  Получение списка листов, которые есть у этого пользователя
     */
    private function getAllList(){
        $sql = 'SELECT *
					FROM `todo_list`
					WHERE `user_id` = {?}';
        $db = DataBase::getDB();
        if($todoLists = $db->select($sql, array($this->user))){
            include("category/pm/todo_lists.html");
        } else {
            include("category/pm/index.html");
            include("category/pm/get_all_error.html");
        }
    }

    /**
     * Создание нового листа
     */
    private function newList(){
        include("category/pm/todo.html");
    }

    /**
     * Получение определенного листа
     *
     * @param $list
     */
    private function getOneList($list){
        $sql = 'SELECT *
					FROM `todo_list`
					WHERE `user_id` = {?} and `id` = {?}';
        $db = DataBase::getDB();
        if($row = $db->select($sql, array($this->user, $list))){
            $todoList = $row[0];
            include("category/pm/todo.html");
        } else {
            return false;
        }
    }
}
?>
