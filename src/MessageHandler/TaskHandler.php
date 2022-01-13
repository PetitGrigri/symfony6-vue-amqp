<?php

namespace App\MessageHandler;

use App\Entity\Task;
use DateTimeImmutable;
use App\Message\TaskMessage;
use App\Service\TaskService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskHandler implements MessageHandlerInterface
{
    /**
     * Class constructor.
     */
    public function __construct(
        private TaskService $taskService,
    ) { }

    public function __invoke(TaskMessage $taskNotification) 
    {

        try {
            $id = $taskNotification->getTaskId();
            $task = $this->taskService->findById($id);

            //TODO Add try/catch
            
            $this->startTask($task);
            $this->finishTask($task);
        } catch(\Throwable $e) {
            dump($e);
        }

    }

    /**
     * Start a task (virtually) 
     * The duration of the task will be used to simulate the duration of a long and difficult Task.
     *
     * @param Task $task
     * @return void
     */
    protected function startTask(Task $task) 
    {
        $task->setStartedAt(new DateTimeImmutable());
        $this->taskService->save($task);

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
    }
}
