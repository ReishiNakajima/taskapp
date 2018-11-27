<?php
include_once 'dao.php';
class daoUpdate extends dao
{
    public function updateTaskDone($doneFlag, $id)
    {
        $stmt = $this->db->prepare('UPDATE task SET done_flag=(?) where id=(?)');
        $result = $stmt->execute(array($doneFlag, $id));
        return $result;
    }

    public function updateTaskInfo($name, $deadline, $note, $id)
    {
        $stmt = $db->prepare('UPDATE `task` SET `name` = (?), `deadline` = (?), `note` = (?) WHERE (`id` = (?))');
        $result = $stmt->execute(array($name, $deadline, $note, $id));
        return $result;
    }

}
