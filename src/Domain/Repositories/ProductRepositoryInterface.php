<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Repositories;

use Raketa\BackendTestTask\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Product
     */
    public function getByUuid(string $uuid): Product;

    /**
     * @param string $category
     * @return array<Product>
     */
    public function getByCategory(string $category): array;

    /**
     * Функция возвращает ассоциативный массив { "uuid" => Product }.
     *
     * @param array $uuids
     * @return array<string, Product>
     */
    public function getByUuidList(array $uuids): array;
}