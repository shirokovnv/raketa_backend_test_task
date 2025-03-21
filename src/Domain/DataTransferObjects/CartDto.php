<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\DataTransferObjects;

use Raketa\BackendTestTask\Domain\Entities\Cart;
use Raketa\BackendTestTask\Domain\Entities\Product;

final class CartDto
{
    public function __construct(private readonly Cart $cart, private array $products){
    }

    /**
     * @return array<string, Product>
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }
}