<?php
class Task
{
    protected $id;
    protected $name;
    protected $deadline;
    protected $priority;
    protected $note;
    protected $userId;
    protected $doneFlag;
    protected $deleteFlag;

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of deadline
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set the value of deadline
     *
     * @return  self
     */
    public function setDeadline($deadline)
    {
        $this->deadline = new DateTime($deadline);

        return $this;
    }

    /**
     * Get the value of priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @return  self
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get the value of note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @return  self
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of doneFlag
     */
    public function getDoneFlag()
    {
        return $this->doneFlag;
    }

    /**
     * Set the value of doneFlag
     *
     * @return  self
     */
    public function setDoneFlag($doneFlag)
    {
        $this->doneFlag = $this->parseBoolean($doneFlag);

        return $this;
    }

    /**
     * Get the value of deleteFlag
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }

    /**
     * Set the value of deleteFlag
     *
     * @return  self
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $this->parseBoolean($deleteFlag);

        return $this;
    }

    /**
     * 月日と時間を表す文字列２つ（整形済）からDateTimeに変換
     *
     * @return  self
     */
    public function setDeadlineFromStrings($date, $time)
    {
        $this->setDeadline($date . ' ' . $time);
        return $this;
    }
    /**
     * 月日と時間を表す文字列１つ（整形済）からDateTimeに変換
     *
     * @return  self
     */
    public function setDeadlineFromString($datetime)
    {
        $this->setDeadline($datetime);
        return $this;
    }
    /**
     * Set the value of deleteFlag
     *
     * @return  boolean
     */
    public function parseBoolean($int)
    {
        if ($int = 1) {
            return true;
        } else if ($int = 0) {
            return false;
        } else {
            return $int;
        }
    }
    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'note' => $this->note,
            'userId' => $this->userId,
            'priority' => $this->priority,
            'deadline' => $this->deadline,
            'deleteFlag' => $this->deleteFlag,
            'doneFlag' => $this->doneFlag,
        );
    }
}
