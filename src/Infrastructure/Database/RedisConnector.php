<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Database;

use Raketa\BackendTestTask\Domain\Entities\Cart;
use Redis;
use RedisException;

final class RedisConnector implements ConnectorInterface
{
    private Redis $redis;

    public function __construct(
        private LoggerInterface $logger,
        private string $host,
        private int $port = 6379,
        private ?string $password = null,
        private ?int $dbindex = null)
    {
        // TODO: рассмотреть использование Singleton, если кол-во коннекшн-ов будет велико
        $this->initializeRedis();
    }

    /**
     * @throws ConnectorException
     */
    public function get(Cart $key)
    {
        try {
            return unserialize($this->redis->get($key));
        } catch (RedisException $e) {
            throw new ConnectorException('RedisConnector error', $e->getCode(), $e);
        }
    }

    /**
     * @throws ConnectorException
     */
    public function set(string $key, Cart $value, int $ttl)
    {
        try {
            $this->redis->setex($key, $ttl, serialize($value));
        } catch (RedisException $e) {
            throw new ConnectorException('RedisConnector error', $e->getCode(), $e);
        }
    }

    public function has($key): bool
    {
        return $this->redis->exists($key);
    }

    private function initializeRedis() {
        $this->redis = new Redis();

        try {
            $isConnected = $this->redis->isConnected();
            if (! $isConnected && $this->redis->ping('Pong')) {
                $isConnected = $this->redis->connect(
                    $this->host,
                    $this->port,
                );
            }

            if ($isConnected) {
                $this->redis->auth($this->password);
                $this->redis->select($this->dbindex);
            }

        } catch (RedisException $exception) {
            $logger->error('Redis exception: ' . $exception->getMessage());
        }
    }
}
