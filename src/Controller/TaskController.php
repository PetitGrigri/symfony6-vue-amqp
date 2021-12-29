<?php

namespace App\Controller;

use App\Controller\Traits\RequestTrait;
use App\Form\TaskType;
use App\Exception\FormException;
use App\Exception\InvalidContentTypeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task', name: "task_")]
class TaskController extends AbstractController
{
    use RequestTrait;

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

        $form = $this->createForm(TaskType::class, []);
        $form->submit($jsonContent);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            // TODO Create Message to consume

            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        }

        throw new FormException($form);
    }


}
