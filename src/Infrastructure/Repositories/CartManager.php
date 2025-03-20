<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Repositories;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Entities\Cart;
use Raketa\BackendTestTask\Infrastructure\Database\ConnectorInterface;

class CartManager extends ConnectorFacade
{
    /**
     * Период сохранения корзины.
     *
     * @var int
     */
    public static int $TTL = 24 * 60 * 60;

    public function __construct(
        private readonly ConnectorInterface $connector,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function saveCart(Cart $cart, int $ttl)
    {
        try {
            $this->connector->set(session_id(), $cart, $ttl);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @return ?Cart
     * @throws Exception
     */
    public function getCart(): ?Cart
    {
        try {
            $cart = $this->connector->get(session_id());
            // TODO: если здесь NULL, а мы два раза или более вызовем `getCart`, то может случиться проблема
            // дублирования корзины. Не нужно ли здесь сохранять пустой стейт корзины в Redis ?
        } catch (Exception $e) { // TODO: map exception to specific ?
            $this->logger->error($e->getMessage());
            throw $e;
        }

        return $cart ?? new Cart(session_id(), []);
    }
}
