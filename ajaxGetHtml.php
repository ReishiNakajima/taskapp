<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

include_once 'entity/task.php';
include_once 'daoQuery.php';
include_once 'view/taskCard.php';
include_once 'view/progressBar.php';

$userId = 2;
$daoQuery = new daoQuery();

switch ($_GET['q']) {
    case 'undoneTaskCardList':
        $undoneTasks = $daoQuery->queryTaskList($userId, 0, 0);
        for ($i = 0; $i < count($undoneTasks); $i++) {
            echo viewTaskCard($undoneTasks[$i]);
        }
        break;
    case 'progressBar':
        $count = $daoQuery->countTodayByState($userId);
        echo viewBar($count['1'], $count['0']);
        break;
    default:
        echo '定義されていないメソッド呼び出しクエリです';
        break;
}
