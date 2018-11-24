<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TITLE!</title>
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <link rel="stylesheet" href="css/common.css">
  <style>
    /*ページ固有のスタイルを指定*/
  </style>
</head>

<body>
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <h1 class="text-center">TITLE!</h1>
      </div>
    </div>
    <div class="row text-center">
      <div class="col">
        <p>説明テキスト</p>

      </div>
    </div>
    <!--ここからメインコンテンツ-->
    <div class="row">
    <div class="col">
<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";

try {
    $db = new PDO($dsn, $db['user'], $db['pass']);
} catch (PODException $e) {
    print $e->getMessage();
    die();
}

$task = $db->query('SELECT * FROM task where user_id=1;');

while ($row = $task->fetch()) {
    print "$row[name] \n";
}

?>
</div>

</div>
    <!--メインコンテンツここまで-->
  <div class="row mt-4">
    <div class="col text-center">
      <button type="button" class="btn btn-link" onclick="location.href='index.html'">TOPページに戻る</button>
    </div>
  </div>
</div>
  <footer>copyright2018 TITLE! Ver1.00</footer>
</body>

</html>