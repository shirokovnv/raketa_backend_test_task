<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\UseCases;

use Raketa\BackendTestTask\Domain\DataTransferObjects\CartDto;
use Raketa\BackendTestTask\Domain\Repositories\ProductRepositoryInterface;
use Raketa\BackendTestTask\Infrastructure\Repositories\CartManager;

class GetCartUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CartManager $cartManager)
    {
    }

    /**
     * @throws \Exception
     */
    public function process(): CartDto
    {
        $cart = $this->cartManager->getCart();

        $productUuids = array_column($cart->getItems(), 'uuid');
        $products = $this->productRepository->getByUuidList($productUuids);

        return new CartDto($cart, $products);
    }
}