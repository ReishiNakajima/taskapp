<?php
function viewTaskCard($taskCard)
{
$cardHtml = <<<HTML
<li>
    <div id="taskCard{$undoneTasks[$i]->getId()}" data-priority="{$undoneTasks[$i]->getPriority()}" class="accordion card bg-light mb-3">

    <div class="card-header">
        <span class="sortArea head-1">
          <i class="fas fa-bars"></i>
        </span>
        <span class="head-2">
          <button class="btn btn-link modeChangeBtn" type="button" data-taskid="{$undoneTasks[$i]->getId()}" data-role="edit" aria-expanded="true" aria-controls="collapseOne">
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
}