<?php
require_once ('./class/DB.php');

/**
 * @return void
 * Запись данных в сессию
 */
function session(): void
{
    session_start();
    if (isset($_POST['del'])) {
        $_SESSION['month_count'] = $_POST['month_count'] ?? '';
        $_SESSION['users_id'] = $_POST['users_id'] ?? '';
        $_SESSION['cron-start'] = $_POST['cron-start'] ?? '';
        $_SESSION['del_user'] = $_POST['del_user'] ?? '';
    } elseif (isset($_POST['refresh'])) {
        unset($_SESSION);
    }
}

/**
 * Работа с логикой при нажатии кнопок
 */
if (isset($_POST['month_count'])) {
    if ((!isset($_POST['users_id']) and !isset($_POST['del_except_user']) and !isset($_POST['del_user'])) and isset($_POST['del'])) {
        DBconn::deleteByTime($_POST['month_count']);
    } elseif (isset($_POST['users_id']) and isset($_POST['del'])) {
        if ($_POST['del_user'] == 'option_1') {
            DBconn::deleteByTimeAndExceptSelectedUsers($_POST['users_id'], $_POST['month_count']);
        } elseif ($_POST['del_user'] == 'option_2') {
            DBconn::deleteByTimeAndUsers($_POST['users_id'], $_POST['month_count']);
        }
    }
}
if(isset($_POST['status'])){
    DBconn::statusId();
}

/**
 * Переадрисация
 */
//if (isset($_POST['save'])) {
//    if(writeToDatabase($_POST['servername'], $_POST['username'], $_POST['password'], $_POST['database'], $_SERVER['HTTP_HOST'])){
//        header('Location: main.php');
//    } else{
//        echo 'Error';
//        header('Location: work.php');
//    }
//}

/**
 * @return void
 * Для тестирования приложения
 */
//if (isset($_POST['filling'])) {
//    DBconn::filling();
//}



