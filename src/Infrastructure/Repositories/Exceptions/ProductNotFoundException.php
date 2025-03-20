<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Repositories\Exceptions;

class ProductNotFoundException extends \Exception
{
    protected $message = 'Product not found';
}