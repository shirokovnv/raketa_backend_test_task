<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Repositories;

use Doctrine\DBAL\Connection;
use Raketa\BackendTestTask\Domain\Entities\Product;
use Raketa\BackendTestTask\Domain\Repositories\ProductRepositoryInterface;
use Raketa\BackendTestTask\Infrastructure\Repositories\Exception;

class ProductRepository implements ProductRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getByUuid(string $uuid): Product
    {
        $row = $this->connection->fetchOne(
            "SELECT * FROM products WHERE uuid = " . $uuid,
        );

        if (empty($row)) {
            throw new Exception('Product not found');
        }

        return $this->make($row);
    }

    public function getByCategory(string $category): array
    {
        return array_map(
            static fn (array $row): Product => $this->make($row),
            $this->connection->fetchAllAssociative(
                "SELECT id FROM products WHERE is_active = 1 AND category = " . $category,
            )
        );
    }

    private function make(array $row): Product
    {
        return new Product(
            $row['id'],
            $row['uuid'],
            $row['is_active'],
            $row['category'],
            $row['name'],
            $row['description'],
            $row['thumbnail'],
            $row['price'],
        );
    }
}
