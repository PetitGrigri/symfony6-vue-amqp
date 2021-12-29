<?php

namespace App\EventListener;

use App\Exception\InvalidContentTypeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class InvalidContentTypeExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if  (($throwable = $event->getThrowable()) instanceof InvalidContentTypeException) {
            /** @var InvalidContentTypeException $throwable  */

            $event->setResponse(
                new JsonResponse([
                    'status'    => 414,
                    'message'   => $throwable->getMessage(),
                ], 414)
            );

        }
    }
}
