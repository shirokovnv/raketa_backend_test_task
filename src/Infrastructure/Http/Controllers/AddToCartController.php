<?php

namespace Raketa\BackendTestTask\Infrastructure\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\CartItem;
use Raketa\BackendTestTask\Domain\UseCases\AddToCartUseCase;
use Raketa\BackendTestTask\Infrastructure\Http\View\CartView;
use Raketa\BackendTestTask\Infrastructure\Repositories\Exceptions\CartNotInitializedException;
use Raketa\BackendTestTask\Infrastructure\Repositories\Exceptions\ProductNotFoundException;
use Ramsey\Uuid\Uuid;

readonly class AddToCartController extends AbstractController
{
    public function __construct(
        private AddToCartUseCase $addToCartUseCase,
        private CartView $cartView,
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $response = new JsonResponse();
        $response = $this->withJsonHeaders($response);

        try {
            $cartDto = $this->addToCartUseCase->process($rawRequest['productUuid'], $rawRequest['quantity']);
            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 'success',
                        'cart' => $this->cartView->toArray($cartDto)
                    ],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );
            $response = $this->withOkStatus($response);

        } catch (ProductNotFoundException $exception) {
            // write message with product not found
        }
        catch (CartNotInitializedException $exception) {
            // write message with cart not found
        }
        catch (\Exception $exception) {
            // write message with base exception
        }

        return $response;
    }
}
