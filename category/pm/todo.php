<?php
class Todo {
    private $user = null;
    public function __construct($user){
        $this->user = $user;
    }
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
    public function saveForm($errorMessage){
        include("category/pm/save_form.html");
    }
    public function saveSuccess(){
        include("category/pm/index.html");
        include("category/pm/save_success.html");
    }
    public function getList($list){
        if($list == 'all'){
            $this->getAllList();
        } elseif($list == 'new'){
            $this->newList();
        } else {
            $this->getOneList($list);
        }
    }
    private function getAllList(){
        $sql = 'SELECT *
					FROM `todo_list`
					WHERE `user_id` = {?}';
        $db = DataBase::getDB();
        if($todoLists = $db->select($sql, array($this->user))){
            include("category/pm/todo_lists.html");
        } else {

        }
    }
    private function newList(){
        $todoList = "";
        include("category/pm/todo.html");
    }
    private function getOneList($list){
        $sql = 'SELECT *
					FROM `todo_list`
					WHERE `user_id` = {?} and `id` = {?}';
        $db = DataBase::getDB();
        if($row = $db->select($sql, array($this->user, $list))){
            $todoList = $row[0];
            include("category/pm/todo.html");
        } else {

        }
    }
}
?>
