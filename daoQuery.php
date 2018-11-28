<?php
include_once 'dao.php';
class daoQuery extends dao
{
    public function queryTaskList($userId, $doneFlag, $deleteFlag)
    {
        $stmt = $this->db->prepare('SELECT * FROM task where user_id=(?) and done_flag = (?) and delete_flag = (?)');
        $stmt->execute(array($userId, $doneFlag, $deleteFlag));
        $taskList = array();
        $i = 0;
        while ($row = $stmt->fetch()) {
            $taskList[$i] = new Task();
            $taskList[$i]->setId("$row[id]");
            $taskList[$i]->setName("$row[name]");
            $taskList[$i]->setNote("$row[note]");
            $taskList[$i]->setUserId("$row[user_id]");
            $taskList[$i]->setPriority("$row[priority]");
            $taskList[$i]->setDeadlineFromString("$row[deadline]");
            $taskList[$i]->setdeleteFlag("$row[delete_flag]");
            $taskList[$i]->setdoneFlag("$row[done_flag]");
            $i++;
        }
        return $taskList;
    }

    public function queryTaskListByUserAndDelete($userId, $deleteFlag)
    {
        $stmt = $this->db->prepare('SELECT * FROM task where user_id=(?) and delete_flag = (?)');
        $stmt->execute(array($userId, $deleteFlag));
        $taskList = array();
        $i = 0;
        while ($row = $stmt->fetch()) {
            $taskList[$i] = new Task();
            $taskList[$i]->setId("$row[id]");
            $taskList[$i]->setName("$row[name]");
            $taskList[$i]->setNote("$row[note]");
            $taskList[$i]->setUserId("$row[user_id]");
            $taskList[$i]->setPriority("$row[priority]");
            $taskList[$i]->setDeadlineFromString("$row[deadline]");
            $taskList[$i]->setdeleteFlag("$row[delete_flag]");
            $taskList[$i]->setdoneFlag("$row[done_flag]");
            $i++;
        }
        return $taskList;
    }
}
