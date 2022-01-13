<?php

namespace App\Message;

use App\Entity\Task;

class TaskMessage
{
    public function __construct(
        private int $taskId,
    ){ }

    public function getTaskId() : int 
    {
        return $this->taskId;
    }
}
