<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header('Content-type: text/json; charset= UTF-8');

include 'entity/task.php';

if (isset($_POST['id'])) {
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
    $stmt = $db->prepare('UPDATE task SET delete_flag=(?) where id=(?)');
    $task = new Task();
    $stmt->execute(array($_POST['deleteFlag'],$_POST['id']));
    
    $json = array('id'=>$_POST['id'],'deleteFlag'=>$_POST['deleteFlag']);

    echo json_encode($json);
} else {
    echo '失敗';
}
