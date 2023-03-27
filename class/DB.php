<?php
require_once('cron.php');
require_once('./include/code.php');
require_once('./include/check.php');

class DB
{

    public static function deleteByTime(int $month_count)
    {
        $connection = \Bitrix\Main\Application::getConnection();

        $str = "Delete
                    from b_im_massage 
                    where data_create  < now() - interval ' . $month_count . ' month";
        $result = $connection->query($str);
        // $result = $connection->query('SELECT * FROM table_name ORDER BY id DESC',10); // с указанием LIMIT
        // $result = $connection->query('SELECT * FROM table_name ORDER BY id DESC',0,10); // с указанием LIMIT и смещением от начала выборки
        while ($ar = $result->fetch()) {
            print_r($ar);
        }

        //$sqlHelper = $connection->getSqlHelper();
        //$string = $sqlHelper->forSql($connection, 50);
    }

    public static function deleteByTimeAndUsers(array $users_id, int $month_count)
    {
        $connection = \Bitrix\Main\Application::getConnection();

        $str = "DELETE massage
                        FROM b_im_massage as massage
                        Join b_user as user on user.id = massage.author_id
                        where user.id in ($users_id[0]";
        if (count($users_id) >= 1) {
            for ($i = 1; $i < count($users_id); $i++) {
                $str .= ", $users_id[$i]";
            }
        }
        $str .= ") and massage.data_create < now() - interval ' . $month_count . ' month";
        $result = $connection->query($str);
        while ($ar = $result->fetch()) {
            print_r($ar);
        }

        //$sqlHelper = $connection->getSqlHelper();
        //$string = $sqlHelper->forSql($connection, 50);
    }

    public static function deleteByTimeAndExceptSelectedUsers(array $users_id, int $month_count)
    {
        $connection = \Bitrix\Main\Application::getConnection();

        $str = "DELETE massage
                        FROM b_im_massage as massage
                        where author_id not in ($users_id[0]";
        if (count($users_id) > 1) {
            for ($i = 1; $i < count($users_id); $i++) {
                $str .= ",$users_id[$i]";
            }
        }
        $str .= ") and massage.data_create < now() - interval ' . $month_count . ' month";
        $result = $connection->query($str);
        while ($ar = $result->fetch()) {
            print_r($ar);
        }

        //$sqlHelper = $connection->getSqlHelper();
        //$string = $sqlHelper->forSql($connection, 50);
    }

    public static function getAllUsers(): array
    {
        $connection = \Bitrix\Main\Application::getConnection();

        $result = $connection->query('Select * From b_user');
        $stmt = $connection->prepare($result);
        $stmt->execute();
        $array = [];
        while ($ar = $result->fetch()) {
           print_r($array[$ar]);
        }
        return $stmt->fetchAll();
        //$sqlHelper = $connection->getSqlHelper();
        //$string = $sqlHelper->forSql($connection, 50);
    }

    public static function statusId(): array
    {
        $connection = \Bitrix\Main\Application::getConnection();

        $itog = [];
        $str = "Select CONCAT(user.last_name, ' . ', user.name) as name, user.id as id From b_user as user";
        $stmt = $connection->prepare($str);
        $stmt->execute();
        $ids = $stmt->fetchAll();

        foreach ($ids as $id) {
            $str = "Select massage from b_im_massage
                          Where author_id =" .  $id['id'];
            $stmt = $connection->prepare($str);
            $stmt->execute();
            $res = $stmt->fetchAll();

            $size = 0;
            foreach ($res as $mes) {
                $size += strlen($mes['massage']);
            }
            //перевести size в мб
            if ($size <= 1024) {
                $size = number_format($size / 1024, 4) . ' KB';
            }
            else if ($size <= 1048576) {
                $size = number_format($size / 1048576, 5) . ' MB';
            }
            else if ($size <= 1073741824) {
                $size = number_format($size / 1073741824, 4) . ' GB';
            }
            $itog[] = [$id['name'], count($res), $size];
        }
        return $itog;
        $result = $connection->query($str);
        while ($ar = $result->fetch()) {
            print_r($array[$ar]++);
        }
        return $stmt->fetchAll();
    }

}