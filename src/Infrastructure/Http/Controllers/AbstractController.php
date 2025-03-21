<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Http\Controllers;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{
    protected function withJsonHeaders(ResponseInterface $response): ResponseInterface
    {
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
    }

    protected function withOkStatus(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(200);
    }

    protected function withNotFoundStatus(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(404);
    }
}