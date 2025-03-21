<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Repositories;

use Doctrine\DBAL\Connection;
use Raketa\BackendTestTask\Domain\Entities\Product;
use Raketa\BackendTestTask\Domain\Repositories\ProductRepositoryInterface;
use Raketa\BackendTestTask\Infrastructure\Repositories\Exception;
use Raketa\BackendTestTask\Infrastructure\Repositories\Exceptions\ProductNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws ProductNotFoundException
     */
    public function getByUuid(string $uuid): Product
    {
        $sql = "SELECT * FROM products WHERE uuid = :uuid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("uuid", $uuid);

        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchOne();

        if (empty($row)) {
            throw new ProductNotFoundException();
        }

        return $this->make($row);
    }

    public function getByCategory(string $category): array
    {
        $sql = "SELECT id FROM products WHERE is_active = 1 AND category = :category";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("category", $category);

        $resultSet = $stmt->executeQuery();

        return array_map(
            static fn (array $row): Product => $this->make($row),
            $resultSet->fetchAllAssociative()
        );
    }

    public function getByUuidList(array $uuids): array
    {
        // TODO: Implement getByUuidList() method.
    }

    private function make(array $row): Product
    {
        return new Product(
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
