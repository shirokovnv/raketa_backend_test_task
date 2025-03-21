<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Repositories;

use Raketa\BackendTestTask\Domain\Entities\Cart;

interface CartManagerInterface
{
    public function saveCart(Cart $cart, int $ttl);
    public function getCart(): ?Cart;
}