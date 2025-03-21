<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Entities;

final readonly class CartItem
{
    public function __construct(
        private string $uuid,
        private string $productUuid,
        private int $price,
        private int $quantity,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
