<?php
//require_once ('./class/DBconn.php');
//
//function cronStart(): void
//{
//    if ((!isset($_SESSION['users_id']) and !isset($_SESSION['del_user'])) and isset($_SESSION['del'])) {
//        DBconn::deleteByTime($_SESSION['month_count']);
//    } elseif (isset($_SESSION['users_id']) and isset($_SESSION['del'])) {
//        if ($_SESSION['del_user'] == 'option_1') {
//            DBconn::deleteByTimeAndExceptSelectedUsers($_SESSION['users_id'], $_SESSION['month_count']);
//        } elseif ($_SESSION['del_user'] == 'option_2') {
//            DBconn::deleteByTimeAndUsers($_SESSION['users_id'], $_SESSION['month_count']);
//        }
//    }
//
//    $file = dirname(__FILE__) . '/output.txt';
//    $data = "Script work " . date('d/m/Y H:i:s') . "\n";
//    file_put_contents($file, $data, FILE_APPEND);
//}
//
//cronStart();
