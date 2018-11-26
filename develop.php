<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="img/favicon.ico">

  <title>Tasks for Personal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- アイコンフォント読込 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <!-- Date/TimePicker -->
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/default.date.css">
  <link rel="stylesheet" href="css/default.time.css">
  <!-- Custom styles for this template -->
  <link href="starter-template.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Tasks for Personal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
      aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <button id="newBtn" class="btn btn-primary nav-link"><i class="fas fa-plus-circle"></i>&nbsp;新規タスク作成</button>
        </li>
        <li class="nav-item">
          <button id="newBtn" class="btn btn-secondary nav-link"><i class="fas fa-trash"></i>&nbsp;ゴミ箱</button>
        </li>
        <!--
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
      -->
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control" type="search" placeholder="タスクを検索する..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>
  </nav>
  <?php

include 'entity/task.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);
// DBに接続する
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
print "$dsn";
try {
    $db = new PDO($dsn, $db['user'], $db['pass']);
} catch (PODException $e) {
    print $e->getMessage();
    die();
}

//sessionから取得する
$userId = 2;

$q = $db->query('SELECT * FROM task where user_id=' . $userId . ' and delete_flag = 0 and done_flag = 0');

$undoneTasks = array();
$doneTasks = array();
$i = 0;
while ($row = $q->fetch()) {

    $undoneTasks[$i] = new Task();
    $undoneTasks[$i]->setId("$row[id]");
    $undoneTasks[$i]->setName("$row[name]");
    $undoneTasks[$i]->setNote("$row[note]");
    $undoneTasks[$i]->setUserId("$row[user_id]");
    $undoneTasks[$i]->setPriority("$row[priority]");
    $undoneTasks[$i]->setDeadlineFromString("$row[deadline]");
    $undoneTasks[$i]->setdeleteFlag("$row[delete_flag]");
    $undoneTasks[$i]->setdoneFlag("$row[done_flag]");
    $i++;

}

?>

  <main role="main" class="container">

    <h1 class="mb-3">Your Tasks List</h1>

    <div class="mb-3 progress" style="height: 30px;">
      <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 45%" aria-valuenow="40"
        aria-valuemin="0" aria-valuemax="100">45%</div>
    </div>

    <style>
      .progress-bar {
              animation: fadeIn 1s ease 0s 1 normal;
              }
              @keyframes fadeIn {
                0% {width: 0%}
                100% {width: 45%}
              }

              @-webkit-keyframes fadeIn {
                0% {width: 0%}
                100% {width: 45%}
              }
          </style>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>期限が今日のタスク件数</strong><br> あと2件／全10件
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div id="newTaskCard" data-priority="0" class="card bg-light mb-3 editable" style="display:none">
      <div class="card-header">
        <span class="sortArea head-1">
          <i class="fas fa-bars"></i>
        </span>
        <span class="head-2">
          <button class="btn btn-link createBtn" type="button" data-editable="false" data-toggle="collapse" data-target="#collapseOne0"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-save"></i>
            <a>save</a>
          </button>
        </span>
        <span class="head-3">
          <input id="newName" type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="basic-addon1">
        </span>
        <span class="head-4">
          <input id="newDate" class="datepicker form-control" name="date" type="text" placeholder="Date">
        </span>
        <span class="head-5">
          <input id="newTime" class="timepicker form-control" name="time" type="time" placeholder="Time">
        </span>
      </div>


      <div class="card-body">
        <textarea id="newNote" class="form-control" rows="3"></textarea>
      </div>
      <div class="card-footer">
        <a href="#" class="badge badge-info">プライベート</a>
        <a href="#" class="badge badge-pill badge-success">買い物リスト</a>
      </div>

    </div>

    <ul id="sortable">

      <?php

for ($i = 0; $i < count($undoneTasks); $i++) {
    $cardHtml = <<<HTML
            <li>
                <div id="taskCard{$undoneTasks[$i]->getId()}" data-priority="{$undoneTasks[$i]->getPriority()}" class="accordion card bg-light mb-3">

                <div class="card-header">
                    <span class="sortArea head-1">
                      <i class="fas fa-bars"></i>
                    </span>
                    <span class="head-2">
                      <button class="btn btn-link modeChangeBtn" type="button" data-taskid="{$undoneTasks[$i]->getId()}" data-role="edit" data-toggle="collapse" data-target="#collapseOne{$undoneTasks[$i]->getId()}"
                        aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-edit"></i>
                        <a>edit</a>
                      </button>
                    </span>
                    <span class="head-3">
                      <h5 id="nameView{$undoneTasks[$i]->getId()}" class="card-title font-weight-bold">{$undoneTasks[$i]->getName()}</h5>
                      <input id="name{$undoneTasks[$i]->getId()}" name="name{$undoneTasks[$i]->getId()}" type="text" class="form-control" placeholder="Title" aria-label="Title"  value="{$undoneTasks[$i]->getName()}" aria-describedby="basic-addon1" style="display: none;">
                    </span>
                    <span class="head-4">
                      <i class="far fa-clock text-muted"></i>
                      <a id="deadlineView{$undoneTasks[$i]->getId()}" class="text-muted font-weight-bold">{$undoneTasks[$i]->getDeadline()->format('Y/m/d H:i')}</a>
                      <input id="date{$undoneTasks[$i]->getId()}" name="date{$undoneTasks[$i]->getId()}" class="datepicker form-control" name="date" type="text" placeholder="Date" value="{$undoneTasks[$i]->getDeadline()->format('Y/m/d')}" style="display: none;">
                    </span>
                    <span class="head-5">
                      <button class="btn btn-link doneBtn" type="button" data-taskid="{$undoneTasks[$i]->getId()}">
                        <i class="fas fa-check"></i>done
                      </button>
                      <input id="time{$undoneTasks[$i]->getId()}" name="time{$undoneTasks[$i]->getId()}" class="timepicker form-control" name="time" type="time" placeholder="Time" value="{$undoneTasks[$i]->getDeadline()->format('H:i')}" style="display: none;">
                    </span>
                  </div>

                  <div id="collapseOne{$undoneTasks[$i]->getId()}" class="collapse">
                    <div class="card-body">
                      <p  id="noteView{$undoneTasks[$i]->getId()}"class="card-text">{$undoneTasks[$i]->getNote()}</p>
                      <textarea id="note{$undoneTasks[$i]->getId()}" name="note{$undoneTasks[$i]->getId()}" class="form-control" rows="3" style="display: none;">{$undoneTasks[$i]->getNote()}</textarea>
                    </div>
                    <div class="card-footer">
                      <a href="#" class="badge badge-info">プライベート</a>
                      <a href="#" class="badge badge-pill badge-success">買い物リスト</a>
                    </div>
                  </div>
                </div>
            </li>
HTML;

    print $cardHtml;

}

?>

    </ul>

    <div id="trashBox">
      <button data-toggle="modal" data-target="#exampleModalCenter">
        <i class="fas fa-clipboard-check"></i>
      </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="doneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">完了済みタスク</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <tr>
                  <th>タスク名</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                <?php
/****
for ($i = 0; $i < count($doneTasks); $i++) {
$modalHtml = <<<MODALHTML
<tr id="tr{$doneTasks[$i]->getId()}">
<td scope="row">
<button class="btn btn-link unDoneBtn" type="button" data-taskid="{$doneTasks[$i]->getId()}">
<i class="fas fa-check"></i>back
</button>
</td>
<td>
<h5>{$doneTasks[$i]->getName()}</h5>
</td>
<td>
<button class="btn btn-link" type="button" data-taskid="{$doneTasks[$i]->getId()}">
<i class="fas fa-check"></i>delete
</button>
</td>
</tr>
MODALHTML;

print $modalHtml;
}
 */
?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            <button type="button" class="btn btn-primary">未完了にする</button>
          </div>
        </div>
      </div>
    </div>

  </main><!-- /.container -->
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>

  <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/date/picker.js"></script>
  <script src="js/date/picker.date.js"></script>
  <script src="js/date/picker.time.js"></script>
  <script src="js/date/legacy.js"></script>
  <script src="js/date/ja_JP.js"></script>
  <!-- Custom JavaScript -->
  <script src="js/index.js"></script>
</body>

</html>