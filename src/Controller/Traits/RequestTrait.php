<?php

namespace App\Controller\Traits;

use App\Exception\InvalidContentTypeException;
use Symfony\Component\HttpFoundation\Request;

trait RequestTrait
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public function getJsonContent(Request $request) : array
    {
        if ($request->headers->get('content-type') === 'application/json') {
            dump(json_decode($request->getContent(), true, 10, JSON_THROW_ON_ERROR));
            return json_decode($request->getContent(), true, 10, JSON_THROW_ON_ERROR) ?? [];
        }

        throw new InvalidContentTypeException('Invalid content-type');
    }
}
