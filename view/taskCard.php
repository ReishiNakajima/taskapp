<?php
function viewTaskCard($taskCard)
{
$cardHtml = <<<HTML
<li>
    <div id="taskCard{$taskCard->getId()}" data-priority="{$taskCard->getPriority()}" class="accordion card bg-light mb-3">

    <div class="card-header">
        <span class="sortArea head-1">
          <i class="fas fa-bars"></i>
        </span>
        <span class="head-2">
          <button class="btn btn-link modeChangeBtn" type="button" data-taskid="{$taskCard->getId()}" data-role="edit" aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-edit"></i>
            <a>edit</a>
          </button>
        </span>
        <span class="head-3">
          <h5 id="nameView{$taskCard->getId()}" class="card-title font-weight-bold">{$taskCard->getName()}</h5>
          <input id="name{$taskCard->getId()}" name="name{$taskCard->getId()}" type="text" class="form-control" placeholder="Title" aria-label="Title"  value="{$taskCard->getName()}" aria-describedby="basic-addon1" style="display: none;">
        </span>
        <span class="head-4">
          <i class="far fa-clock text-muted"></i>
          <a id="deadlineView{$taskCard->getId()}" class="text-muted font-weight-bold">{$taskCard->getDeadline()->format('Y/m/d H:i')}</a>
          <input id="date{$taskCard->getId()}" name="date{$taskCard->getId()}" class="datepicker form-control" name="date" type="text" placeholder="Date" value="{$taskCard->getDeadline()->format('Y/m/d')}" style="display: none;">
        </span>
        <span class="head-5">
          <button class="btn btn-link doneBtn" type="button" data-taskid="{$taskCard->getId()}">
            <i class="fas fa-check"></i>done
          </button>
          <input id="time{$taskCard->getId()}" name="time{$taskCard->getId()}" class="timepicker form-control" name="time" type="time" placeholder="Time" value="{$taskCard->getDeadline()->format('H:i')}" style="display: none;">
        </span>
      </div>

      <div id="collapseOne{$taskCard->getId()}" class="collapse">
        <div class="card-body">
          <p  id="noteView{$taskCard->getId()}"class="card-text">{$taskCard->getNote()}</p>
          <textarea id="note{$taskCard->getId()}" name="note{$taskCard->getId()}" class="form-control" rows="3" style="display: none;">{$taskCard->getNote()}</textarea>
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