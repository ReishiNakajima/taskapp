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

}
