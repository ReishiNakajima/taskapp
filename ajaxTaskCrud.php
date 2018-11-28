<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';
include_once 'daoQuery.php';
include_once 'daoUpdate.php';
$daoQuery = new daoQuery();
$daoUpdate = new daoUpdate();
switch ($_GET['q']) {
    case 'getTaskList':
        if (isset($_POST['deleteFlag'], $_POST['doneFlag'], $_POST['userId'])) {
            $taskList = $daoQuery->queryTaskList($_POST['userId'], $_POST['doneFlag'], $_POST['deleteFlag']);
            $json = array();
            for ($i = 0; $i < count($taskList); $i++) {
                $json[$i] = $taskList[$i]->toArray();
            }
            echo json_encode($json);
        } else if (isset($_POST['deleteFlag'], $_POST['userId'])) {
            $taskList = $daoQuery->queryTaskListByUserAndDelete($_POST['userId'], $_POST['deleteFlag']);
            $json = array();
            for ($i = 0; $i < count($taskList); $i++) {
                $json[$i] = $taskList[$i]->toArray();
            }
            echo json_encode($json);
        } else {
            echo '失敗';
        }
        break;
    case 'updateStatus':
        if (isset($_POST['id'], $_POST['doneFlag'])) {
            $result = $daoUpdate->updateTaskDone($_POST['doneFlag'], $_POST['id']);
            echo $result;
        } else {
            echo '失敗';
        }
        break;
    case 'updateInfo':
        if (isset($_POST['id'])) {
            $tmpDate = new DateTime($_POST['date'] . ' ' . $_POST['time']);
            $result = $daoUpdate->updateTaskInfo($_POST['name'], $tmpDate->format('Y/m/d H:i'), $_POST['note'], $_POST['id']);
            echo $result;
        } else {
            echo '失敗';
        }
        break;
    case 'delete':
        if (isset($_POST['id'])) {
            $result = $daoUpdate->updateTaskDelete(1, $_POST['id']);
            echo $result;
        } else {
            echo '失敗';
        }
        break;
    case 'create':
        if (isset($_POST['userId'])) {
            $tmpDate = new DateTime($_POST['date'] . ' ' . $_POST['time']);
            $id = $daoUpdate->createTask($_POST['userId'], $_POST['name'], $tmpDate->format('Y/m/d H:i'), $_POST['note']);
            echo $id; //現状ＩＤ取得できず
        } else {
            echo '失敗';
        }
        break;
    case 'finalDelete':
        if (isset($_POST['id'])) {
            $result = $daoUpdate->deleteTask($_POST['id']);
            echo $result;
        } else {
            echo '失敗';
        }
        break;
    default:
        # code...
        break;
}
/**
 *

 */
/*
if (isset($_POST['deleteFlag'])) {
// DBに接続する
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";

try {
$db = new PDO($dsn, $db['user'], $db['pass']);
} catch (PODException $e) {
print $e->getMessage();
die();
}
//sessionから取得する
$userId = 2;

$q = $db->query('SELECT * FROM task where done_flag=' . $_POST['doneFlag'] . ' and delete_flag=' . $_POST['deleteFlag'] . ' and user_id=' . $userId);

$tasksList = array();
$i = 0;
while ($row = $q->fetch()) {
$tasksList[$i] = array(
'id' => "$row[id]",
'name' => "$row[name]",
'note' => "$row[note]",
'userId' => "$row[user_id]",
'priority' => "$row[priority]",
'deadline' => "$row[deadline]",
'deleteFlag' => "$row[delete_flag]",
'doneFlag' => "$row[done_flag]",
);
$i++;
}
echo json_encode($tasksList);
} else {
echo '失敗';
}
 */
