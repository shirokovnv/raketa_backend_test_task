<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\UseCases;

use Raketa\BackendTestTask\Domain\Entities\Product;
use Raketa\BackendTestTask\Domain\Repositories\ProductRepositoryInterface;

class GetProductsUseCase
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * @param string $category
     * @return array<Product>
     */
    public function process(string $category): array {
        return $this->productRepository->getByCategory($category);
    }
}