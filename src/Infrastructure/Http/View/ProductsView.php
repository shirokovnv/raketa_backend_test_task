<?php

namespace Raketa\BackendTestTask\Infrastructure\Http\View;

use Raketa\BackendTestTask\Domain\Entities\Product;

readonly class ProductsView
{
    /**
     * @param array $products
     * @return array<Product>
     */
    public function toArray(array $products): array
    {
        return array_map(
            fn (Product $product) => [
                'id' => $product->getId(),
                'uuid' => $product->getUuid(),
                'category' => $product->getCategory(),
                'description' => $product->getDescription(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getPrice(),
            ],
            $products
        );
    }
}
