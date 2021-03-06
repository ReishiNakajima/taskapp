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

    public function queryTaskListBydeadline($userId, $deadline)
    {
        $stmt = $this->db->prepare('SELECT * FROM task where user_id=(?) and deadline <= (?) and done_flag = 0 and delete_flag = 0');
        $stmt->execute(array($userId, $deadline));
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

    public function countTodayByState($userId)
    {
        $stmt = $this->db->prepare('SELECT done_flag,count(id) as sum from task where deadline<(?) and delete_flag=0 and user_id=(?) group by done_flag');
        $stmt->execute(array(date('Y/m/d', strtotime('+1 day')),$userId));
        $count = array('done' => 0, 'undone' => 0);
        while ($row = $stmt->fetch()) {
            $count["$row[done_flag]"] = "$row[sum]";
        }
        if (!isset($count['1'])) {
            $count['1']=0;
        }
        if (!isset($count['0'])) {
            $count['0']=0;
        }
        return $count;
    }
}
