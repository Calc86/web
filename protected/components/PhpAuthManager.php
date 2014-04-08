<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 15.03.14
 * Time: 16:31
 */

class PhpAuthManager extends CPhpAuthManager{
    public function init(){
        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('application.config.auth').'.php';
        }

        parent::init();

        // Для гостей у нас и так роль по умолчанию guest.
        if(!Yii::app()->user->isGuest){
            // Связываем роль, заданную в БД с идентификатором пользователя,
            // возвращаемым UserIdentity.getId().
            //$this->assign(Yii::app()->user->role, Yii::app()->user->id);

            $existingRoles = $this->getRoles();

            if (Yii::app()->user->roles) {
                foreach (Yii::app()->user->roles as $roles) {
                    if ($existingRoles[$roles]) {
                        $this->assign($roles, Yii::app()->user->id);
                    }
                    else
                    {
                        throw new CHttpException(403,"Role '$roles' not found");
                    }
                }
            }
        }
    }
}
