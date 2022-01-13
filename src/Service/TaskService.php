<?php

namespace App\Service;

use App\Entity\Task;
use App\Message\TaskMessage;
use App\Repository\TaskRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Constraints\Date;

class TaskService
{
    /**
     * Class constructor.
     */
    public function __construct(
        private TaskRepository $taskRepository,
        private MessageBusInterface $messageBusInterface,
    )
    { }

    public function create(Task $task) 
    {
        $task
            ->setCreatedAt(new DateTimeImmutable());

        // Persist task in the database
        $this->taskRepository->save($task);
        $this->messageBusInterface->dispatch(
          new TaskMessage($task->getId())
        );
    }

    /**
     * Find a Task with his Id
     *
     * @param integer $id
     * @return Task|null
     */
    public function findById(int $id) : ?Task
    {
        return $this->taskRepository->find($id);
    }

    /**
     * Find a Task with his Id
     *
     * @param integer $id
     * @return Task|null
     */
    public function save(Task $task) : Task
    {
        return $this->taskRepository->save($task);
    }
}
