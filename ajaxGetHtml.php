<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

include 'entity/task.php';


switch ($_GET['q']) {
    case 'undoneTaskCardList':
    include_once 'view/taskCard.php';
    for ($i = 0; $i < count($undoneTasks); $i++) {
        print viewTaskCard($undoneTasks[$i]);
    }
        break;
    
    default:
        echo '定義されていないメソッド呼び出しクエリです';
        break;
}
