<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';

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

    $q = $db->query('SELECT * FROM task where done_flag='.$_POST['doneFlag'].' and delete_flag='.$_POST['deleteFlag'].' and user_id=' . $userId);

    $tasksList = array();
    $i = 0;
    while ($row = $q->fetch()) {
        $tasksList[$i]=array(
            'id'=>"$row[category_id]",
            'name'=>"$row[name]",
            'note'=>"$row[note]",
            'userId'=>"$row[user_id]",
            'priority'=>"$row[priority]",
            'deadline'=>"$row[deadline]",
            'deleteFlag'=>"$row[delete_flag]",
            'doneFlag'=>"$row[done_flag]"
        );
        $i++;
    }
    echo json_encode($tasksList);
} else {
    echo '失敗';
}
