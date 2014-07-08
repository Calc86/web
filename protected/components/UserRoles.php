<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 01.07.14
 * Time: 14:52
 */

class UserRoles {
/*
 * Cam
 * -----
 *
 */
    const VIEW_CAM = 'viewCam';
    const VIEW_OWN_CAM = 'viewOwnCam';
    const UPDATE_CAM = 'updateCam';
    const UPDATE_OWN_CAM = 'updateOwnCam';

    const VIEW_ARCHIVE = 'viewArchive';
    const VIEW_OWN_ARCHIVE = 'viewOwnArchive';
    const UPDATE_ARCHIVE = 'updateArchive';
    const UPDATE_OWN_ARCHIVE = 'updateOwnArchive';

    const VIEW_CAM_SETTINGS = 'viewCamSettings';
    const VIEW_OWN_CAM_SETTINGS = 'viewOwnCamSettings';
    const UPDATE_CAM_SETTINGS = 'updateCamSettings';
    const UPDATE_OWN_CAM_SETTINGS = 'updateOwnCamSettings';

    const CREATE_USER = 'createUser';
    const VIEW_USER = 'viewUser';
    const VIEW_OWN_USER = 'viewOwnUser';
    const UPDATE_USER = 'updateUser';
    const UPDATE_OWN_USER = 'updateOwnUser';
    const DELETE_USER = 'deleteUser';

    //bizRule
    const RULE = 'return Yii::app()->user->id == $params["uid"];';
    const USER_ID = 'uid';

    //Admin operations
    const CHANGE_ROLE = 'changeRole';
    const INSTALL_ROLES = 'installRoles';

    const USER = 'user';
    const ADMIN = 'admin';
    const MODERATOR = 'moderator';
    const GUEST = 'guest';

    private $rules = array();

    /**
     * @return PhpAuthManager
     */
    public function getAuthManager(){
        return WebYii::app()->authManager;
    }

    private function createOperations(){
        $manager = $this->getAuthManager();

        //Admin
        $manager->createOperation(self::CHANGE_ROLE);
        $manager->createOperation(self::INSTALL_ROLES);

        //User
        $manager->createOperation(self::CREATE_USER);
        $manager->createOperation(self::VIEW_USER);
        $manager->createOperation(self::VIEW_OWN_USER, '', self::RULE)->addChild(self::VIEW_USER);
        $manager->createOperation(self::UPDATE_USER);
        $manager->createOperation(self::UPDATE_OWN_USER, '', self::RULE)->addChild(self::UPDATE_USER);
        $manager->createOperation(self::DELETE_USER);

        //Cam
        $manager->createOperation(self::VIEW_CAM);
        $manager->createTask(self::VIEW_OWN_CAM, '', self::RULE)->addChild(self::VIEW_CAM);
        $manager->createOperation(self::UPDATE_CAM);
        $manager->createTask(self::UPDATE_OWN_CAM, '', self::RULE)->addChild(self::UPDATE_CAM);

        //Archive
        $manager->createOperation(self::VIEW_ARCHIVE);
        $manager->createTask(self::VIEW_OWN_ARCHIVE, '', self::RULE)->addChild(self::VIEW_ARCHIVE);

        //CamSettings
        $manager->createOperation(self::VIEW_CAM_SETTINGS);
        $manager->createTask(self::VIEW_OWN_CAM_SETTINGS, '', self::RULE)->addChild(self::VIEW_CAM_SETTINGS);
        $manager->createOperation(self::UPDATE_CAM_SETTINGS);
        $manager->createTask(self::UPDATE_OWN_CAM_SETTINGS, '', self::RULE)->addChild(self::VIEW_CAM_SETTINGS);
    }

    private function createRoles(){
        $manager = $this->getAuthManager();

        $guest = $manager->createRole(self::GUEST);

        $user = $manager->createRole(self::USER);
        $user->addChild(self::VIEW_OWN_ARCHIVE);
        $user->addChild(self::VIEW_OWN_CAM);
        $user->addChild(self::VIEW_OWN_CAM_SETTINGS);
        $user->addChild(self::VIEW_OWN_USER);
        $user->addChild(self::UPDATE_OWN_USER);
        $user->addChild(self::UPDATE_OWN_CAM);
        $user->addChild(self::UPDATE_OWN_CAM_SETTINGS);

        $moderator = $manager->createRole(self::MODERATOR);
        $moderator->addChild(self::USER);
        $moderator->addChild(self::VIEW_USER);
        $moderator->addChild(self::UPDATE_USER);

        $admin = $manager->createRole(self::ADMIN);
        $admin->addChild(self::MODERATOR);
        $admin->addChild(self::CREATE_USER);
        $admin->addChild(self::DELETE_USER);
        $admin->addChild(self::CHANGE_ROLE);
        $admin->addChild(self::INSTALL_ROLES);
    }


    public function create(){
        $manager = $this->getAuthManager();

        $manager->clearAll();

        $this->createOperations();
        $this->createRoles();

        $manager->save();
    }
}
