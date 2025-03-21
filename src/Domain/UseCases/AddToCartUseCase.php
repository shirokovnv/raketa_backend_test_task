<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\UseCases;

use Raketa\BackendTestTask\Domain\DataTransferObjects\CartDto;
use Raketa\BackendTestTask\Infrastructure\Repositories\CartManager;
use Raketa\BackendTestTask\Infrastructure\Repositories\ProductRepository;

class AddToCartUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private CartManager $cartManager,
    ) {
    }

    public function process(string $productUuid, int $productQuantity): CartDto {
        $product = $this->productRepository->getByUuid($productUuid);
        $cart = $this->cartManager->getCart();

        $cart->addItem(new CartItem(
            Uuid::uuid4()->toString(),
            $product->getUuid(),
            $product->getPrice(),
            $productQuantity,
        ));

        $productUuids = array_column($cart->getItems(), 'uuid');
        $products = $this->productRepository->getByUuidList($productUuids);

        return new CartDto($cart, $products);
    }
}