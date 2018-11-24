<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';

if (isset($_POST['name'])) {
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
    $stmt = $db->prepare('UPDATE `task` SET `name` = (?), `deadline` = (?), `note` = (?) WHERE (`id` = (?))');
    $task = new Task();
    $task->setName($_POST['name']);
    $task->setNote($_POST['note']);
    $task->setDeadlineFromStrings($_POST['date'], $_POST['time']);
    $stmt->execute(array($task->getName(), $task->getDeadline()->format('Y/m/d H:i'), $task->getNote(), $_POST['id']));
    
    $json = array('id'=>$_POST['id'],'name'=>$task->getName(),'deadline'=>$task->getDeadline()->format('Y/m/d H:i'),'note'=>$task->getNote());

    echo json_encode($json);
} else {
    echo '失敗';
}
