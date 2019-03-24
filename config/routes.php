<?php
/**
 * Возвращает массив с роутами
 */
return array(
    //Просмотр задачи
    'tasks/view' => 'tasks/view',
    //Редактирование задачи
    'tasks/edit' => 'tasks/edit',
    //Регистрация задачи
    'tasks/register' => 'tasks/register',
    //Вход для админа
    'auth' => 'admin/auth',
    //Выход для админа
    'logout' => 'admin/logout',
    //Вывод списка задач
    '' => 'tasks/index',
);