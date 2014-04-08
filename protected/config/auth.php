<?php
return array (
  'createUser' => 
  array (
    'type' => 0,
    'description' => 'создание пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewUser' => 
  array (
    'type' => 0,
    'description' => 'просмотр пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewOwnUser' => 
  array (
    'type' => 1,
    'description' => 'просмотр своего пользователя',
    'bizRule' => 'return Yii::app()->user->id == $params["user"]->id;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewUser',
    ),
  ),
  'updateUser' => 
  array (
    'type' => 0,
    'description' => 'изменение пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateOwnUser' => 
  array (
    'type' => 0,
    'description' => 'изменение своего пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteUser' => 
  array (
    'type' => 0,
    'description' => 'удаление пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'changeRole' => 
  array (
    'type' => 0,
    'description' => 'изменение роли пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'installRoles' =>
  array (
    'type' => 0,
    'description' => 'Запуск установщика правил пользователей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'guest' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewOwnUser',
      1 => 'updateOwnUser',
    ),
  ),
  'moderator' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'user',
      1 => 'viewUser',
      2 => 'updateUser',
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'moderator',
      1 => 'createUser',
      2 => 'changeRole',
      3 => 'deleteUser',
      4 => 'installRoles',
    ),
  ),
);
