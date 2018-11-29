<?php
function viewBar($done, $undone)
{
    $all = $done + $undone;
    if ($done === 0) {
        $percentage = 0;
    } else {
        $percentage = round($done / $all, 3) * 100;
    }

    $Html = <<<HTML
    <div class="mb-3 progress" style="height: 30px;">
      <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {$percentage}%" aria-valuenow="40"
        aria-valuemin="0" aria-valuemax="100">{$percentage}%</div>
    </div>

    <style>
      .progress-bar {
              animation: fadeIn 1s ease 0s 1 normal;
              }
              @keyframes fadeIn {
                0% {width: 0%}
                100% {width: {$percentage}%}
              }

              @-webkit-keyframes fadeIn {
                0% {width: 0%}
                100% {width: {$percentage}%}
              }
          </style>


HTML;
    if ($undone > 0) {
        $addHtml = <<<HTML
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>期限が今日のタスク件数</strong><br> あと{$undone}件／全{$all}件
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
HTML;
        $Html = $Html . $addHtml;
    }
    return $Html;
}
