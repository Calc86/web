<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 15.03.14
 * Time: 16:29
 */

class WebUser extends CWebUser {
    private $model = null;

    public function getRoles() {
        if($user = $this->getModel()){
            // в таблице User есть поле role

            $roles = explode(',',$user->roles);

            return $roles;
        }
        else{
            return array();
        }
    }

    private function getModel(){
        if (!$this->isGuest && $this->model === null){
            $this->model = User::model()->findByPk($this->id, array('select' => 'roles'));
        }
        return $this->model;
    }
}
