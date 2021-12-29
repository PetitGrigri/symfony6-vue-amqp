<?php

namespace App\Exception;

use RuntimeException;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormException extends HttpException
{
    const INVALID_FORM_MESSAGE = 'Invalid data';

    protected array $errors = [];

    public function __construct(
        FormInterface $form,
        int $statusCode = 422, 
        string $message = self::INVALID_FORM_MESSAGE, 
        \Throwable $previous = null, 
        array $headers = [], 
        int $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->errors = $this->parseErrors($form->getErrors(true));
    }

    /**
     * Parse FormErrorIterator to generate an array of errors
     *
     * @param FormErrorIterator $formErrorIterator
     * @return array
     */
    protected function parseErrors(FormErrorIterator $formErrorIterator) : array

    {
        $errors = [];

        foreach($formErrorIterator as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $errors;
    }
    
    public function getErrors() : array
    {
        return $this->errors;
    }
}
