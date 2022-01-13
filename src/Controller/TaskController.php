<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Exception\FormException;
use App\Controller\Traits\RequestTrait;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\InvalidContentTypeException;
use App\Service\TaskService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/task', name: "task_")]
class TaskController extends AbstractController
{
    use RequestTrait;

    /**
     * Class constructor.
     */
    public function __construct(
        private TaskService $taskService
    ){ }

    /**
     * Create a new Task
     *
     * @param Request $request
     *
     * @throws FormException
     * @throws InvalidContentTypeException
     * 
     * @return Response

     */
    #[Route('/add', methods: ["POST"], name: 'add')]
    public function addTask(Request $request): Response
    {
        $jsonContent = $this->getJsonContent($request);
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->submit($jsonContent);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->create($task);

            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        }

        throw new FormException($form);
    }


}
