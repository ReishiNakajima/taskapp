<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';

if (isset($_POST['id'])) {
    // DBに接続する
    try {
        $db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'task', 'pass');
    } catch (PODException $e) {
        print $e->getMessage();
        die();
    }
    $stmt = $db->prepare('UPDATE task SET done_flag=(?) where category_id=(?)');
    $task = new Task();
    $stmt->execute(array($_POST['doneFlag'],$_POST['id']));
    
    $json = array('id'=>$_POST['id'],'doneFlag'=>$_POST['doneFlag']);

    echo json_encode($json);
} else {
    echo '失敗';
}
