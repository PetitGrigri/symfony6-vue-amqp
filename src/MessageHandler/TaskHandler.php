<?php

namespace App\MessageHandler;

use Exception;
use App\Entity\Task;
use DateTimeImmutable;
use App\Message\TaskMessage;
use App\Service\TaskService;
use App\Service\NotifierService;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskHandler implements MessageHandlerInterface
{
    /**
     * Class constructor.
     */
    public function __construct(
        private TaskService $taskService,
        private NotifierService $nottifierService,
    ) { }

    public function __invoke(TaskMessage $taskNotification) 
    {
        try {
            $id = $taskNotification->getTaskId();
            $task = $this->taskService->findById($id);
        } catch(Exception $e) {
            throw new UnrecoverableMessageHandlingException();
        }


        // Simulate a long task
        $this->startTask($task);


        $this->finishTask($task);

    }

    /**
     * Start a task (virtually) 
     * The duration of the task will be used to simulate the duration of a long and difficult Task.
     * 
     *
     * @param Task $task
     * @return void
     */
    protected function startTask(Task $task) 
    {
        $task->setStartedAt(new DateTimeImmutable());
        $this->taskService->save($task);

        $this->nottifierService->notifyTaskStarted($task);

        if (rand(0, 1) === 1) {
            throw new Exception(sprintf('Task %s exception', $task->getId()));
        }

        sleep($task->getDuration());
    }
    
    /**
     * Finish a task (virtually)
     *
     * @param Task $task
     * @return void
     */
    protected function finishTask(Task $task) 
    {
        $task->setFinishedAt(new DateTimeImmutable());
        $this->taskService->save($task);

        $this->nottifierService->notifyTaskFinished($task);
    }
}
