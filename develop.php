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
          <a class="nav-link" href="#all">全て</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#today">今日</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#this_week">今週</a>
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
  <!-- Modal -->
  <div class="modal fade" id="trashModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">削除済みタスク</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th>タスク名</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        </div>
      </div>
    </div>
  </div>

  <?php

include 'entity/task.php';
include 'daoQuery.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);

$userId = 2;
$daoQuery = new daoQuery();
$undoneTasks = $daoQuery->queryTaskList($userId, 0, 0);

?>

  <main role="main" class="container">
    <div class="switch">
      <span>表示切替</span>
      <label class="switch__label">
        <input id="viewMode" type="checkbox" class="switch__input" />
        <span class="switch__content"></span>
        <span class="switch__circle"></span>
      </label>
    </div>
    <h1 class="mb-3">Your List</h1>
    <div id="progressArea">
      <?php
include_once 'view/progressBar.php';
    $count= $daoQuery->countTodayByState($userId);
    print viewBar($count['1'],$count['0']);
?>
    </div>
    <div id="newTaskCard" data-priority="0" class="card bg-light mb-3 editable" style="display:none">
      <div class="card-header">
        <span class="sortArea head-1" style="display:none">
        </span>
        <span class="head-2" style="display:none">
        </span>
        <span class="head-3">
          <input id="newName" type="text" class="form-control" maxlength="50" placeholder="Title" aria-label="Title"
            aria-describedby="basic-addon1">
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
        <button class="createBtn" data-taskid="{$taskCard->getId()}" data-role="edit"><i class="fas fa-save"></i></button>
        <button class="cancelBtn" data-taskid="{$taskCard->getId()}"><i class="fas fa-eraser"></i></button>
      </div>
    </div>

    <ul id="sortable">

      <?php
include_once 'view/taskCard.php';
for ($i = 0; $i < count($undoneTasks); $i++) {
    print viewTaskCard($undoneTasks[$i]);
}
?>

    </ul>



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
                  <th></th>
                  <th>タスク名</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          </div>
        </div>
      </div>
    </div>

  </main>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-bottom">
    <ul class="head-bar">
      <li>
        <button id="newBtn" class="btn btn-primary nav-link mr-3">
          <i class="fas fa-plus-circle"></i><a>&nbsp;新規作成</a>
        </button>
      </li>
      <li>
        <button id="doneBox" class="btn btn-secondary nav-link mr-3" data-toggle="modal" data-target="#doneModal">
          <i class="fas fa-clipboard-check"></i><a>&nbsp;完了済</a>
        </button>
      </li>
      <li>
        <button id="trashBtn" class="btn btn-secondary nav-link" data-toggle="modal" data-target="#trashModal">
          <i class="fas fa-trash"></i><a>&nbsp;ゴミ箱</a>
        </button>
      </li>
    </ul>
  </nav>


  <!-- /.container -->
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