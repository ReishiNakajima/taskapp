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
        $stmt = $this->db->prepare('UPDATE `task` SET `name` = (?), `deadline` = (?), `note` = (?) WHERE `id` = (?)');
        $result = $stmt->execute(array($name, $deadline, $note, $id));
        return $result;
    }

    public function updateTaskDelete($deleteFlag, $id)
    {
        $stmt = $this->db->prepare('UPDATE task SET delete_flag=(?) where id=(?)');
        $result = $stmt->execute(array($deleteFlag, $id));
        return $result;
    }

    public function createTask($userId, $name, $deadline, $note)
    {
        $stmt = $this->db->prepare('INSERT INTO task (`name`, `deadline`, `user_id`, `note`) VALUES ((?),(?),(?),(?))');
        $result = $stmt->execute(array($name, $deadline, $userId, $note));
        return $result;
    }

    public function deleteTask($id)
    {
        $stmt = $this->db->prepare('DELETE task where id=(?)');
        $result = $stmt->execute(array($id));
        return $result;
    }
}
