<?php

namespace App\EventListener;

use App\Exception\FormException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class FormExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if  (($throwable = $event->getThrowable()) instanceof FormException) {
            /** @var FormException $throwable  */
            $event->setResponse(
                new JsonResponse([
                    'status'    => $throwable->getStatusCode(),
                    'message'   => $throwable->getMessage(),
                    'errors'    => $throwable->getErrors()
                ], $throwable->getStatusCode())
            );

        }
    }
}
