<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';

if (isset($_POST['name'])) {
    // DBに接続する
    try {
        $db = new PDO('mysql://b7d179cccfc560:184764d8@us-cdbr-iron-east-01.cleardb.net/heroku_ddcb2b282511a28?reconnect=true;dbname=mydb;charset=utf8', 'task', 'pass');
    } catch (PODException $e) {
        print $e->getMessage();
        die();
    }
    $stmt = $db->prepare('INSERT INTO task (`name`, `deadline`, `user_id`, `note`) VALUES ((?),(?),(?),(?))');

    $task = new Task();
    $task->setName($_POST['name']);
    $task->setNote($_POST['note']);
    $task->setDeadlineFromStrings($_POST['date'], $_POST['time']);
    $userId = 2;
    $stmt->execute(array($task->getName(), $task->getDeadline()->format('Y/m/d H:i'), $userId, $task->getNote()));

    $json = array('name' => $task->getName(), 'deadline' => $task->getDeadline()->format('Y/m/d H:i'), 'note' => $task->getNote());

    echo json_encode($json);
} else {
    echo '失敗';
}
