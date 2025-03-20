<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\UseCases\GetProductsUseCase;
use Raketa\BackendTestTask\Infrastructure\Http\View\ProductsView;

readonly class GetProductsController extends AbstractController
{
    public function __construct(
        private GetProductsUseCase $getProductsUseCase,
        private ProductsView $productsView
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);

        $response = new JsonResponse();
        $response = $this->withJsonHeaders($response);

        try {
            $products = $this->getProductsUseCase->process($rawRequest['category']);
            $response->getBody()->write(
                json_encode(
                    $this->productsView->toArray($products),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );

            $response = $this->withOkStatus($response);

        } catch (\Exception $exception) {
            // write info about errors...
        }

        return $response;
    }
}
