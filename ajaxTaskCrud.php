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
        if (isset($_POST['id'], $_POST['deleteFlag'])) {
            $result = $daoUpdate->updateTaskDelete($_POST['deleteFlag'], $_POST['id']);
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
        echo '定義されていないメソッド呼び出しクエリです';
        break;
}
