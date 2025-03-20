<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Database;

use Raketa\BackendTestTask\Domain\Entities\Cart;

interface ConnectorInterface
{
    public function get(Cart $key);
    public function set(string $key, Cart $value, int $ttl);
    public function has($key): bool;
}