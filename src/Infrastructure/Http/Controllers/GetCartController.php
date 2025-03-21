<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\UseCases\GetCartUseCase;
use Raketa\BackendTestTask\Infrastructure\Http\View\CartView;

readonly class GetCartController extends AbstractController
{
    public function __construct(
        private GetCartUseCase $getCartUseCase,
        private CartView $cartView
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $response = new JsonResponse();
        $response = $this->withJsonHeaders($response);

        try {
            $cartDto = $this->getCartUseCase->process();

            $response->getBody()->write(
                json_encode(
                    $this->cartView->toArray($cartDto),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );

            $response = $this->withOkStatus($response);

        } catch (\Exception $exception) {
            // write message about cart not found... etc...
        }

        return $response;
    }
}
